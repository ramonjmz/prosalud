Prosalud.TextField = Em.TextField.extend({

	attributeBindings: 'name'.w(),

    didInsertElement: function() {
    	console.log(this.$().attr('name'))
    	this.$().focus();
    }

});