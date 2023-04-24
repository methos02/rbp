import {initCkeEditor} from "../../librairies/cke_editor";

export function initTextarea() {
    [...document.querySelectorAll('[data-library="cke_editor"]')].forEach(async textarea => await initCkeEditor(textarea))
}
