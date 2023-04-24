export async function initCkeEditor(textarea) {
    return await new Promise( resolve => {
        let interval_id;

        interval_id = setInterval(async () => {
            if (typeof CKEDITOR !== "undefined") {
                resolve(CKEDITOR.replace(textarea.id));
                clearInterval(interval_id);
            }
        }, 10)
    });
}
