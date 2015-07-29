import DS from 'ember-data';
import environment from 'ember-simple-crud/config/environment';

const { JSONAPIAdapter } = DS;
const { API } = environment;

export default JSONAPIAdapter.extend({

  host: API.host,
  namespace: API.namespace

});