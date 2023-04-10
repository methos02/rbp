import {getSecureElementById} from "../utils/dom";

export function insertError(title, content) {
    insertFlash('danger', title, content);
}

function insertFlash(type, title, content = "") {
    const flash = document.createElement('div');
    flash.setAttribute('class', `alert alert-${type} message-unique`);
    flash.id = "message-flash";
    flash.dataset.flash = "";

    flash.insertAdjacentHTML('beforeend', `<div class="message-title">${title}</div>`);
    flash.insertAdjacentHTML('beforeend', `<div class="message-content">${content}</div>`);
    flash.insertAdjacentHTML('beforeend', `<a href="" class="message-close" data-action="message-close"><span class="glyphicon glyphicon-remove"></span></a>`);

    getSecureElementById('container-flashes').insertAdjacentElement('afterbegin', flash);
}
