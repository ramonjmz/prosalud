Prosalud.views.results = Prosalud.views.results || {};

Prosalud.views.results.ListView = Ember.View.extend({	

	tagName: "tr",

	dataIni: null,

	editing: false, 

	select: function(){
        var result = this.get('result');		
		this.set( "editing", true );
		this.set( "dataIni", {
			result: result.get( "result" )
		});
		Prosalud.controllers.results.selectedController.set( "selectedResult", result );		
	},

	keyDown: function(event){
		var self = this;
		console.log(event);
		if(event.keyCode === 13){
			var result = Prosalud.controllers.results.selectedController.get( "selectedResult" );			
			//result.set("result", $(event.target).val());
			Prosalud.controllers.results.dataController.get( "store" ).url = "/results/rest";
			Prosalud.controllers.results.dataController.get( "store" ).save( result )
				.done(function(data){
					console.log("result guardado", data);
					self.clean();
				})
				.fail(function(){
					alert("Lo sentimos, algo ocurrio mal, vuelva a intentarlo");
				});			
		}
	},

	focusOut: function(){
		var result = Prosalud.controllers.results.selectedController.get( "selectedResult" );
		if(result){
			result.set("result", this.get("dataIni").result);	
			this.clean();
		}				
	},

	clean: function(){
		this.set("editing", false);
		this.set("dataIni", null);
		Prosalud.controllers.results.selectedController.set( "selectedResult", null );
	}



});