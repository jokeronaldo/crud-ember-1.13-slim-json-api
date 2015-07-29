import Ember from 'ember';

const { Route } = Ember;

export default Route.extend({

  templateName: 'user.edit',
  
  model() {
    return this.store.createRecord('user');
  }

});