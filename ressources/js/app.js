import './../scss/app.scss';

import('./pages/news/news_list');

import {initModal} from "./components/modal";
import {defineTarget} from "./utils/event";
import {initPassword} from "./layouts/inputs/password";
import {validateSubmitForm} from "./forms/form";
document.addEventListener('click', async e => {
    const target = defineTarget(e.target);

    initModal(target);
    initPassword(e, target);
});

document.addEventListener('submit', e => {
    const target = defineTarget(e.target);

    if(target.dataset.validate !== undefined) validateSubmitForm(target, e);
});
