attachEvents()
function attachEvents() {
    for (const button of document.getElementsByClassName('change-report'))
        button.addEventListener('click', changeReport)
}

function changeReport(elem) {
    let token = document.getElementsByName('_token')[0].value
    let id_report = elem.target.id
    const request = new XMLHttpRequest()
    request.open('PATCH', '/api/admin-panel/reports', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.send('id=' + id_report + '&_token=' + token)
    request.onload = function () {
        if (request.status == 200) {
            let response = JSON.parse(request.responseText)
            if (response['resolved'] == 1) {
                document.getElementById('badge-change-' + id_report).style = ""
                document.getElementById(id_report).classList.replace('fa-envelope', 'fa-envelope-open')
            } else {
                document.getElementById('badge-change-' + id_report).style = "display: none;"
                document.getElementById(id_report).classList.replace('fa-envelope-open', 'fa-envelope')
            }
        } else {
            console.log('ERROR!')
        }
    }
}