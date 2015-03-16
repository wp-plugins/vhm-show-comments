(function() {
    tinymce.PluginManager.add('vhmShowComments_button', function( editor, url ) {
        editor.addButton( 'vhmShowComments_button', {
            title: 'VHM Show Comments',
            icon: 'icon dashicons-admin-comments',
			onclick: function() {
				editor.windowManager.open({
					title: 'VHM Show Comments',
					body: [
						{
							type: 'textbox',
							name: 'id',
							label: 'Shortcode ID'
						}
					],
					onsubmit: function( e ) {
						var output = '[vhm_show_comments';
						if (e.data.id)
							output += ' id="' + e.data.id + '"';
						output += ']';
						
						editor.insertContent( output );
					}
				});
			}
        });
    });
})();