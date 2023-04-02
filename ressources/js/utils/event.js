export function defineTarget(target) {
    if(target.tagName === 'I' && Object.keys({...target.dataset}).length !== 0) return target;

    const closest_btn = target.closest('button');
    if(closest_btn !== null) return closest_btn;

    const closest_link = target.closest('a');
    if(closest_link !== null) return closest_link;

    return target;
}
