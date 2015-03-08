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
	<p><?php _e('Retrieve a list of comments or a comment data given a comment ID.', 'vhm-show-comments'); ?></p>
	
	<form method="post" action="options.php"> 
		<?php @settings_fields('vhmShowCommentsGroup'); ?>
		<?php @do_settings_fields('vhmShowCommentsGroup'); ?>
		
		<h2 class="nav-tab-wrapper">
			<a href="#settings" class="nav-tab"><?php _e('Settings', 'vhm-show-comments'); ?></a>
			<a href="#usage" class="nav-tab"><?php _e('Usage', 'vhm-show-comments'); ?></a>
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
						<th scope="row"><label for="before_items"><?php _e('Before items', 'vhm-show-comments')?></label></th>
						<td>
							<input type="text" name="vhmShowCommentsSettings[before_items]" id="show_quantity" value="<?php echo (!empty($options['before_items'])) ? esc_attr($options['before_items']) : '<ol>' ; ?>" />
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
				<h3><?php _e('Usage', 'vhm-show-comments'); ?></h3>
				<ol>
					<li>
						<?php 
							printf(
								__('Use the shortcode %s in the content of the pages, posts or text widgets;', 'vhm-show-comments'),
								'<code>[vhm-show-comments]</code>'
							);
							?>
						</li>
					<li>
						<?php 
							printf(
								__('or use the PHP code %s in your template.', 'vhm-show-comments'),
								'<code>&lt;?php echo vhm_show_comments(); ?&gt;</code>'
							);
						?>
					</li>
				</ol>
			
				<h3><?php _e('Parameters', 'vhm-show-comments'); ?></h3>
				<dl>
					<dt><tt>$number</tt></dt>
					<dd>
						(int) The number of the comments to show
						<dl>
							Default: 5
						</dl>
					</dd>
					<dt><tt>$id</tt></dt>
					<dd>
						(int) (option) The ID of the comment you'd like to fetch
						<dl>
							Default: None
						</dl>
					</dd>
					<dt><tt>$post_id</tt></dt>
					<dd>
						(int) (option) The ID of the post you'd like to fetch the comments
						<dl>
							Default: None
						</dl>
					</dd>
				</dl>
			
				<h3><?php _e('Examples', 'vhm-show-comments'); ?></h3>
				<p><?php _e('Show the last 3 comments:', 'vhm-show-comments'); ?></p>
				<pre>[vhm_show_comments number="3"]</pre>
				
				<p><?php _e('Show the comment with the ID 1:', 'vhm-show-comments'); ?></p>
				<pre>[vhm_show_comments id="1"]</pre>
				
				<p><?php _e('Show 3 comments from the post with the ID 2:', 'vhm-show-comments'); ?></p>
				<pre>[vhm_show_comments number="3" post_id="2"]</pre>
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