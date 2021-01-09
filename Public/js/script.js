/* Modal Bootstrap 5 de visualisation des events */

// var viewEvent = document.getElementById('viewEvent')
// viewEvent.addEventListener('show.bs.modal', function(event) {
//     var button = event.relatedTarget
//     var subjectView = button.getAttribute('data-bs-subjectView')
//     var descriptionView = button.getAttribute('data-bs-descriptionView')
//     var locationView = button.getAttribute('data-bs-locationView')
//     var dateView = button.getAttribute('data-bs-dateView')
//     var modalBody0Input = viewEvent.querySelector('.modal-body0 input')
//     modalBody0Input.value = subjectView
//     var modalBody1Input = viewEvent.querySelector('.modal-body1 input')
//     modalBody1Input.value = locationView
//     var modalBody2Input = viewEvent.querySelector('.modal-body2 input')
//     modalBody2Input.value = dateView
//     var modalBody3Input = viewEvent.querySelector('.modal-body3 textarea')
//     modalBody3Input.value = descriptionView
// })

/* Modal Bootstrap 5 de suppression d'un event */

// var deleteEvent = document.getElementById('deleteEvent')
// deleteEvent.addEventListener('show.bs.modal', function(event) {
//     var button = event.relatedTarget
//     var deleteEvents = button.getAttribute('data-bs-deleteEvents')
//     var modalBodyInput = deleteEvent.querySelector('.modal-body input')
//     modalBodyInput.value = deleteEvents
// })

/* Modal Bootstrap 5 de modification et de suppression d'un events */

var modifyEvent = document.getElementById('modifyEvent')
modifyEvent.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget
    var subjectModify = button.getAttribute('data-bs-subjectModify')
    var descriptionModify = button.getAttribute('data-bs-descriptionModify')
    var locationModify = button.getAttribute('data-bs-locationModify')
    var dateModify = button.getAttribute('data-bs-dateModify')
    var hourModify = button.getAttribute('data-bs-hourModify')
    var idModify = button.getAttribute('data-bs-idModify')
    var modalBody0Input = modifyEvent.querySelector('.modal-body0 input')
    modalBody0Input.value = subjectModify
    var modalBody1Input = modifyEvent.querySelector('.modal-body1 input')
    modalBody1Input.value = locationModify
    var modalBody2Input = modifyEvent.querySelector('.modal-body2 input')
    modalBody2Input.value = dateModify
    var modalBody3Input = modifyEvent.querySelector('.modal-body3 input')
    modalBody3Input.value = hourModify
    var modalBody4Input = modifyEvent.querySelector('.modal-body4 textarea')
    modalBody4Input.value = descriptionModify
    var modalBody5Input = modifyEvent.querySelector('.modal-body5 input')
    modalBody5Input.value = idModify
    var modalBody6Input = modifyEvent.querySelector('.modal-body6 input')
    modalBody6Input.value = idModify
})

/* Tooltips Bootstrap 5 */

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})