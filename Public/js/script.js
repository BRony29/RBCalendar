/* Modal Bootstrap 5 d'ajout d'un évent avec date pré remplie */

var ajoutEvent = document.getElementById('ajoutEvent2')
ajoutEvent.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget
    var ajoutEvents = button.getAttribute('data-bs-dateModify')
    var modalBodyInput = ajoutEvent.querySelector('.info input')
    modalBodyInput.value = ajoutEvents
})

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