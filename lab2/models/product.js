const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const productSchema = new Schema({
  name: String,
  price: Number,
  quantity: Number,
  distributorId: {
    type: Schema.Types.ObjectId,
    ref: 'Distributor',
  },
  category: String,
  reviews: Array,
  state: {
    type: String,
    enum: ['new', 'used'],
    default: 'used',
  },
});

module.exports = mongoose.model('Product', productSchema);
