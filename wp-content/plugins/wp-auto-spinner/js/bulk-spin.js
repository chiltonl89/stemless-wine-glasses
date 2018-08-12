jQuery(document).ready(function(){
	//ADD OPTION
	jQuery('select[name="action"]').append('<option value="wp_automatic_spin">spin them</option>');
	
	
	//CLICH PIN
	jQuery('#doaction,#doaction2').click(function(){
	    if(jQuery('select[name="action"]').val() == 'wp_automatic_spin' ){
	        
	    	var itms='';
	    	var itms_count=0;

	    	jQuery('input[name="post[]"]:checked').each(
	    	    function(index,itm){
	    	        console.log(jQuery(itm).val());
	    	        itms=itms + ',' + jQuery(itm).val();
	    	        itms_count++;    
	    	    }
	    	    
	    	    
	    	);

	        jQuery.ajax({
	            url: ajaxurl,
	            type: 'POST',

	            data: {
	                action: 'wp_auto_spinner_spin',
	                itms: itms
	            }	        
	        });

	    		
	    	alert(itms_count + ' items sent to the spin queue' );
	    	jQuery('input[name="post[]"]:checked').removeAttr('checked');

	    		
	    	
	    	 jQuery('select[name="action"]').val('-1');
	        return false;  
	    }
	});
 
});