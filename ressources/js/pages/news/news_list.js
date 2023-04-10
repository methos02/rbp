import {defineTarget} from "../../utils/event";
import {get} from "../../utils/axios";
import {definePageParam, definePageUrl} from "../../components/paginator";
import {getSecureElementById} from "../../utils/dom";
import {modal_show} from "../../components/modal";
import {insertError} from "../../components/flash";

if(document.getElementById('container_news_list') !== null) {
    document.addEventListener('click', async e => {
        const target = defineTarget(e.target);

        if(target.dataset.page !== undefined) await loadSectionNews(location.pathname, target.dataset.page);
        if(target.dataset.news !== undefined) await show_news(target.dataset.news);
    });

    document.addEventListener('change', async e => {
        const target = defineTarget(e.target);

        if(target.name === "section") await changeSectionNews(target);
    });

    document.addEventListener('keydown', async e => {
        const target = defineTarget(e.target);

        if(target.name === "page_count" && ['Enter', 'NumpadEnter'].includes(e.code) && e.shiftKey === false) await loadSectionNews(location.pathname, target.value - 1);
    });
}

async function changeSectionNews(select) {
    const section_slug = select.value !== '' ? `/${select.value}` : '';
    await loadSectionNews('/news' + section_slug, 0);
}

async function loadSectionNews(url, page) {
    /** @param {{news_list:string, paginator:string}} res */
    const res = await get(url, {page : definePageParam(page)});

    if(res.status === 200) {
        document.getElementById('news_list').innerHTML = res.data.news_list;
        [...document.querySelectorAll('[data-component="paginator"]')].forEach(paginator => paginator.innerHTML = res.data.paginator);

        history.pushState({}, 'rbp', url + definePageUrl(parseInt(page)))
    }
}

async function show_news(news_id) {
    /** @param {{news:string}} res */
    const res = await get(`/news/${news_id}`);

    if(res.status === 200) {
        getSecureElementById('news-modal').innerHTML = res.data.news;
        modal_show('news-modal');
    }

    if(res.status !== 200) {
        insertError(res.data.error);
    }
}
