Prosalud.models.Test = Ember.Resource.extend({
    resourceUrl:        '/tests/rest',
    resourceName:       'test',
    resourceProperties: ['id', 'item_name', 'specialty_id', 'amount', 'process_time', 'description', 'deleted', 'date_entered', 'date_modified']
});