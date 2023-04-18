// export function showLoader(target) {
//     if(target.dataset.loader === "show") insertLoader(target, {disabled: false, submit: true})
// }

export function insertLoader(btn, options = {}) {
    btn.style.width = btn.offsetWidth + "px";
    btn.innerHTML = `<span data-content style="display: none">${btn.innerHTML}</span>` + generateLoader(options);
    btn.classList.add('loader-show');

    if(options.disabled !== false) btn.disabled = 'disabled';
    if(options.submit === true) {
        const form = btn.closest('form');
        if(form !== null) form.submit();
    }
}

export function removeLoader(btn) {
    btn.removeAttribute("style");
    btn.innerHTML = btn.querySelector('[data-content]').innerHTML;
    btn.disabled = null;
    btn.classList.remove('loader-show');
}

function generateLoader(options = {}) {
    const type = options.type !== undefined ? ' ' + options.type : '';
    return `<span class="loader loader-bars${type}"><span></span></span>`;
}
