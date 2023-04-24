import './../scss/app.scss';

import('./pages/news/news_list');

import {initModal} from "./components/modal";
import {defineTarget} from "./utils/event";
import {initPassword} from "./layouts/inputs/password";
import {validateSubmitForm} from "./forms/form";
import {initTextarea} from "./layouts/inputs/textarea";
import {previewImage} from "./layouts/inputs/file_image";

document.addEventListener("DOMContentLoaded", async () => {
    initTextarea();
});

document.addEventListener('click', async e => {
    const target = defineTarget(e.target);

    initModal(target);
    initPassword(e, target);
});

document.addEventListener('submit', e => {
    const target = defineTarget(e.target);

    if(target.dataset.validate !== undefined) validateSubmitForm(target, e);
});

document.addEventListener('change', e => {
    const target = defineTarget(e.target);

    if(target.type === "file" && target.dataset.preview !== undefined) previewImage(e, target);
});
