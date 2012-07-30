Prosalud.controllers.items = Prosalud.controllers.items || {};

Prosalud.controllers.items.itemsDataController = Em.ArrayController.create({
	content: [],
    store : new Store({
        name: "analysis_store",
        url: "/items/rest"
    }),

});

Prosalud.controllers.items.selectedItemController = Em.Object.create({
	selectedItem : null,
	select: function(item){
		console.log(item);
		this.set( "selectedItem", item );
	}
});
