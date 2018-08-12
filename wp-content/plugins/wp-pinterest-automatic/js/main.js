/**
 * Created with Visual Form Builder by 23rd and Walnut
 * www.visualformbuilder.com
 * www.23andwalnut.com
 */
//var $ = jQuery.noConflict();
//timer for collecting imgs

function timedCount()
{
 

jQuery('#content_ifr').contents().find('img').each(
function () {
    
    var original=this;
    //console.log( jQuery('#pin-images img[src="'+ jQuery(this).attr('src') +'"]' ).attr('src') );

   if ( jQuery('#pin-images img[src="'+ jQuery(this).attr('src') +'"]' ).attr('src') != jQuery(original).attr('src') ) {
        jQuery('#img_template img').attr('src', jQuery(this).attr('src'));
        jQuery('#img_template input:checkbox').val(jQuery(this).attr('src'));
        jQuery('#pin-images').append(jQuery('#img_template').html());
        jQuery(".TTWForm input:checkbox").uniform();
        jQuery.uniform.update();
    }
}); 

jQuery('.attachment-post-thumbnail').each(
		function () {
		    
			var src= jQuery(this).attr('src');

			srcs= src.split('-');
			
			console.log(srcs);
			
			var lastIndex= (srcs.length - 1); 

			var lastItem=srcs[lastIndex];
			
			console.log(lastItem);
			
			var lastItemParts=lastItem.split('.');
			//console.log(lastItemParts);
			var extention = lastItemParts[lastItemParts.length - 1];
			//console.log(extention);

			var i=0;

			imgsrc='';
			jQuery.each(srcs, function(index, value) {
			if (index ==  srcs.length - 1 ){
				if(lastItem.search("x") != '-1'){
					imgsrc=imgsrc + '.' + extention;
				}else{
					imgsrc=imgsrc + '-' + lastItem;
				}
			}else if(index != 0){
			    imgsrc=imgsrc + '-' + value;
			}else{
			    imgsrc=value;
			}



			});
			 
		    
		    //console.log( jQuery('#pin-images img[src="'+ jQuery(this).attr('src') +'"]' ).attr('src') );

		   if ( jQuery('#pin-images img[src="'+ imgsrc +'"]' ).attr('src') != imgsrc ) {
		        jQuery('#img_template img').attr('src', imgsrc);
		        jQuery('#img_template input:checkbox').val(imgsrc);
		        jQuery('#pin-images').append(jQuery('#img_template').html());
		        jQuery(".TTWForm input:checkbox").uniform();
		        jQuery.uniform.update();
		    }
		});

t=setTimeout("timedCount()",5000);
}

timedCount();


jQuery(document).ready(function()
{

	
	//selcet all 
	jQuery('.select_all').click(function() {
		jQuery("input:checkbox").attr('checked','checked');
		jQuery.uniform.update();	
			return false;
	});
	
	
	jQuery('.deselect_all').click(function() {
		jQuery("input:checkbox").attr('checked','checked');
		                    jQuery('input:checkbox').removeAttr('checked');
		                   jQuery.uniform.update();
			return false;
	});
	
	//tabs
	//jQuery("ul.tabs").tabs("div.panes > div.contain");
	//close link
	function activate_close(){
		jQuery('.close').click(function(){
			
			jQuery(this).parent().fadeOut('slow');
			
		});
		
	}
	
	
    //Style selects, checkboxes, etc
    jQuery(".TTWForm #field-PIN_BOARD-container select,#field-wp_pinterest_board-container select, .TTWForm input:radio,.TTWForm input:file ,.TTWForm input:checkbox").uniform();

    //Date and Range Inputs
	//jQuery("#field1, #field2 , #field255, #field256, #field1s, #fieldz1").rangeinput();

    /**
     * Get the jQuery Tools Validator to validate checkbox and
     * radio groups rather than each individual input
     */

    jQuery('[type=checkbox]').bind('change', function(){
        clearCheckboxError(jQuery(this));
    });
    
    //slider function
    function slider(id,slide) {
 
		  
		if(jQuery(id).attr("checked"))
        {
            //call the function to be fired
            //when your box changes from
            //unchecked to checked
			jQuery(slide).slideDown();
        }
        else
        {
            //call the function to be fired
            //when your box changes from
            //checked to unchecked
        	jQuery(slide).slideUp();
        }
	}

 //slider function
function slider(id, slide) {

	if (jQuery(id).attr("checked")) {
		jQuery(slide).slideDown();
	} else {
		jQuery(slide).slideUp();
	}
}

//slider function
function slider_hider(id, slide, hide) {

	if (jQuery(id).attr("checked")) {
		jQuery(hide).slideUp('fast', function() {
			jQuery(slide).slideDown();
		});
	} else {
		jQuery(hide).slideDown();
		jQuery(slide).slideUp();
	}
}

slider('#field-pin_options-1', '#pin-contain');

jQuery("#field-pin_options-1").change(function() {

	slider('#field-pin_options-1', '#pin-contain');

});

//slider
slider('#field-pin_options-2', '#pin_vars');

jQuery("#field-pin_options-2").change(function() {

	slider('#field-pin_options-2', '#pin_vars');

});

    
    //validate checkbox and radio groups
    function validateCheckRadio(){
        var err = {};

        jQuery('.radio-group, .checkbox-group').each(function(){
             if(jQuery(this).hasClass('required'))
                if (!jQuery(this).find('input:checked').length)
                    err[jQuery(this).find('input:first').attr('name')] = 'Please complete this mandatory field.';
        });

        if (!jQuery.isEmptyObject(err)){
            validator.invalidate(err);
            return false
        }
        else return true;

    }





    //clear any checkbox errors
    function clearCheckboxError(input){
        var parentDiv = input.parents('.field');

        if (parentDiv.hasClass('required'))
            if (parentDiv.find('input:checked').length > 0){
                validator.reset(parentDiv.find('input:first'));
                parentDiv.find('.error').remove();
            }
    }




    //Position the error messages next to input labels
    jQuery.tools.validator.addEffect("labelMate", function(errors, event){
        jQuery.each(errors, function(index, error){
        	
            error.input.first().parents('.field').find('.error').remove().end().find('label').after('<span class="error">' + error.messages[0] + '</span>');
        });

    }, function(inputs){
        inputs.each(function(){
            jQuery(this).parents('.field').find('.error').remove();
        });

    });


    /**
     * Handle the form submission, display success message if
     * no errors are returned by the server. Call validator.invalidate
     * otherwise.
     */

  // jQuery("#post").validator({effect:'labelMate'});
   
   jQuery("#publish").click(function(event){
	   
	  
	   //validating
	   if(jQuery('#feed_post').attr('checked')){
		   if(jQuery('#opt_pin').attr('checked')){
			   var inputs = jQuery("#feed_part :input , #pin_text :input  ").validator({effect:'labelMate'});
		   }else{
			   var inputs = jQuery("#feed_part :input").validator({effect:'labelMate'});
		   }
		   
		}else{
			if(jQuery('#opt_pin').attr('checked')){
			    var inputs = jQuery("#amazon_part :input, #pin_text :input").validator({effect:'labelMate'});
			}else{
				var inputs = jQuery("#amazon_part :input").validator({effect:'labelMate'});
			}
		}
	   
	   
	   //check if not valid stop loading ajax icons
	   if( ! inputs.data("validator").checkValidity()){
		   
		   event.stopImmediatePropagation();
		   alert('Complete Required Fields');
		   
	   }
	   
	   
	   
   });
     
    jQuery(".TTWForm").validator({effect:'labelMate'}).submit(function(e){
       var form = jQuery(this), checkRadioValidation = validateCheckRadio();

        if(!e.isDefaultPrevented() && checkRadioValidation){
            jQuery.post(form.attr('action'), form.serialize(), function(data){
                data = jQuery.parseJSON(data);

                if(data.status == 'success'){
                	 jQuery('.inside').prepend('<a style="margin-top:0 !important" class="box succes corners" title="info" href="#"><span class="close">&nbsp;</span>Settings saved successfully .</a>');
                	 activate_close();
                	 /*  form.fadeOut('fast', function(){
                        jQuery('.TTWForm-container').append('<h2 class="success-message">Success!</h2>');
                    }); */

                    /************************************************************************************/
                    /*                                REDIRECTION CODE                                  */
                    /*         Only uncomment the line below if you want to redirect to another page    */
                    /*                          when the form has been submitted                        */
                    /************************************************************************************/

                    //window.location = 'http://www.example.com/somePage.html';
                }
                else validator.invalidate(data.errors);

            });
        }

        return false;
    });

    var validator = jQuery('.TTWForm').data('validator');


});
