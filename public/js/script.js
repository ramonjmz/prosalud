(function($) {
	$(document).ready(
			function() {

				$("#contact-form").validate(
						{
							rules : {
								first_name : {
									minlength : 2,
									required : true
								},
								email : {
									required : true,
									email : true
								},
								last_name : {
									minlength : 2,
									required : true
								},
								phone_home : {
									minlength : 2,
									required : true
								},
								description : {
									minlength : 2,
									required : true
								}
							},
							highlight : function(label) {
								$(label).closest('.control-group').addClass(
										'error');
							},
							success : function(label) {
								label.text('OK!').addClass('valid').closest(
										'.control-group').addClass('success');
							}
						});
				
				$("#login").validate(
						{
							rules : {
								
								username : {
									minlength : 2,
									required : true
								},
								password : {
									minlength : 2,
									required : true
								}
							},
							highlight : function(label) {
								$(label).closest('.control-group').addClass(
										'error');
							},
							success : function(label) {
								label.text('OK!').addClass('valid').closest(
										'.control-group').addClass('success');
							}
						});
				
				$("#specialty-form").validate(
						{
							rules : {
								
								name : {
									minlength : 2,
									required : true
								} 
							},
							highlight : function(label) {
								$(label).closest('.control-group').addClass(
										'error');
							},
							success : function(label) {
								label.text('OK!').addClass('valid').closest(
										'.control-group').addClass('success');
							}
						});
				
				$("#test-form").validate(
						{
							rules : {
								
								name : {
									minlength : 2,
									required : true
								},
								amount : {
									minlength : 2,
									required : true
								},
								process_time : {
									minlength : 2,
									required : true
								}
							},
							highlight : function(label) {
								$(label).closest('.control-group').addClass(
										'error');
							},
							success : function(label) {
								label.text('OK!').addClass('valid').closest(
										'.control-group').addClass('success');
							}
						});
				$("#references-form").validate(
						{
							rules : {
								
								name : {
									minlength : 2,
									required : true
								},
								value : {
									minlength : 2,
									required : true
								},
								unit : {
									minlength : 2,
									required : true
								},
								process_time : {
									minlength : 2,
									required : true
								}
							},
							highlight : function(label) {
								$(label).closest('.control-group').addClass(
										'error');
							},
							success : function(label) {
								label.text('OK!').addClass('valid').closest(
										'.control-group').addClass('success');
							}
						});

				$("#item-form").validate(
						{
							rules : {
								
								name : {
									minlength : 2,
									required : true
								},
								description : {
									minlength : 2,
									required : true
								},
								reference_id : {
									minlength : 2,
									required : true
								} 
							},
							highlight : function(label) {
								$(label).closest('.control-group').addClass(
										'error');
							},
							success : function(label) {
								label.text('OK!').addClass('valid').closest(
										'.control-group').addClass('success');
							}
						});
				 

			});

})(jQuery);