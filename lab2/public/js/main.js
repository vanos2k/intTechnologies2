const mainUrl = window.location.href;
const distributorsContainerEl = document.querySelector('[data-type="distributors-container"]');
const productsContainerEl = document.querySelector('[data-type="products-container"]');
const quantityCheckboxEl = document.getElementById('quantity');
const refreshProductsButton = document.querySelector('[data-type="range-price-products"]');
const minPriceInputEl = document.getElementById('price-min');
const maxPriceInputEl = document.getElementById('price-max');
const formatSelectEl = document.getElementById('formats');

const resetProductsTable = () => {
  productsContainerEl.innerHTML = `
      <tr>
        <th>Name</th>
        <th>State</th>
        <th>Reviews</th>
        <th>Distributor</th>
        <th>price</th>
        <th>quantity</th>
        <th>category</th>
    </tr>
  `;
};

const formatConfig = {
  json: (response) => {
    response.json().then((result) => {
      result.products.forEach((product) => {
        const el = document.createElement('tr');
        el.innerHTML = `
          <td>${product.name}</td>
          <td>${product.state}</td>
          <td>${product.reviews.length ? product.reviews.join(', ') : 'No reviews'}</td>
          <td>${product.distributorId.name}</td>
          <td>${product.price}</td>
          <td>${product.quantity}</td>
          <td>${product.category}</td>
        `;
        productsContainerEl.appendChild(el);
      });
    });
  },
  html: (response) => {
    response.json().then((result) => {
      productsContainerEl.innerHTML = result.data;
    });
  },
  xml: (response) => {
    response
      .text()
      .then(str => (new window.DOMParser()).parseFromString(str, "text/xml"))
      .then(xmlData => {
        const products = xmlData.getElementsByTagName('product');
        const names = xmlData.getElementsByTagName('name');
        const states = xmlData.getElementsByTagName('state');
        const reviews = xmlData.getElementsByTagName('reviews');
        const distributors = xmlData.getElementsByTagName('distributor');
        const prices = xmlData.getElementsByTagName('price');
        const quantitys = xmlData.getElementsByTagName('quantity');
        const categorys = xmlData.getElementsByTagName('category');

        for (let i = 0; i < products.length; ++i) {
          const el = document.createElement('tr');
          el.innerHTML = `
            <td>${names[i].firstChild.nodeValue}</td>
            <td>${states[i].firstChild.nodeValue}</td>
            <td>${reviews[i].firstChild.nodeValue}</td>
            <td>${distributors[i].firstChild.nodeValue}</td>
            <td>${prices[i].firstChild.nodeValue}</td>
            <td>${quantitys[i].firstChild.nodeValue}</td>
            <td>${categorys[i].firstChild.nodeValue}</td>
          `;
          productsContainerEl.appendChild(el);
        }
      })
  }
};

const fetchProducts = () => {
  const minPrice = minPriceInputEl.value;
  const maxPrice = maxPriceInputEl.value;
  const format = formatSelectEl.value;
  console.log('min price->', minPrice);
  console.log('max price->', maxPrice);
  console.log('current format->', format);

  fetch(`${mainUrl}api/products?responseType=${format}&inStock=${quantityCheckboxEl.checked ? 1 : 0}&min=${minPrice}&max=${maxPrice}`)
    .then((response) => {
      console.log('responseProducts ->', response);
      formatConfig[format](response);
    });
};

const fetchDistributors = () => {
  fetch(`${mainUrl}api/distributors`)
    .then((response) => {
      console.log('responseDistributors -> ', response);
      return response.json();
    })
    .then(result => {
      console.log('result', result);
      result.distributors.forEach((distributor) => {
        const el = document.createElement('p');
        el.innerText = `Name -> ${distributor.name}`;
        distributorsContainerEl.appendChild(el);
      })
    });
};

const fetchProductsProcess = () => {
  resetProductsTable();
  fetchProducts();
};

window.addEventListener('load', (event) => {
  quantityCheckboxEl.addEventListener('change', fetchProductsProcess);
  refreshProductsButton.addEventListener('click', fetchProductsProcess);
  formatSelectEl.addEventListener('change', fetchProductsProcess);
  fetchProductsProcess();
  // fetchDistributors();
});
