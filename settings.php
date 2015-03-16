<?php $options = get_option( 'vhmShowCommentsSettings' ); ?>
<div class="wrap">
    <h2>VHM Show Comments</h2>
	
	<?php if ($_REQUEST['message'] == 'created'): ?>
		<div id="message" class="updated"><p><?php echo __('Shortcode was successfully CREATED.', 'vhm-show-comments'); ?></p></div>
    <?php elseif ($_REQUEST['message'] == 'not-created'): ?>
		<div id="notice" class="error"><p><?php echo __('Shortcode was NOT CREATED.', 'vhm-show-comments') ?></p></div>
	<?php elseif ($_REQUEST['message'] == 'deleted'):?>
		<div id="message" class="updated"><p><?php echo __('Shortcode was successfully DELETED.', 'vhm-show-comments'); ?></p></div>
    <?php endif;?>
	
	<h3><?php _e('Description', 'vhm-show-comments'); ?></h3>
	<p><?php _e('Get a list of comments (or a single comment providing its ID) and show them on a page, post or sidebar using a shortcode or a PHP code.', 'vhm-show-comments'); ?></p>
	
	
		<h2 class="nav-tab-wrapper">
			<a href="<?php echo admin_url('edit-comments.php?page=vhm_show_comments')?>" class="nav-tab<?php echo (empty($_REQUEST['tab'])) ? ' nav-tab-active' : false ; ?>">1. <?php _e('Usage', 'vhm-show-comments'); ?></a>
			<a href="<?php echo admin_url('edit-comments.php?page=vhm_show_comments&tab=generator')?>" class="nav-tab<?php echo ($_REQUEST['tab'] == 'generator') ? ' nav-tab-active' : false ; ?>">2. <?php _e('Shortcode Generator', 'vhm-show-comments'); ?></a>
			<a href="<?php echo admin_url('edit-comments.php?page=vhm_show_comments&tab=shortcodes')?>" class="nav-tab<?php echo ($_REQUEST['tab'] == 'shortcodes') ? ' nav-tab-active' : false ; ?>">3. <?php _e('My shortcodes', 'vhm-show-comments'); ?></a>
			<a href="<?php echo admin_url('edit-comments.php?page=vhm_show_comments&tab=about')?>" class="nav-tab<?php echo ($_REQUEST['tab'] == 'about') ? ' nav-tab-active' : false ; ?>"><?php _e('About', 'vhm-show-comments'); ?></a>
		</h2>	
			
			<?php if (empty($_REQUEST['tab'])): ?>
			<div id="usage">
				<h3><?php _e( 'Usage', 'vhm-show-comments' ); ?></h3>
				<ol>
					<li><?php printf( __( 'Generate a code from the %s tab', 'vhm-show-comments' ), '<a href="' . admin_url('edit-comments.php?page=vhm_show_comments&tab=generator') . '">"Shortcode Generator"</a>' ); ?></li>
					<li><?php _e( 'Copy and paste the shortcode into your pages, posts or text widget.', 'vhm-show-comments' ); ?></li>
				</ol>
				
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
								<p><strong><em>(int) (required)</em> $id</strong></p>
								<p><?php printf( __( 'Default: %s', 'vhm-show-comments' ), '<em>false</em>' )?></p>
							</td>
							<td class="column-description">
								<?php _e( 'The ID of the generated shortcode', 'vhm-show-comments' ); ?>
							</td>
							<td>
								<p>Shortcode: <br /><code>[vhm_show_comments id="2"]</code></p>
								<p>PHP code: <br /><code>&lt;?php echo vhm_show_comments(array('id' => 2)); ?&gt;</code></p>
								
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<?php elseif ($_REQUEST['tab'] == 'generator'): ?>
			<form method="post"> 
			<?php @settings_fields('vhmShowCommentsGroup'); ?>
			<?php @do_settings_fields('vhmShowCommentsGroup'); ?>
		
			<div id="generator">
				<h3><?php _e('Shortcode Generator', 'vhm-show-comments')?></h3>
				<p><?php _e('Use this form to generate a shortcode to paste into your pages, posts or widget text.', 'vhm-show-comments')?></p>
				<table class="form-table">  
					
					<tr valign="top">
						<th scope="row"><label for="item_title"><?php _e('Title of the shortcode', 'vhm-show-comments')?></label></th>
						<td>
							<input type="text" name="item_title" id="item_title" value="" />
							<p class="description"><?php printf( __('Title of the shortcode', 'vhm-show-comments'), 0 ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="source"><?php _e('Source', 'vhm-show-comments')?></label></th>
						<td>
							<select id="source" name="item_source">
								<option value="post"><?php _e('Post/Page', 'vhm-show-comments'); ?></option>
								<option value="category"><?php _e('Category', 'vhm-show-comments'); ?></option>
								<option value="user"><?php _e('User comment', 'vhm-show-comments'); ?></option>
							</select>
							<p class="description"><?php _e('Choose the source of the comments to show', 'vhm-show-comments'); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="source_id"><?php _e('ID of the source', 'vhm-show-comments')?></label></th>
						<td>
							<input type="text" name="item_source_id" id="source_id" value="<?php echo (!empty($options['source_id'])) ? $options['source_id'] : 0 ; ?>" />
							<p class="description"><?php printf( __('Insert the ID of the page, post, category, tag or user comment.', 'vhm-show-comments'), 0 ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="number"><?php _e('Number of comments to show', 'vhm-show-comments')?></label></th>
						<td>
							<input type="text" name="item_number" id="number" value="<?php echo (!empty($options['number'])) ? $options['number'] : 0 ; ?>" />
							<p class="description"><?php printf( __('%s to hide the comments', 'vhm-show-comments'), 0 ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="order"><?php _e('Order by', 'vhm-show-comments')?></label></th>
						<td>
							<select name="item_order">
								<option value="DESC"<?php echo ($options['order'] == 'DESC') ? ' selected="selected"' : false ; ?>><?php _e('Descendant', 'vhm-show-comments'); ?></option>
								<option value="ASC"<?php echo ($options['order'] == 'ASC') ? ' selected="selected"' : false ; ?>><?php _e('Ascendant', 'vhm-show-comments'); ?></option>
								<option value="RAND"<?php echo ($options['order'] == 'RAND') ? ' selected="selected"' : false ; ?>><?php _e('Random', 'vhm-show-comments'); ?></option>
							</select>
							<p class="description"><?php _e('Choose how the comments should be ordered', 'vhm-show-comments'); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="item_before"><?php _e('Before items', 'vhm-show-comments'); ?></label></th>
						<td>
							<input type="text" name="item_before" id="before_items" value="<?php echo (!empty($options['before_items'])) ? esc_attr($options['before_items']) : '<ol>' ; ?>" />
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
						<th scope="row"><label for="loop"><?php _e('Template', 'vhm-show-comments')?></label></th>
						<td>
							<textarea name="item_loop" id="loop" style="width:100%" rows="10"><li>"%COMMENT%" &mdash; <a href="%URL%">%AUTHOR%</a> <?php _e('in', 'vhm-show-comments'); ?> <a href="%POST_URL%">%POST_TITLE%</a></li></textarea>
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
							<input type="text" name="item_after" id="item_after" value="<?php echo (!empty($options['after_items'])) ? esc_attr($options['after_items']) : '</ol>' ; ?>" />
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
			
			<?php @submit_button(); ?>
			</form>
			
			<?php elseif ($_REQUEST['tab'] == 'shortcodes'): ?>
			<div id="shortcodes">
				<h3><?php _e( 'My shortcodes', 'vhm-show-comments' ); ?></h3>
				
				<table class="wp-list-table widefat fixed tags">
					<thead>
						<tr>
							<th scope="col" class="column-cb desc" style="width:5%"><?php _e( 'ID', 'vhm-show-comments' ); ?></th>
							<th scope="col" class="column-name desc" style=""><?php _e('Shortcode Title', 'vhm-show-comments')?></th>
							<th scope="col" class="column-description desc" style=""><?php _e( 'Shortcode', 'vhm-show-comments' ); ?></th>	
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th scope="col" class="column-cb" style=""><?php _e( 'ID', 'vhm-show-comments' ); ?></th>
							<th scope="col" class="column-name desc" style=""><?php _e('Shortcode Title', 'vhm-show-comments')?></th>
							<th scope="col" class="column-description" style=""><?php _e( 'Shortcode', 'vhm-show-comments' ); ?></th>	
						</tr>
					</tfoot>
					<tbody>
						<?php foreach ($shortcodes as $shortcode): ?>
						<tr class="alternate">		
							<td class="column-name"><?php echo $shortcode->ID; ?></td>
							<td class="column-description">
								<strong><span class="row-title"><?php echo $shortcode->item_title; ?></span></strong>
								<div class="row-actions">
									<span class="trash"><a class="submitdelete" title="<?php _e('Move this item to the Trash', 'vhm-show-comments'); ?>" href="<?php echo admin_url('edit-comments.php?page=vhm_show_comments&tab=shortcodes&action=trash&id=' . $shortcode->ID)?>"><?php _e('Trash', 'vhm-show-comments')?></a></span>
								</div>
							</td>
							<td>
								<input type="text" value='[vhm_show_comments id="<?php echo $shortcode->ID; ?>"]' onclick="this.focus(); this.select()" readonly="readonly" style="width:100%">
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
			
			<?php elseif ($_REQUEST['tab'] == 'about'): ?>
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
			<?php endif; ?>
			
	
</div>