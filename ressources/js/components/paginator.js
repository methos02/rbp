export function definePageUrl(page) {
    return page !== 0 ? `?page=${page}` : '';
}

export function definePageParam(page) {
    return page !== 0 ? page : null;
}
