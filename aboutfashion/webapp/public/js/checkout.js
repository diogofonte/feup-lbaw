attachEvents()

function attachEvents() {
    const addressElements = document.querySelectorAll('div.addressClass input');
    let id_address = addressElements[addressElements.length - 1].getAttribute('value')
    // Obtém todos os elementos do tipo div


    // Adiciona um evento de click a cada elemento
    addressElements.forEach(element => {
        element.addEventListener('click', event => {
            // Obtém o id do elemento clicado
            id_address = event.target.getAttribute('value');
        });
    });
    const cardElements = document.querySelectorAll('div.cardClass input');
    let id_card = cardElements[cardElements.length - 1].getAttribute('value')
    // Obtém todos os elementos do tipo div
    // Adiciona um evento de click a cada elemento
    cardElements.forEach(element => {
        element.addEventListener('click', event => {
            // Obtém o id do elemento clicado
            id_card = event.target.getAttribute('value');
        });
    });
    let button_buyNow = document.getElementById("button_buyNow")
    let token = document.getElementsByName('_token')[0].value
    button_buyNow.addEventListener("click", event => {
        const request = new XMLHttpRequest()
        request.open('post', '/checkout', true)
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        request.send('id_address=' + id_address + '&id_card=' + id_card +'&_token='+token)
        request.onload = function () {
            eval(request.response)
        }
    });
}


