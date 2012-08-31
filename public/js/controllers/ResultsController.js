Prosalud.controllers.results = Prosalud.controllers.items || {};

Prosalud.controllers.results.dataController = Em.ArrayController.create({
	content: [],
    store : new Store({
        name: "results_store",
        url: "/results/rest"
    }),
    search: function(query, callback){
    	var self = this
    		resultCollection = [],
            store = self.get("store");

        store.url = "/results/list-json";
    	store.search(query)
    		.done(function(data){
    			if(data.result && data.result.length > 0){
    				$.map(data.result, function(item, index){
                        if(item.test_id){
                            item.test_id = parseInt(item.test_id);
                        }
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

Prosalud.controllers.results.collectionController = Em.ArrayController.create({
    content: [],

    updating: true,

    filterBy: function(key, value) {
        this.set('content', Prosalud.controllers.results.dataController.filterProperty(key, value));
    }

});

Prosalud.controllers.results.selectedController = Em.Object.create({
	
    selectedResult : null,

	select: function(item){
		console.log(item);
		this.set( "selectedResult", item );
	}

});
