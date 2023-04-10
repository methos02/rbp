import './../scss/app.scss';

import('./pages/news/news_list');

import {initModal} from "./components/modal";
import {defineTarget} from "./utils/event";
document.addEventListener('click', async e => {
    const target = defineTarget(e.target);

    initModal(target);
});
