showProduct()
attachEvents()

function attachEvents() {
    let select = document.getElementById('productSelect')
    select.addEventListener('change', showProduct)
}


function showProduct() {
    const img = document.querySelector('#edit_form .form-select option:checked')
    document.getElementById('productImg').setAttribute('src', img.dataset.img)
    console.log(img.dataset.img)
    console.log(document.getElementById('productImg'))
}
