<?php
/**
 * Plugin Name: VHM Show Comments
 * Plugin URI: http://viktormorales.com
 * Description: Show comments on your pages, posts, sidebar with a shortcode or PHP code
 * Version: 1.2
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
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
			$this->options = get_option( 'vhmShowCommentsSettings' );
			
			add_action('admin_menu', array(&$this, 'admin_menu'));
            add_action('admin_init', array(&$this, 'admin_init'));
			
        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        } // END public static function activate

        /**
         * Deactivate the plugin
         */     
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate
		
		/**
		 * add a menu
		 */     
		public function admin_menu()
		{
			add_options_page(
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
			// Set up the settings for this plugin
			register_setting(
				'vhmShowCommentsGroup', // Option group
				'vhmShowCommentsSettings', // Option name
				array( $this, 'sanitize' ) // Sanitize
			);
			// Possibly do additional admin_init tasks
		} // END public static function activate
		
		/**
		 * Sanitize each setting field as needed
		 *
		 * @param array $input Contains all settings fields as array keys
		 */
		public function sanitize( $input )
		{
			$new_input = array();
			if( isset( $input['show_quantity'] ) )
				$new_input['show_quantity'] = absint( $input['show_quantity'] );
				
			if( isset( $input['order'] ) )
				$new_input['order'] = $input['order'];
				
			if( isset( $input['before_items'] ) )
				$new_input['before_items'] = $input['before_items'];
				
			if( isset( $input['items_template'] ) )
				$new_input['items_template'] = $input['items_template'];
			
			if( isset( $input['after_items'] ) )
				$new_input['after_items'] =$input['after_items'];
				
			return $new_input;
		}
		/**
		 * Menu Callback
		 */     
		public function settings_page()
		{
			if(!current_user_can('manage_options'))
			{
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			
			 // Render the settings template
			include(sprintf("%s/settings.php", dirname(__FILE__)));
		} // END public function settings_page()
		
		public function output( $atts = false )
		{
			global $wpdb;
			
			// Get the shortcode/function arguments
			extract( shortcode_atts( array(
				'number' => ($number) ? $number : $this->options['show_quantity'],
				'id' => ($id) ? $id : false,
				'post_id' => ($post_id) ? $post_id : false,
				'order' => ($oder) ? 'DESC' : $this->options['order']
			), $atts ) );
			
			// Print the before_items option
			$out = $this->options['before_items'];
			
			$sql = 'SELECT * FROM wp_comments WHERE comment_approved="1"';
			if ($id)
			{
				$sql .= ' AND comment_ID = ' . $id;
				$sql .= ' LIMIT 1';
			}
			else 
			{
				if ($post_id)
					$sql .= ' AND comment_post_ID = ' . $post_id;
				if ($order == 'ASC' || $order == 'DESC')
					$sql .= ' ORDER BY comment_ID ' . $order;
				else
					$sql .= ' ORDER BY RAND()';
				if ($number)
					$sql .= ' LIMIT ' . $number;
			}
			
			$comments = $wpdb->get_results( $sql, OBJECT );
			if ($comments):
				foreach ($comments as $comment)
				{
					$out .= str_replace(
						array( "%COMMENT%", "%URL%", "%AUTHOR%", "%POST_URL%", "%POST_TITLE%" ),
						array( $comment->comment_content, $comment->comment_author_url, $comment->comment_author, get_permalink($comment->comment_post_ID), get_the_title($comment->comment_post_ID) ),
						$this->options['items_template'] 
					);
				}
			endif;
			
			// Print the after_items option
			$out .= $this->options['after_items'];
			
			return $out;
		}

    } // END class VHM_Show_Comments
} // END if(!class_exists('VHM_Show_Comments'))

if(class_exists('VHM_Show_Comments'))
{
	load_plugin_textdomain('vhm-show-comments', '', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('VHM_Show_Comments', 'activate'));
    register_deactivation_hook(__FILE__, array('VHM_Show_Comments', 'deactivate'));

    // instantiate the plugin class
    $VHM_Show_Comments = new VHM_Show_Comments();
	
	function vhm_show_comments( $atts = false )
	{
		global $VHM_Show_Comments;
		return $VHM_Show_Comments->output( $atts );
	}
	add_shortcode( 'vhm_show_comments', 'vhm_show_comments' );
	
	add_filter('widget_text', 'do_shortcode'); 
	
	function my_enqueue($hook) {
		if ( 'edit.php' != $hook ) {
			return;
		}

		wp_enqueue_script( 'jquery-ui-tabs', plugin_dir_url( __FILE__ ) . 'myscript.js' );
	}
	add_action( 'admin_enqueue_scripts', 'my_enqueue' );
}