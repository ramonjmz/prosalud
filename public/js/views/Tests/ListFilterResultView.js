Prosalud.views.tests = Prosalud.views.tests || {};

Prosalud.views.tests.ListFilterResultView = Ember.View.extend({	

	tagName: "tr",

	filterResult: function(){
		var test = this.get( 'test' );
		console.log( test );
	}

});