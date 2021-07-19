// Create 'keyup_event' tinymce plugin
tinymce.PluginManager.add('keyup_event', function(editor, url) {

	// Create keyup event
	editor.on('setcontent beforeaddundo keyup', function(e) {

		// Get the editor content (html)
		get_ed_content = tinymce.activeEditor.getContent({ format: 'text' });
		get_ed_content = get_ed_content.replace(/(<([^>]+)>)/ig, '');
		id = tinyMCE.activeEditor.id;
		counter(id, get_ed_content);
	});
});