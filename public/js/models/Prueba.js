    AppAnalysis = Ember.Application.create();

    AppAnalysis.Prueba = Ember.Object.extend({
        id: false,
        name: "",
        description: ""
    });

    AppAnalysis.pruebasController = Ember.ArrayProxy.create({
        content: [],
        getBy: function(params){
          AppAnalysis.pruebasController.set("content", []);
          lastXhr = $.getJSON( "/items/list-json", params, function( data, status, xhr ) {
            data.result && $.map(data.result, function(item, index){
              AppAnalysis.pruebasController.addObject(AppAnalysis.Prueba.create(item));
            });
          });
        }
    });

    AppAnalysis.PruebaListView = Ember.View.extend({
        tagName: 'tr',
        SelectedItem: function() {
            var prueba = this.get('prueba');
            console.log(prueba);
        }
    });

    Result = Ember.Resource.extend({
        resourceUrl:        '/contacts',
        resourceName:       'result',
        resourceProperties: ['id', 'analysis_id', 'item_id', 'item_name', 'ref_val_id', 'ref_val_value', 'ref_val_unit', 'result', 'deleted']
    });
    /*Result = Ember.Object.extend({
        id: false,
        analysis_id: null,
        item_id: null,
        item_name: null,
        ref_val_id: null,
        ref_val_value: null, 
        ref_val_unit: "",

        store : null

    });*/
    StoreResult = function(name){
        this.name = name;
        this.data = {};

        this.save = function( model ){
            var jxhr = null;
            jxhr = $.ajax("/results/rest", {                
                type: "POST",
                data: model.serialize()
            });
            return jxhr;
        };

        this.delete = function(model){
            var jxhr = null;

            jxhr = $.ajax("/results/rest", {                
                type: "POST",
                data: model.serialize()
            });
            return jxhr;
        };
    };

    ResultsController = Ember.ArrayProxy.create({
        content: [],
        store: new StoreResult() ,
        CreateNew: function(value){
            var result = Result.create(value),
                self = this;
            this.get( "store" ).save(result)
                .done(function(){
                    console.log("done", arguments);
                    self.get("content").addObject(result);
                })
                .fail(function(){
                    console.log("fail", "ups tenemos problemas huston");
                });
        },
        Remove: function(model){
            var self = this;
            self.get( "store" ).delete(model)
                .done(function(){
                    self.removeObject(model);
                })
                .fail(function(){
                    console.log("fail", "ups tenemos problemas huston");
                });
        }
        
    });


    ResultsListView = Ember.View.extend({
        tagName: 'tr',
        Remove: function() {
            var result = this.get('result');
            result.set("deleted", 1);
            ResultsController.Remove(result);
            console.log(result, "removiendo");
        }
    });

    ResultsController.CreateNew(        
        {
            item_name: "prueba 1",
            ref_val_value: "value 1",
            ref_val_unit: "lt/x",
            analysis_id: 23,
            item_id: 27,
            ref_val_id: 6            
        }
    );

    /*ResultsController.addObject(Result.create({
        item_name: "prueba 2",
        ref_val_value: "value 2",
        ref_val_unit: "lt/x"
    }));*/

    /*AppAnalysis.ResultsController.addObject(AppAnalysis.Result.create({
        item_name: "prueba 3",
        ref_val_value: "value 3",
        ref_val_unit: "lt/x"
    }));*/
    console.log("hola mundo");

