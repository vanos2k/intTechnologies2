const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const distributorScheme = new Schema({
  name: String,
});

module.exports = mongoose.model('Distributor', distributorScheme);
