jQuery(document).ready(function() {
	var fileInput = '';

	jQuery('a.upload_image_button').click(function() {
		fileInput = jQuery(this).siblings('.uploadfield');
		formfield = fileInput.attr('name');
		post_id = 0;
		tb_show('', 'media-upload.php?post_id='+post_id+'&amp;type=image&amp;TB_iframe=true');
		return false;
	});
	
	// user inserts file into post. only run custom if user started process using the above process
	// window.send_to_editor(html) is how wp would normally handle the received data

	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html){

		if (fileInput) {
			fileurl = jQuery('img',html).attr('src');

			fileInput.val(fileurl);

			tb_remove();

		} else {
			window.original_send_to_editor(html);
		}
	};
	
});