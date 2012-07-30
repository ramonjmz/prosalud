Prosalud.controllers.items = Prosalud.controllers.items || {};

Prosalud.controllers.items.itemsDataController = Em.ArrayController.create({
	content: [],
    store : new Store({
        name: "analysis_store",
        url: "/items/rest"
    }),
    search: function(query, callback){
    	var self = this
    		itemCollection = [];

    	self.get("store").search(query)
    		.done(function(data){
    			if(data.result && data.result.length > 0){
    				$.map(data.result, function(item, index){
    					itemCollection.push(Prosalud.models.ItemModel.create(item));
    				});
    			}
    			callback && callback(itemCollection);
    		})
    		.fail(function(){
    			callback && callback();
    		})
    }

});

Prosalud.controllers.items.selectedItemController = Em.Object.create({
	selectedItem : null,
	select: function(item){
		console.log(item);
		this.set( "selectedItem", item );
	}
});
