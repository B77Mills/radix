import DS from 'ember-data';
import Ember from 'ember';

export default Ember.Mixin.create({
    key:  DS.attr('string'),
    name: DS.attr('string'),
});
