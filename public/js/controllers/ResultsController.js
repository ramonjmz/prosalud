Prosalud.controllers.results = Prosalud.controllers.items || {};

Prosalud.controllers.results.collectionController = Em.ArrayController.create({
	content: [],
    store : new Store({
        name: "results_store",
        url: "/results/rest"
    }),
    search: function(query, callback){
    	var self = this
    		resultCollection = [];

    	self.get("store").search(query)
    		.done(function(data){
    			if(data.result && data.result.length > 0){
    				$.map(data.result, function(item, index){
    					resultCollection.push(Prosalud.models.Result.create(item));
    				});
    			}
                self.set( "content", resultCollection)
    			callback && callback(resultCollection);
    		})
    		.fail(function(){
    			callback && callback();
    		})
    }

});

Prosalud.controllers.results.selectedController = Em.Object.create({
	
    selectedResult : null,

	select: function(item){
		console.log(item);
		this.set( "selectedResult", item );
	}

});

