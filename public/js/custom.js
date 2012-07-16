$(function() {
	
	    $('.dropdown-toggle').dropdown()

		$('.carousel').carousel()
		
		$('.typeahead').typeahead()

		window.customInitFunctions  && $.map(window.customInitFunctions, function(item, index){
			item();
		});
});