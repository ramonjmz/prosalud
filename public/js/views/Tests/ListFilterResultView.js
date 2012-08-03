Prosalud.views.tests = Prosalud.views.tests || {};

Prosalud.views.tests.ListFilterResultView = Ember.View.extend({	

	tagName: "tr",

	filterResult: function(){
		var test = this.get( 'test' );		
		Prosalud.controllers.results.collectionController.filterBy("test_id", test.get("id"));
	},

	showAll: function(){
        Prosalud.controllers.results.collectionController.set('content', Prosalud.controllers.results.dataController.get( "content" ));
    }

});