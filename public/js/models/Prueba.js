AppPrueba = Ember.Application.create();

AppPrueba.Prueba = Ember.Object.extend({
    id: false,
    name: "",
    description: ""
});

AppPrueba.pruebasController = Ember.ArrayProxy.create({
    content: [],
    getBy: function(params){
      //this.set("content", []);
      AppPrueba.pruebasController.set("content", []);
      lastXhr = $.getJSON( "/items/list-json", params, function( data, status, xhr ) {
        data.result && $.map(data.result, function(item, index){
          AppPrueba.pruebasController.addObject(AppPrueba.Prueba.create(item));
        });
      });
    }
});

AppPrueba.PruebaListView = Ember.View.extend({
    tagName: 'tr'//,
    /*removeItem: function() {
        var prueba = this.get('prueba');
        AppPrueba.pruebasController.removeObject(prueba);
    }*/
});

/*AppPrueba.PruebaListView = Ember.View.extend({
    tagName: 'tr',
    removeItem: function() {
        var prueba = this.get('prueba');
        AppPrueba.pruebasController.removeObject(person);
    }
});*/

