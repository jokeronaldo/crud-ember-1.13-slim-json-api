import Ember from 'ember';

const { Route } = Ember;

export default Route.extend({

  model() {
    return this.store.findAll('user');
  },

  actions: {

    save(model) {
      model.save().then(() => {
        this.transitionTo('user.list');
      },
      (reason) => {
        console.error(reason);
      });
    },

    cancel(model) {
      model.rollbackAttributes();
      this.transitionTo('user.list');
    },

    delete(model) {
      model.deleteRecord();
      model.save().then(() => {
        this.transitionTo('user.list');
      },
      (reason) => {
        console.log(reason);
      });
    }

  }

});