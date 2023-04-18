import {insertLoader, removeLoader} from "./loader";
import {getSecureElement} from "./dom";

// export function clearForm(form) {
//     const inputs = form.querySelectorAll(`input[type], textarea, select`);
//
//     Array.from(inputs, input => {
//         if(input.tagName === 'SELECT' ) { input.value = 'none'; return;}
//         input.value = '';
//     })
// }

export function insertError(form, errors) {
    Object.entries(errors).forEach(([input_name,error]) => {
        const [first_name, second_name] = input_name.split('.');
        const selector = second_name !== undefined ? `${first_name}[${second_name}]` : first_name;

        getSecureElement(`[name="${selector}"]`, form).closest('div').insertAdjacentElement('beforeend', createHtmlError(error));
    })
}
export function removeErrors(div) {
    const errors = div.querySelectorAll('[data-error]');
    if( errors == null) return;

    Array.from(errors, error => error.remove());
}

export function disableSubmit(form) {
    form.dataset.action = "send";
    const btn_submit = form.querySelector('[type="submit"]');
    insertLoader(btn_submit, {type: 'mini'});
}

export function enableSubmit(form) {
    form.removeAttribute('data-action');
    const btn_submit = form.querySelector('[type="submit"]');
    removeLoader(btn_submit);
}

export function createHtmlError(error) {
    const html_error = document.createElement('p');
    html_error.classList.add('message-error');
    html_error.innerText = error;
    html_error.dataset.error = 'true';
    return html_error;
}
