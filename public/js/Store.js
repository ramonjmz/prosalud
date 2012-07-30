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
                type: "get",
                data: query,

            });



            //jxhr = $.getJSON( "/items/list-json", query);

            return jxhr;
        }
    };