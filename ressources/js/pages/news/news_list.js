import {defineTarget} from "../../utils/event";
import {get} from "../../utils/axios";

if(document.getElementById('container_news_list') !== null) {
    document.addEventListener('click', async e => {
        const target = defineTarget(e.target);

        if(target.dataset.page !== undefined) await changePageNews(target);
    });

    document.addEventListener('change', async e => {
        const target = defineTarget(e.target);

        if(target.name === "section") await changeSectionNews(target);
    });
}

async function changeSectionNews(select) {
    await loadSectionNews('/news/' + select.value, 0);
}

async function changePageNews(button) {
    await loadSectionNews(location.pathname, button.dataset.page);
}

async function loadSectionNews(url, page) {
    /** @param {{news_list:string, paginator:string}} res */
    const res = await get(url, {page});

    if(res.status === 200) {
        document.getElementById('news_list').innerHTML = res.data.news_list;
        [...document.querySelectorAll('[data-component="paginator"]')].forEach(paginator => paginator.innerHTML = res.data.paginator);
        history.pushState({}, 'rbp', '/news/' + select.value)
    }
}
