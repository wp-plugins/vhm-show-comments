<?php
/**
 * Plugin Name: VHM Show Comments
 * Plugin URI: http://viktormorales.com
 * Description: Show comments on your pages, posts, sidebar with a shortcode or PHP code
 * Version: 1.4
 * Author: Viktor H. Morales
 * Author URI: http://viktormorales.com
 * Text Domain: viktormorales
 * Domain Path: /languages/
 * Network: true
 * License: GPL2
 */
 
 /*  Copyright 2015  Viktor H. Morales  (email : viktorhugomorales@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('VHM_Show_Comments'))
{
    class VHM_Show_Comments
    {
		private $options;
		private $table_name;
		private $plugin_url;
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
			global $wpdb;
			
			$this->options = get_option( 'vhmShowCommentsSettings' );
			$this->table_name = $wpdb->prefix . 'vhm_show_comments';
			$this->plugin_url = admin_url('edit-comments.php?page=vhm_show_comments');
			
			load_plugin_textdomain('vhm-show-comments', '', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
							
			register_activation_hook( __FILE__, array( &$this, 'activate' ) );
			register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

			add_action( 'admin_menu', array(&$this, 'admin_menu') );
            add_action( 'admin_init', array(&$this, 'admin_init') );
			
			add_action( 'admin_head', array(&$this, 'tinymce_button') );
			add_action( 'admin_enqueue_scripts', array(&$this, 'tinymce_css') );
        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            global $wpdb;
			
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $this->table_name (
				ID int(11) NOT NULL AUTO_INCREMENT,
				item_title TEXT NULL,
				item_source VARCHAR(8) NULL,
				item_source_id INT NULL,
				item_number INT(11) NULL,
				item_order VARCHAR(4) NULL,
				item_before TEXT NULL,
				item_loop LONGTEXT NULL,
				item_after TEXT NULL,
				PRIMARY KEY (ID),
				UNIQUE KEY ID (ID)
			) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			
			
        } // END public static function activate

        /**
         * Deactivate the plugin
         */     
        public static function deactivate()
        {
        
        } // END public static function deactivate

		/**
		 * add a menu
		 */     
		public function admin_menu()
		{
			add_comments_page(
				'VHM Show Comments', 
				'VHM Show Comments', 
				'manage_options', 
				'vhm_show_comments', 
				array(&$this, 'settings_page')
			);
			
		} // END public function admin_menu()
		
		/**
		 * hook into WP's admin_init action hook
		 */
		public function admin_init()
		{
			global $wpdb;
			
			// Set up the settings for this plugin
			register_setting(
				'vhmShowCommentsGroup', // Option group
				'vhmShowCommentsSettings', // Option name
				array( $this, 'sanitize' ) // Sanitize
			);
			
			
			$default = array(
				'ID' => 0,
				'item_title' => '',
				'item_source' => '',
				'item_source_id' => '',
				'item_number' => '',
				'item_order' => '',
				'item_before' => '',
				'item_loop' => '',
				'item_after' => ''
			);
			
			if (wp_verify_nonce($_POST['_wpnonce'], 'vhmShowCommentsGroup-options')) 
			{
				
				$insert = shortcode_atts( $default, array_map('stripslashes_deep', $_REQUEST) );
				
				$result = $wpdb->insert($this->table_name, $insert, array('%d', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s'));
                $insert['id'] = $wpdb->insert_id;
                if ($result) {
					wp_redirect( $this->plugin_url . '&tab=shortcodes&message=created' );
                } else {
					wp_redirect( $this->plugin_url . '&tab=shortcodes&message=not-created' );
                }
				
			}
			
			if ($_REQUEST['action'] == 'trash' && !empty($_REQUEST['id']))
			{
				$delete = $wpdb->delete( $this->table_name, array('ID' => $_REQUEST['id']) );
				if ($delete)
					wp_redirect( $this->plugin_url . '&tab=shortcodes&message=deleted' );
				else
					wp_redirect( $this->plugin_url . '&tab=shortcodes&message=not-deleted' );
			}
			
			// Possibly do additional admin_init tasks
		} // END public static function activate
		
		/**
		 * Menu Callback
		 */     
		public function settings_page()
		{
			global $wpdb;
			
			if(!current_user_can('manage_options'))
			{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			
			$sql = 'SELECT * FROM ' . $wpdb->prefix . 'vhm_show_comments';
			$shortcodes = $wpdb->get_results($sql);
			// Render the settings template
			include(sprintf("%s/settings.php", dirname(__FILE__)));
		} // END public function settings_page()
		
		public function output( $atts = false )
		{
			global $wpdb;
			
			// Get the shortcode/function arguments
			extract( shortcode_atts( array(
				'id' => ($id) ? $id : false,
			), $atts ) );
			
			// Get the shortcode values from DB
			$sql = 'SELECT * FROM ' . $wpdb->prefix. 'vhm_show_comments WHERE ID="' . $id . '"';
			$select_item = $wpdb->get_row($sql);
			
			if ($select_item)
			{
				$out = '';
				// Print the before_items option
				if ($select_item->item_before)
				{
					$out .= $select_item->item_before;
				}
				
				$sql = 'SELECT c.* FROM wp_comments AS c';
				
				$where = ' WHERE 1';
				if ($select_item->item_source == 'user')
				{
					$where = ' WHERE c.comment_ID = ' . $select_item->item_source_id;
				}
				elseif ($select_item->item_source == 'post')
				{
					$where = ' WHERE c.comment_post_ID = ' . $select_item->item_source_id;
				}
				elseif ($select_item->item_source == 'category')
				{
					$sql .= ' LEFT JOIN wp_posts AS p ON c.comment_post_ID=p.ID';
					$sql .= ' LEFT JOIN wp_term_relationships AS tr ON tr.object_id = p.ID';
					$where = ' WHERE tr.term_taxonomy_id = ' . $select_item->item_source_id;
				}
				
				$sql .= $where . ' AND c.comment_approved="1" GROUP BY c.comment_ID';
				
				if ($select_item->item_order == 'ASC' || $select_item->item_order == 'DESC')
					$sql .= ' ORDER BY c.comment_ID ' . $select_item->item_order;
				else
					$sql .= ' ORDER BY RAND()';
				
				if ($select_item->item_number)
					$sql .= ' LIMIT ' . $select_item->item_number;
				
				$comments = $wpdb->get_results( $sql, OBJECT );
				if ($comments):
					foreach ($comments as $comment)
					{
						$out .= str_replace(
							array( "%COMMENT%", "%URL%", "%AUTHOR%", "%POST_URL%", "%POST_TITLE%" ),
							array( $comment->comment_content, $comment->comment_author_url, $comment->comment_author, get_permalink($comment->comment_post_ID), get_the_title($comment->comment_post_ID) ),
							$select_item->item_loop
						);
					}
				endif;
				
				// Print the after_items option
				if ($select_item->item_after)
					$out .= $select_item->item_after;
				
			}
			
			return $out;
		}

		public function tinymce_button() {
			global $typenow;
			
			if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
				return;
			}
			
			if( ! in_array( $typenow, array( 'post', 'page' ) ) )
				return;
			
			if ( get_user_option('rich_editing') == 'true') {
				add_filter('mce_external_plugins', array(&$this, 'add_tinymce_plugin') );
				add_filter('mce_buttons_2', array(&$this, 'register_tinymce_button') );
			}
		}
		
		public function add_tinymce_plugin($plugin_array) {
			$plugin_array['vhmShowComments_button'] = plugins_url( '/js/popup-button.js', __FILE__ ); // CHANGE THE BUTTON SCRIPT HERE/
			return $plugin_array;
		}
		
		public function register_tinymce_button($buttons) {
		   array_unshift($buttons, 'vhmShowComments_button');
		   return $buttons;
		}
		
		public function tinymce_css() {
			wp_enqueue_style('vhm_show_comments', plugins_url('/style.css', __FILE__));
		}

    } // END class VHM_Show_Comments
} // END if(!class_exists('VHM_Show_Comments'))


// instantiate the plugin class
$VHM_Show_Comments = new VHM_Show_Comments();

function vhm_show_comments( $atts = false )
{
	global $VHM_Show_Comments;
	return $VHM_Show_Comments->output( $atts );
}
add_shortcode( 'vhm_show_comments', 'vhm_show_comments' );

add_filter('widget_text', 'do_shortcode');
