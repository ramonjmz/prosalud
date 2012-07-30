Prosalud.views.items = Prosalud.views.items || {};

Prosalud.views.items.EditView = Ember.View.extend({
	
	contentBinding: 'Prosalud.controllers.items.selectedItemController.selectedTest',

	tagName: "form"
});