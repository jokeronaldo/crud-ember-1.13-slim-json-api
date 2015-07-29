import Mirage from 'ember-cli-mirage';

const { Factory } = Mirage;

export default Factory.extend({

  id: (i) => `${i}`,
  name: (i) => `User ${i+1}`,
  email: (i) => `user${i+1}@email.com`

});