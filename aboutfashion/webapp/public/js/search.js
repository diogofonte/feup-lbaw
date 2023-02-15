showAll()
attachEvents()

function getCurrentURL () {
    return window.location.href
  }

function attachEvents() {
    order = document.getElementById("order")
    order.addEventListener("change", selectOrder)
    button = document.getElementById('filterButton')
    button.addEventListener('click', selectFilters)
    search = document.getElementById('searchButton')
    search.addEventListener('click', selectSearch)
}
async function selectOrder() {
    showSpinner();
    url = document.getElementById("url_api").value
    params = parseQueryString(url)
    order_ = document.getElementById("order").value
    if (!(order_ == 'Order')) {
        params['order']=order_
        url = makeUrl(params)
        const response = await fetch(url)
        const products = await response.json()
        if (response) {
            hideSpinner();
        }
        let oldBody = document.getElementById("data-output")
        let newBody = drawProducts(products)
        oldBody.innerHTML = newBody
        document.getElementById("url_api").setAttribute("value",url) 
    }else{
        delete params.order;
        url = makeUrl(params)
        const response = await fetch(url)
        const products = await response.json()
        if (response) {
            hideSpinner();
        }
        let oldBody = document.getElementById("data-output")
        let newBody = drawProducts(products)
        oldBody.innerHTML = newBody
        document.getElementById("url_api").setAttribute("value",url) 

    }
   
}


async function showAll() {
    showSpinner();
    const response = await fetch('/api/products')
    const products = await response.json()
    if (response) {
        hideSpinner();
    }
    let oldBody = document.getElementById("data-output")
    let newBody = drawProducts(products)

    oldBody.innerHTML = newBody
}
function parseQueryString(queryString) {
    // Separa a string em elementos separados por '&'
    let elements = queryString.split('&');

    // Cria um objeto vazio para armazenar os elementos
    const params = {};
    if(elements[0].split('?')[1] != ''){
        params[elements[0].split('?')[1].split('=')[0]]=elements[0].split('?')[1].split('=')[1]
    }
    elements.shift();
    // Percorre cada elemento
    for (const element of elements) {
        // Separa o elemento em chave e valor
        const [key, value] = element.split('=');

        // Adiciona o elemento ao objeto
        params[key] = value;
    }

    // Retorna o objeto
    return params;
}

function makeUrl(params){
    let url = '/api/products?'
    const keys = Object.keys(params);
    const values = Object.values(params);
    for(let i=0;i<keys.length;i++){
        url += String(keys[i])
        url += '='
        url += values[i]
        if(i!=(keys.length-1)){
            url += '&'
        }
    }
    return url;
}


async function selectSearch(element) {
    showSpinner();
    url = document.getElementById("url_api").value
    params = parseQueryString(url)
    let name = document.getElementById('fname').value
    if((!(name == '' ))){
        params['product_name']=name
        url = makeUrl(params)
        const response = await fetch(url)
        const products = await response.json()
        if (response) {
            hideSpinner();
        }
        let oldBody = document.getElementById("data-output")
        let newBody = drawProducts(products)

        oldBody.innerHTML = newBody
        document.getElementById("url_api").setAttribute("value",url) 
    }else{
        delete params.product_name;
        url = makeUrl(params)
        const response = await fetch(url)
        const products = await response.json()
        if (response) {
            hideSpinner();
        }
        let oldBody = document.getElementById("data-output")
        let newBody = drawProducts(products)

        oldBody.innerHTML = newBody
        document.getElementById("url_api").setAttribute("value",url) 
    }
}


async function selectFilters(element) {
    showSpinner();
    url = document.getElementById("url_api").value
    params = parseQueryString(url)
    category = document.getElementById('category').value
    if (!(category == 'Select category')) {
        params['id_category']=category
    }else{
        delete params.id_category;
    }
    size = document.getElementById('size').value
    if (!(size == 'Select size')) {
        params['id_size']=size
    }else{
        delete params.id_size;
    }

    color = document.getElementById('color').value
    if (!(color == 'Select color')) {
        params['id_color']=color
    }else{
        delete params.id_color;
    }
    valueMin = document.getElementById('value-min').innerText
    params['min_price']=valueMin

    valueMax = document.getElementById('value-max').innerText
    params['max_price']=valueMax

    min_classification_ = document.getElementById('slider-range-value').innerText
    if (!(min_classification_ == 0)) {
        params['min_classification']=min_classification_
    } else {
        delete params.min_classification;
    }
    url = makeUrl(params)
    const response = await fetch(url)
    const products = await response.json()
    if (response) {
        hideSpinner();
    }
    let oldBody = document.getElementById("data-output")
    let newBody = drawProducts(products)
    oldBody.innerHTML = newBody
    document.getElementById("url_api").setAttribute("value",url) 
}

function drawProducts(products) {
    let out = "";
    for (const val of products) {
        out += `
            <div class="col-md-3 col-sm-6 mx-4 mt-2 mb-2 d-inline-block">
                <div class="product-grid">
                    <div class="product-image shadow">
                        <a href="/products/${val.id}" class="image">
                            <img src="${val.images[0]}" width="227" height="313">
                        </a>
                        <span class="product-discount-label">${havePromo(val.promotion.discount)}</span>
                    </div>
                    <div class="product-content shadow">
                        <h3 class="title"><a href="/products/${val.id}">${val.name}</a></h3>
                        <div class="price">${havePromo1(val.price, val.promotion.discount)} <span>${havePromo2(val.price, val.promotion.discount)}</span></div>
                    </div>
                </div>
            </div>

        `;
    }

    return out;
}


function havePromo2(value, promo) {
    let result;
    if (promo == undefined) {
        result = "";
    } else {
        result = value + '€';
    }
    return result;
}

function havePromo1(value, promo) {
    let result;
    if (promo == undefined) {
        result = value + '€';
    } else {
        result = Math.round(value - (value * (promo / 100))) + '€';
    }
    return result;
}

function havePromo(promo) {
    let result;
    if (promo == undefined) {
        result = "";
    } else {
        result = '-' + promo + '%';
    }
    return result;
}

function hideSpinner() {
    document.getElementById('spinner').style.display = 'none';
}

function showSpinner() {
    document.getElementById('spinner').style.display = 'block';
    document.getElementById('data-output').innerHTML = '';
}
