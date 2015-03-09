<?php $options = get_option( 'vhmShowCommentsSettings' ); ?>
<div class="wrap">
    <h2>VHM Show Comments</h2>
	
	<script>
		jQuery(function() {
			
			jQuery('.nav-tab-wrapper').find('a:eq(0)').addClass('nav-tab-active');
			jQuery('#tabs > div:eq(0)').nextAll().hide();
		
			jQuery('.nav-tab').click(function(e){
				e.preventDefault();
				jQuery('.nav-tab').removeClass('nav-tab-active');
				jQuery('#tabs > div').hide();
				
				jQuery(this).addClass('nav-tab-active');
				
				var index = jQuery('.nav-tab').index(this);
				jQuery('#tabs > div:eq(' + index + ')').show();
			})
		});
	</script>
	
	<h3><?php _e('Description', 'vhm-show-comments'); ?></h3>
	<p><?php _e('Get a list of comments (or a single comment providing its ID) and show them on a page, post or sidebar using a shortcode or a PHP code.', 'vhm-show-comments'); ?></p>
	
	<form method="post" action="options.php"> 
		<?php @settings_fields('vhmShowCommentsGroup'); ?>
		<?php @do_settings_fields('vhmShowCommentsGroup'); ?>
		
		<h2 class="nav-tab-wrapper">
			<a href="#settings" class="nav-tab">1. <?php _e('Settings', 'vhm-show-comments'); ?></a>
			<a href="#usage" class="nav-tab">2. <?php _e('Usage', 'vhm-show-comments'); ?></a>
			<a href="#about" class="nav-tab"><?php _e('About', 'vhm-show-comments'); ?></a>
		</h2>	
		
		<div id="tabs">
			<div id="settings">
				<h3><?php _e('General settings', 'vhm-show-comments')?></h3>
				
				<table class="form-table">  
					<tr valign="top">
						<th scope="row"><label for="show_quantity"><?php _e('Number of comments to show', 'vhm-show-comments')?></label></th>
						<td>
							<input type="text" name="vhmShowCommentsSettings[show_quantity]" id="show_quantity" value="<?php echo (!empty($options['show_quantity'])) ? $options['show_quantity'] : 0 ; ?>" />
							<p class="description"><?php printf( __('%s to hide the comments', 'vhm-show-comments'), 0 ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="order"><?php _e('Order by', 'vhm-show-comments')?></label></th>
						<td>
							<select name="vhmShowCommentsSettings[order]">
								<option value="DESC"<?php echo ($options['order'] == 'DESC') ? ' selected="selected"' : false ; ?>><?php _e('Descendant', 'vhm-show-comments'); ?></option>
								<option value="ASC"<?php echo ($options['order'] == 'ASC') ? ' selected="selected"' : false ; ?>><?php _e('Ascendant', 'vhm-show-comments'); ?></option>
								<option value="RAND"<?php echo ($options['order'] == 'RAND') ? ' selected="selected"' : false ; ?>><?php _e('Random', 'vhm-show-comments'); ?></option>
							</select>
							<p class="description"><?php _e('Choose how the comments should be ordered', 'vhm-show-comments'); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="before_items"><?php _e('Before items', 'vhm-show-comments'); ?></label></th>
						<td>
							<input type="text" name="vhmShowCommentsSettings[before_items]" id="before_items" value="<?php echo (!empty($options['before_items'])) ? esc_attr($options['before_items']) : '<ol>' ; ?>" />
							<p class="description">
								<?php 
									printf(
										__('Add any content BEFORE displaying the comments', 'vhm-show-comments'), 
										false
									);
								?>
							</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="items_template"><?php _e('Template', 'vhm-show-comments')?></label></th>
						<td>
							<textarea name="vhmShowCommentsSettings[items_template]" id="show_quantity" style="width:100%" rows="10"><?php if (!empty($options['items_template'])) : echo esc_attr($options['items_template']); else:  ?><li>
		"%COMMENT%" 
		&mdash; <a href="%URL%">%AUTHOR%</a>
		</li><?php endif; ?></textarea>
							<strong><?php _e('Variables', 'vhm-show-comments'); ?></strong>
							<p class="description"><?php _e('%COMMENT% is the comment', 'vhm-show-comments'); ?></p>
							<p class="description"><?php _e('%URL% is the URL provided by the author of the comment', 'vhm-show-comments'); ?></p>
							<p class="description"><?php _e('%AUTHOR% is the name of the author of the comment', 'vhm-show-comments'); ?></p>
							<p class="description"><?php _e('%POST_TITLE% is the title of the post where the user left the comment', 'vhm-show-comments'); ?></p>
							<p class="description"><?php _e('%POST_URL% is the URL of the post where the user left the comment', 'vhm-show-comments'); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="after_items"><?php _e('After items', 'vhm-show-comments')?></label></th>
						<td>
							<input type="text" name="vhmShowCommentsSettings[after_items]" id="show_quantity" value="<?php echo (!empty($options['after_items'])) ? esc_attr($options['after_items']) : '</ol>' ; ?>" />
							<p class="description">
							<?php 
								printf(
									__('Add any content AFTER displaying the comments', 'vhm-show-comments'), 
									false
								);
							?>
							</p>
						</td>
					</tr>
				</table>
			</div>
				
			<div id="usage">
				<h3><?php _e( 'Usage', 'vhm-show-comments' ); ?></h3>
				<p><?php _e( 'Copy and paste the following shortcode directly into the post, page or sidebar (widget) where you would like to show the comments:', 'vhm-show-comments' ); ?></p>
				<p><input type="text" value="[vhm_show_comments]" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select();" /></p>
				
				<p><?php _e('Or copy and paste the following PHP code on your templates files:', 'vhm-show-comments'); ?></p>
				<p><input type="text" value="&lt;?php echo vhm_show_comments(); ?&gt;" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select();" /></p>
				
				<hr>
				<h3><?php _e('Parameters and examples', 'vhm-show-comments'); ?></h3>
				<table class="wp-list-table widefat fixed tags">
					<thead>
						<tr>
							<th scope="col" class="column-cb desc" style=""><?php _e( 'Option', 'vhm-show-comments' ); ?></th>
							<th scope="col" class="column-name desc" style=""><?php _e('Description', 'vhm-show-comments')?></th>
							<th scope="col" class="column-description desc" style=""><?php _e( 'Example', 'vhm-show-comments' ); ?></th>	
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="column-cb" style=""><?php _e( 'Option', 'vhm-show-comments' ); ?></th>
							<th scope="col" class="column-name desc" style=""><?php _e('Description', 'vhm-show-comments')?></th>
							<th scope="col" class="column-description" style=""><?php _e( 'Example', 'vhm-show-comments' ); ?></th>	
						</tr>
					</tfoot>
					<tbody>
						<tr class="alternate">		
							<td class="column-name">
								<p><strong>(int) (optional) $number</strong></p>
								<p><?php printf( __( 'Default: %s', 'vhm-show-comments' ), '<em>5</em>' )?></p>
							</td>
							<td class="column-description">
								<?php _e( 'The number of the comments to show', 'vhm-show-comments' ); ?>
							</td>
							<td><code>[vhm_show_comments number="2"]</code></td>
						</tr>
						<tr>		
							<td class="column-name">
								<p><strong>(string) (optional) $order</strong></p>
								<p><?php _e( 'Values:', 'vhm-show-comments' ); ?></p>
								<ul>
									<li>- 'ASC', ascendant order</li>
									<li>- 'DESC', descendant order</li>
									<li>- 'RAND', random order</li>
								</ul>
								<p><?php printf( __( 'Default: %s', 'vhm-show-comments' ), '<em>DESC</em>' )?></p>
							</td>
							<td class="column-description">
								<?php _e( 'The order of how you\'d like to show the comments', 'vhm-show-comments' ); ?>
							</td>
							<td><code>[vhm_show_comments order="ASC"]</code></td>
						</tr>
						<tr class="alternate">		
							<td class="column-name">
								<p><strong>(int) (optional) $id</strong></p>
								<p><?php printf( __( 'Default: %s', 'vhm-show-comments' ), '<em>false</em>' )?></p>
							</td>
							<td class="column-description">
								<?php _e( 'The ID of the comment you\'d like to fetch', 'vhm-show-comments' ); ?>
							</td>
							<td><code>[vhm_show_comments id="45"]</code></td>
						</tr>
						<tr>		
							<td class="column-name">
								<p><strong>(int) (optional) $post_id</strong></p>
								<p><?php printf( __( 'Default: %s', 'vhm-show-comments' ), '<em>false</em>' )?></p>
							</td>
							<td class="column-description">
								<?php _e( 'The ID of the post you\'d like to fetch the comments', 'vhm-show-comments' ); ?>
							</td>
							<td><code>[vhm_show_comments post_id="206"]</code></td>
						</tr>
						<tr class="alternate">		
							<td class="column-name">
								<p><strong>(int) (optional) $tag_id</strong></p>
								<p><?php printf( __( 'Default: %s', 'vhm-show-comments' ), '<em>false</em>' )?></p>
							</td>
							<td class="column-description">
								<?php _e( 'The ID of the category or tag you\'d like to fetch the comments', 'vhm-show-comments' ); ?>
							</td>
							<td><code>[vhm_show_comments tag_id="8"]</code></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			
			<div id="about">
				<h3>About</h3>
				<p><strong><a href="http://viktormorales.com">Viktor H. Morales</a><strong> is a graphic and web designer.</p>
				
				<p>Contact me:</p>
				<ul>
					<li>Web: <a href="http://viktormorales.com">viktormorales.com</a></li>
					<li>Twitter: <a href="http://twitter.com/viktormorales">twitter.com/viktormorales</a></li>
					<li>Instagram: <a href="http://instagram.com/viktorhmorales">instagram.com/viktorhmorales</a></li>
				</ul>
			</div>
		</div>
		<?php @submit_button(); ?>
	</form>
	
</div>