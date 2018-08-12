$.ajax({
    url: 'http://localhost/wordpress/wp-content/plugins/wp-pinterest-automatic/core.php',
    type: 'POST',
    data: {
        action: "boards",
        user: "sweetheatmn@yahoo.com",
        pass: "0129212211"
    },

    success: function (data) {
        console.log(data);
        var res = $.parseJSON(data);
        if (res['status'] == 'success') {

            var ids = res['ids'];
            var titles = res['titles'];
 
            for (var i = 0; i < ids.length; i++) {
                
$('#suggestTemplate .bubble-body').html(phrases[i]);
                $('#suggestionContain').append($('#suggestTemplate').html());
            }

        } else if (res['status'] == 'fail') {
             
            $('#suggestionContain').prepend('<a href="#" title="error" class="box errors corners" style="margin-top: 0pt ! important;"><span class="close">&nbsp;</span>' + error + ' .</a>');
            activate_close();


        }

    },

    beforeSend: function () {

    }


});