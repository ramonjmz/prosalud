Prosalud.controllers.tests = Prosalud.controllers.tests || {};

Prosalud.controllers.tests.collectionController = Em.ArrayController.create({
	content: [],
    store : new Store({
        name: "tests_store",
        url: "/tests/rest"
    }),
    search: function(query, callback){
    	var self = this,
    		jqxhr = null;
    	jqxhr = self.get("store").search(query)
    	jqxhr.done(function(data){
    			//console.log(data);
    			var testCollection = [];
    			if(data.result && data.result.length > 0){
    				$.map(data.result, function(item, index){
    					testCollection.push(Prosalud.models.Test.create(item));
    				});
    			}
    			self.set( "content", testCollection ) ;
    			callback && callback(testCollection);
    		})
    		.fail(function(){
    			callback && callback();	
    			console.log("Tenemos problemas houston", arguments);
    		});
    },

    searchByResult: function(query, callback){
        var self = this,
            jqxhr = null,
            store = self.get("store");
            store.url = "/tests/list-by-result-json";
        jqxhr = store.search(query);
        jqxhr
            .done(function(data){
                var testCollection = [];
                if(data.result && data.result.length > 0){
                    $.map(data.result, function(item, index){
                        testCollection.push(Prosalud.models.Test.create(item));
                    });
                }
                self.set( "content", testCollection );
                callback && callback( testCollection );
            })
            .fail(function(){
                callback && callback();
                console.log("Tenemos problemas houston", arguments);
            });
    }
});

Prosalud.controllers.tests.selectedTest = Em.Object.create({
	selectedTest : null,
	select: function(test){
		this.set( "selectedTest", test );
	}
});