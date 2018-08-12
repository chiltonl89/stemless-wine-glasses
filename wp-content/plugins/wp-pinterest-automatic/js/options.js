jQuery(document).ready(function(){
	
jQuery('#get_boards').click(function(){

jQuery.ajax({
    url: jQuery(this).parent().attr('href'),
    type: 'POST',
    data: {
        action: "boards",
        user: jQuery('#field-wp_pinterest_user').val(),
        pass: jQuery('#field-wp_pinterest_pass').val()
    },

    success: function (data) {
    	jQuery('#ajax-loading').addClass('ajax-loading');

        var res = jQuery.parseJSON(data);
        if (res['status'] == 'success') {
            //console.log(data);


            jQuery('#field1zz option').remove();
            jQuery.uniform.update();

            var ids = res['ids'];
            var titles = res['titles'];

            for (var i = 0; i < ids.length; i++) {

            	jQuery('#field1zz').append('<option value="' + ids[i] + '">' + titles[i] + '</option>');
                jQuery.uniform.update();


            }

        } else if (res['status'] == 'fail') {

            alert('Can not login, make sure you of login email and password and try again');
            return false
        		

        }

    },

    beforeSend: function () {
    	
    	jQuery('#ajax-loading').removeClass('ajax-loading');

    }


});
return false;
});

});