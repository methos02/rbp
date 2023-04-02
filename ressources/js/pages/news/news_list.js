import {defineTarget} from "../../utils/event";
import {get} from "../../utils/axios";

if(document.getElementById('container_news_list') !== null) {
    document.addEventListener('change', async e => {
        const target = defineTarget(e.target);

        if(target.name === "section") await loadSectionNews(target);

    });
}

async function loadSectionNews(select) {
    /** @param {{news_list:string, paginator:string}} res */
    const res = await get('/news/' + select.value);

    if(res.status === 200) {
        document.getElementById('news_list').innerHTML = res.data.news_list;
        [...document.querySelectorAll('[data-component="paginator"]')].forEach(paginator => paginator.innerHTML = res.data.paginator);
        history.pushState({}, 'rbp', '/news/' + select.value)
    }
}
