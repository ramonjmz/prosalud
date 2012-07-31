Prosalud.models.Result = Ember.Resource.extend({
    resourceUrl:        '/result/rest',
    resourceName:       'result',
    resourceProperties: ['id', 'analysis_id', 'item_id', 'item_name', 'ref_val_id', 'ref_val_value', 'ref_val_unit', 'result', 'deleted']
});