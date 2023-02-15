//TODO Adicionar mensagens de erro
attachEvents()
updatePrice()

function attachEvents() {
    for (const button of document.getElementsByClassName('delete-detail'))
        button.addEventListener('click', deleteProduct)
    for (const button of document.getElementsByClassName('update-quantity'))
        button.addEventListener('change', updateQuantity)
}

function deleteProduct(elem) {
    let token = document.getElementsByName('_token')[0].value
    let detail = elem.target.id
    const request = new XMLHttpRequest()
    request.open('delete', '/api/shopping-cart', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send('id_detail=' + detail + '&_token=' + token)


    request.onload = function () {
        if (request.status == 200) {
            let string = 'row-' + detail
            console.log(string)
            document.getElementById(string).remove()
            console.log('teste1')
            updatePrice()
        } else {
            console.log('ERROR!')
        }
    }
}

function updateQuantity(elem) {
    let token = document.getElementsByName('_token')[0].value
    let detail = elem.target.id
    let quantity = elem.target.value

    const request = new XMLHttpRequest()
    request.open('PATCH', '/api/shopping-cart', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send('id_detail=' + detail + '&quantity=' + quantity + '&_token=' + token)


    request.onload = function () {
        if (request.status == 400) {
            let response = JSON.parse(request.responseText)
            elem.target.value = response['quantity']
            console.log('Error! Bad request!')
        } else if (request.status == 200) {
            document.getElementById('quantity-' + detail).innerText = quantity
            console.log('OK!')
            updatePrice()
        } else {
            console.log('Error!')
        }
    }
}

function updatePrice() {
    let subtotalElem = document.getElementById('subtotal')
    let discountElem = document.getElementById('discount')
    let totalElem = document.getElementById('total')

    let subtotal = 0
    let total = 0

    let ids = document.getElementsByClassName('row-product-table')
    console.log(ids)
    for (const idElem of ids) {
        id = idElem.id.substring(4)
        quantity = document.getElementById('quantity-' + id).innerText
        subtotal += document.getElementById('original-price-' + id).innerText * quantity
        total += document.getElementById('final-price-' + id).innerText * quantity
    }

    subtotalElem.innerText = subtotal.toFixed(2) + '€'
    discountElem.innerText = (subtotal - total).toFixed(2) + '€'
    totalElem.innerText = total.toFixed(2) + '€'
}