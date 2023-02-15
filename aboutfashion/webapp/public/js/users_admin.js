attachEvents()

function attachEvents() {
    for (const button of document.getElementsByClassName('delete-user'))
        button.addEventListener('click', deleteUser)
    for (const button of document.getElementsByClassName('block-user'))
        button.addEventListener('click', blockUser)
}

function deleteUser(elem) {
    let token = document.getElementsByName('_token')[0].value
    const request = new XMLHttpRequest()
    request.open('delete', '/api/admin-panel/users', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send('id=' + elem.target.id + '&_token=' + token)

    request.onload = function () {
        if (request.status == 200) {
            document.getElementById('accordion-item-' + elem.target.id).remove()
        } else {
            console.log('ERROR!')
        }
    }
}

function blockUser(elem) {
    let token = document.getElementsByName('_token')[0].value
    let id_user = elem.target.id.slice(6)
    const request = new XMLHttpRequest()
    request.open('PATCH', '/api/admin-panel/users', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send('id=' + id_user + '&_token=' + token)
    request.onload = function () {
        if (request.status == 200) {
            let response = JSON.parse(request.responseText)
            if (response['block'] == 1) {
                document.getElementById('badge-block-' + id_user).style = ""
                document.getElementById('block-' + id_user).classList.replace('fa-lock', 'fa-unlock')
            } else {
                document.getElementById('badge-block-' + id_user).style = "display: none;"
                document.getElementById('block-' + id_user).classList.replace('fa-unlock', 'fa-lock')
            }
        } else {
            console.log('ERROR!')
        }
    }
}

