attachEvents()
function attachEvents() {
    for (const button of document.getElementsByClassName('delete-order'))
        button.addEventListener('click', deleteOrder)
}

function deleteOrder(elem) {
    let token = document.getElementsByName('_token')[0].value
    const request = new XMLHttpRequest()
    request.open('delete', '/api/admin-panel/orders/' + elem.target.id, true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send('_token=' + token)

    request.onload = function () {
        if (request.status == 200) {
            document.getElementById('accordion-item-' + elem.target.id).remove()
        } else {
            console.log('ERROR!')
        }
    }
}