import {getSecureClosestElement, getSecureElement} from "../../utils/dom";

export function initPassword(e, target) {
    if(target.dataset.password === "show") showPassword(e, target);
}

function showPassword(e, btn) {
    e.preventDefault();
    const div_input = getSecureClosestElement('div', btn);
    const i_input = getSecureElement('i', div_input);
    const password_visible = !i_input.classList.contains('glyphicon-eye-open');

    getSecureElement('input', div_input).type = password_visible ? 'password' : 'text';

    i_input.classList.replace(password_visible ? 'glyphicon-eye-close' : 'glyphicon-eye-open', password_visible ? 'glyphicon-eye-open' : 'glyphicon-eye-close');
}
