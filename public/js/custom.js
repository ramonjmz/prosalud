$(function() {

	$('.dropdown-toggle').dropdown()

	$('.carousel').carousel()

	$('.typeahead').typeahead()

	$('.collapse').collapse( {
		toggle : false
	})

	window.customInitFunctions
			&& $.map(window.customInitFunctions, function(item, index) {
				item();
			});
	
	

});