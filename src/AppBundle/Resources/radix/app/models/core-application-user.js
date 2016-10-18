import DS from 'ember-data';
import Timestampable from 'radix/models/mixins/timestampable';

const { Model, attr, belongsTo } = DS;

export default Model.extend(Timestampable, {
    user:        belongsTo('core-user'),
    application: belongsTo('core-application'),
});
