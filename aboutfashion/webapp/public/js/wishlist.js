attachEvents()
function attachEvents() {
    for(const button of document.getElementsByClassName('button-like')){
        button.addEventListener('click', changeLike)
    }
} 
function changeLike(elem) {
    let product = elem.target.id
    let token = document.getElementsByName('_token')[0].value
    const request = new XMLHttpRequest()
    request.open('post', '/api/wishlist', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send('id_product=' + product + '&_token=' + token)
    request.onload = function () {
        if (request.status == 200) {
            let string = 'row-'+ product
            document.getElementById(string).remove()
        } else {
            //TODO adicionar mensagem de erro
            console.log('Error')
        }
    }
}