import Ember from 'ember';
import config from './config/environment';

var Router = Ember.Router.extend({
  location: config.locationType
});

Router.map(function() {
  this.route('user', function() {
    this.route('list', { path: '/' });
    this.route('new');
    this.route('edit', { path: '/:user_id/edit' });
  });
});

export default Router;
