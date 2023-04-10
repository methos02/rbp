import {getSecureElementById} from "../utils/dom";

export function initModal(target) {
    if(target.dataset.modal === "show") modal_show(target.dataset.target);
    if(target.dataset.modal === "close") modal_close(target.dataset.target);
}

export function modal_show(modal_id) {
    getSecureElementById(modal_id).classList.add('show');
    document.body.classList.add('modal-show');
    document.dispatchEvent(new Event('modal_show', { bubbles: true }));
}

export function modal_close(modal_id) {
    getSecureElementById(modal_id).classList.remove('show');
    document.body.classList.remove('modal-show');
}
