const express = require('express');
const app = express();
const mongoose = require('mongoose');
const path = require('path');
const Distributor = require('./models/distributor');
const Product = require('./models/product');
const PORT = 3000;
const xml = require('xml');

app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'hbs');
app.use(express.static('public'));

// const xmlConverter = (data) => {
//   return data.reduce((result, el) => {
//     const keys = Object.keys(el);
//     console.log('el', el);
//     const resultString = keys.reduce((result, key) => {
//       return result + `<${key}>${el[key]}</${key}>`;
//     }, '');
//     return `${result}${resultString}\n`;
//   }, '');
// };

const formatConfig = {
  json: (data, res) => {
    res.json(data);
  },
  xml: (data, res) => {
    const xml = `
      <products>
        ${data.products.map((product) => `
          <product>
            <name>${product.name}</name>
            <state>${product.state}</state>
            <reviews>${product.reviews.length ? product.reviews.join(', ') : 'No reviews'}</reviews>
            <distributor>${product.distributorId.name}</distributor>
            <price>${product.price}</price>
            <quantity>${product.quantity}</quantity>
            <category>${product.category}</category>
          </product>
        `).join('')}    
      </products>
    `;
    console.log('xml', xml);
    res.set('Content-Type', 'text/xml');
    res.send(xml);
  },
  html: (data, res) => {
    res.render('table', data, (err, html) => {
      res.json({
        data: html,
      })
    })
  },
};

app.get('/', (req, res) => {
  res.render('main', {});
});

app.get('/api/distributors', (req, res) => {
  Distributor.find({}, (err, distributors) => {
    if (err) {
      console.log('err -> distributor ->', err);
      return res.send({ distributors: []});
    }
    return  res.send({ distributors: distributors});
  })
});

app.get('/api/products', (req, res) => {
  const { inStock = 0, min = '0', max = '0', responseType = 'json' } = req.query;
  console.log('reqquery', req.query);
  const where = {};

  if (+inStock === 1) {
    where['quantity'] = {
      $gt: 0,
    }
  }

  where['price'] = {
    $gte: min,
    $lte: max,
  };

  console.log('where>>', where);
  Product
    .find({
      ...where
    })
    .populate('distributorId')
    .exec((err, products) => {
      if (err) {
        console.log('err -> products -> ', err);
        return formatConfig[responseType]({products: []}, res);
      }
      return formatConfig[responseType]({products: products}, res);
  });
});


mongoose.connect('mongodb+srv://vanos:12345@cluster0.tfjtz.mongodb.net/myFirstDatabase?retryWrites=true&w=majority', () => {
  app.listen(PORT, () => {
   //  console.log('server runnin on port = ', PORT);
   //  const distributor = new Distributor({ name: Math.random().toString(36).substring(7)});
   //  distributor.save().then(() => {});
   // (new Product({
   //    name: 'product 1',
   //    price: 300,
   //    distributorId: distributor.id,
   //    quantity: 100,
   //    category: 'random',
   //    reviews: ['some', 'some', 'not some', 'not bad'],
   //    state: 'new',
   //  })).save().then(() => {});
   //  (new Product({
   //    name: 'product 2',
   //    price: 100,
   //    quantity: 10,
   //    distributorId: distributor.id,
   //    category: 'random2',
   //    reviews: ['some', 'some', 'not some', 'not bad'],
   //    state: 'new',
   //  })).save().then(() => {});
   //  (new Product({
   //    name: 'product 3',
   //    price: 115,
   //    quantity: 0,
   //    distributorId: distributor.id,
   //    category: 'random3',
   //    reviews: ['somasde', 'some', 'not some', 'not bad'],
   //    state: 'used',
   //  })).save().then(() => {});
  });
});
