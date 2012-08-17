(function($) { 
	$(document).ready(function() {			
            alert('sa');
 
            
	$("#contact-form").validate({
	    rules: {
	      first_name: {
	        minlength: 2,
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      },
	      last_name: {
	      	minlength: 2,
	        required: true
	      },
	      description: {
	        minlength: 2,
	        required: true
	      }
	    },
	    highlight: function(label) {
	    	$(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('OK!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	  });
	  
});

})(jQuery);