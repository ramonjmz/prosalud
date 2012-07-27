    Store = function(options){
        this.name = options.name || "";
        this.data = {};
        this.url = options.url || "";
        this.save = function( model ){
            var self = this,
                jxhr = null;
            jxhr = $.ajax(self.url, {                
                type: "POST",
                data: model.serialize()
            });
            return jxhr;
        };

        this.delete = function(model){
            var jxhr = null,
                self = this;

            jxhr = $.ajax(self.url, {                
                type: "POST",
                data: model.serialize()
            });
            return jxhr;
        };

        this.search = function(query){
            var jxhr = null,
                self = this;
            jxhr = $.ajax(self.url, {
                type: "POST",
                data: query
            });
            return jxhr;
        }
    };

    Analysis = Ember.Resource.extend({
        resourceUrl:        '/analysis',
        resourceName:       'analysis',
        resourceProperties: ['id', 'applicant_id', 'applicant_name', 'medic_id', 'medic_name', 'deleted'],
        
    });

    AnalysisSelectedController = Em.Object.create({
        selectedItem : null,
        source: new Store({
            url: "/analysis/rest"
        }),
        select: function(analysis){
            this.set('selectedItem', analysis);
        },
        Delete: function(callback){
            var model = this.get('selectedItem');
            if(model){
                model.set("deleted", 1);
                this.get('source').save(model)
                    .done(function(data){
                        callback && callback(data);
                    })
                    .fail(function(){
                        console.log("Error");
                    })
            }
        }
    });

    var miAnalisis = Analysis.create({
        id: 1,
        applicant_name: "tu",
        medic_name: "yo",        
    });

    

    AnalysisController = Ember.ArrayProxy.create({
        content: [],
        store : new Store({
            name: "analysis_store",
            url: "/analysis/rest"
        }),
        CreateNew: function(value, callback){
            var analysis = Analysis.create(value)
                analysisCreated = null,
                self = this;
            this.get( "store" ).save(analysis)
                .done(function(data){    
                    if(data.analysis){
                        analysisCreated = Analysis.create(data.analysis);
                        self.get("content").addObject(analysisCreated);    
                    }                    
                    callback && callback(analysis);                    
                })
                .fail(function(){
                    console.log("fail", "ups tenemos problemas huston");
                });
        },
        Remove: function(callback){
            var self = this;
            self.get( "store" ).delete(model)
                .done(function(){
                    callback && callback(model);
                })
                .fail(function(){
                    console.log("fail", "ups tenemos problemas huston");
                });
        }
    });

    AnalysisCreatedView = Ember.View.extend({

        tagName: 'div',

        contentBinding: 'AnalysisSelectedController.selectedItem',   

        Delete: function(){            
            if(confirm("¿Esta seguro de eliminar el análisis?")){
                AnalysisSelectedController.Delete(function(){
                    window.location = "/analysis/add";
                });
            }
        },          

        didInsertElement: function(){
            var cache = {},
            lastXhr;
            $('#especialidad').on('change', function(){
              cache = {};
            });
            $('#estudio_name').autocomplete({
              minLength: 2,
              source: function( request, response ) {
                var term = request.term;
                if ( term in cache ) {
                  response( cache[ term ] );
                  return;
                }
                console.log(request);
                lastXhr = $.getJSON( "/tests/list-json", {
                  specialty_id: $("#especialidad").val(),
                  name__like : "%"+term + "%"
                }, function( data, status, xhr ) {
                  cache[ term ] = data;
                  if ( xhr === lastXhr ) {
                    response( data.result );
                  }
                });
              },
              focus: function( event, ui ) {
                $( "#estudio_name" ).val( ui.item.name );
                return false;
              },
              select: function( event, ui ) {
                $( "#estudio_name" ).val( ui.item.name );
                console.log(ui.item.id);
                AppAnalysis.pruebasController.getBy({"test_id": ui.item.id});
                return false;
              }
            })
            .data( "autocomplete" )._renderItem = function( ul, item ) {
              return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + item.name +"</a>" )
                .appendTo( ul );
            };
        }
        /*printCustomJavascript: function(){
            return this.customJavascript;
        }*/
    });

    AnalysisNewView = Ember.View.extend({
        tagName: 'div',
        CreateNew: function(){
            var pacientes = PacientesController.get( "content" ),
                paciente = null,
                medicos = MedicosController.get( "content"),
                medico = null;
            if(!pacientes.length){
                alert("Seleccione un paciente.");
                return;
            }

            if(!medicos.length){
                alert("Seleccione un medico.");
                return;
            }

            paciente = pacientes[0];
            medico = medicos[0];
            
            AnalysisController.CreateNew({
                applicant_id: paciente.get( "id" ),
                medic_id: medico.get( "id" )
            }, function(analysisNew){
                analysisNew.set("applicant_name", paciente.get("first_name") + " " + paciente.get("last_name"));
                analysisNew.set("medic_name", medico.get("first_name") + " " + medico.get("last_name"));                
                AnalysisSelectedController.set( "selectedItem", analysisNew );
            });            
        },
        didInsertElement: function(){
            var cacheApplicant = {},
            lastXhr,
            $contactName = $('#contact_name');

            $contactName.autocomplete({
              minLength: 2,
              source: function( request, response ) {
                var term = request.term;
                if ( term in cacheApplicant ) {
                  response( cacheApplicant[ term ] );
                  return;
                }
                
                lastXhr = $.getJSON( "/contact/list-json", {    
                  title: "Paciente",
                  first_name__like : "%"+term + "%",
                  last_name__like__or : "%"+term + "%"
                }, function( data, status, xhr ) {
                  cacheApplicant[ term ] = data;
                  if ( xhr === lastXhr ) {
                    if(data.result && data.result.length){
                        response( data.result );    
                    }
                    else{
                        response( data.result );   
                    }
                    
                  }
                });
              },
              focus: function( event, ui ) {
                $contactName.val( ui.item.first_name + " " + ui.item.last_name);
                return false;
              },
              select: function( event, ui ) {
                $contactName.val( ui.item.first_name + " " + ui.item.last_name);
                PacientesController.set( "content", [] );
                PacientesController.addObject(Contact.create(ui.item));
                return false;
              }
            })
            .data( "autocomplete" )._renderItem = function( ul, item ) {
              return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + item.first_name + " " + item.last_name +"</a>" )
                .appendTo( ul );
            };
  

            var cacheMedico = {},
              lastXhr,
              $medicoName = $('#medico_name');

              $medicoName.autocomplete({
                minLength: 2,
                source: function( request, response ) {
                  var term = request.term;
                  if ( term in cacheMedico ) {
                    response( cacheMedico[ term ] );
                    return;
                  }                      
                  lastXhr = $.getJSON( "/contact/list-json", {    
                    title: "Medico",
                    first_name__like : "%"+term + "%",
                    last_name__like__or : "%"+term + "%"
                  }, function( data, status, xhr ) {
                    cacheMedico[ term ] = data;
                    if ( xhr === lastXhr ) {
                      response( data.result );
                    }
                  });
                },
                focus: function( event, ui ) {
                  $medicoName.val( ui.item.first_name + " " + ui.item.last_name);
                  return false;
                },
                select: function( event, ui ) {
                  $medicoName.val( ui.item.first_name + " " + ui.item.last_name);
                  MedicosController.set( "content", [] );
                  MedicosController.addObject(Contact.create(ui.item));
                  return false;
                }
              })
              .data( "autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li></li>" )
                  .data( "item.autocomplete", item )
                  .append( "<a>" + item.first_name + " " + item.last_name +"</a>" )
                  .appendTo( ul );
              };
        }
    })

    //AnalysisSelectedController.select(miAnalisis);

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
            var prueba = this.get('prueba'),
                pacientes = PacientesController.get( "content" ),
                analysisCollection = AnalysisController.get( "content" ),
                analysis = analysisCollection[0],
                paciente = null,
                reference = null;

            if(pacientes.length){
                paciente = pacientes[0];
                // Busqueda de los valores de referencia para la prueba
                // con el genero del paciente
                ReferencesController.Search({            
                    gender__in: [paciente.get( "gender" ),"A"],
                    item_id: prueba.get( "id" )
                }, function(references){
                    if(references.length === 1){
                        reference = references[0];
                        //Registro de prueba
                        ResultsController.CreateNew({
                            analysis_id: analysis.get( "id" ) ,
                            item_id: prueba.get( "id"),
                            item_name: prueba.get( "name") ,
                            ref_val_id: reference.get( "id" ),
                            ref_val_value: reference.get( "value" ),
                            ref_val_unit: reference.get( "unit" )
                        }, function(resultNew){
                            resultNew.set("item_name", prueba.get("name"));
                            resultNew.set("ref_val_value", reference.get("value"));
                            resultNew.set("ref_val_unit", reference.get("unit"));
                            ResultsController.get("content").addObject(resultNew);
                        });
                    }else if(!references.length){
                        alert("No existe parámetros de referencia para la prueba");
                    }else{
                        alert("Existe mas de una valor de referencia.");
                    }        
                });
            }
            else{
                alert("Seleccione un paciente");
                console.log("Seleccione un paciente");
            }
            
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
    

    ResultsController = Ember.ArrayProxy.create({
        content: [],
        store: new Store({
            name: "result_store",
            url: "/results/rest"
        }) ,
        CreateNew: function(value, callback){
            var result = Result.create(value)
                resultNew = null,
                self = this;
            this.get( "store" ).save(result)
                .done(function(data){
                    if(data.result){
                        resultNew = Result.create(data.result);                        
                        callback && callback(resultNew);
                    }                    
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
            if(confirm("¿Esta seguro de eliminar el registro?")){
                var result = this.get('result');
                result.set("deleted", 1);
                ResultsController.Remove(result);
                console.log(result, "removiendo");
            }
        }
    });




    /*ResultsController.CreateNew(        
        {
            item_name: "prueba 1",
            ref_val_value: "value 1",
            ref_val_unit: "lt/x",
            analysis_id: 23,
            item_id: 27,
            ref_val_id: 6            
        }
    );*/

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
    Reference = Ember.Resource.extend({
        resourceUrl:        '/contacts',
        resourceName:       'reference',
        resourceProperties: ['id', 'value', 'unit', 'item_id', 'description', 'gender', 'type']
    });

    ReferencesController = Ember.ArrayProxy.create({
        content: [],
        store: new Store({
            name: "reference_store",
            url: "/references/list-json"
        }) ,
        Search: function(query, callback){    
            var self = this;        
            this.get( "store" ).search(query)
                .done(function(data){
                    var reference = null;
                    self.set( "content", [] );
                    if(data.references && data.references.length > 0){
                        $.map(data.references, function(item, index){
                            reference = Reference.create(item);
                            self.get("content").addObject(reference);    
                        });                                                
                    }
                    callback && callback(self.get("content"));                    
                })
                .fail(function(){
                    console.log("fail", "ups tenemos problemas huston");
                });
        }
        
    });

    
    Contact = Ember.Resource.extend({
        resourceUrl:        '/contacts',
        resourceName:       'contact',
        resourceProperties: ['id', 'first_name', 'last_name', 'gender', 'title']
    });

    PacientesController = Ember.ArrayProxy.create({
        content: [],
        store: new Store({
            name: "contacts_store",
            url: "/contacts/list-json"
        })
    });

    MedicosController = Ember.ArrayProxy.create({
        content: [],
        store: new Store({
            name: "contacts_store",
            url: "/contacts/list-json"
        })
    });

