import {throwError} from "./error";

export function getSecureElement(selector, container = null) {
    const element = container !== null ? container.querySelector(selector) : document.querySelector(selector);
    return testElement(element, selector);
}
//
// export function getSecureAllElements(selector, container = null) {
//     const elements = container !== null ? container.querySelectorAll(selector) : document.querySelectorAll(selector);
//
//     if(elements.length === 0) throwError(`Impossible de trouver d'élément avec le sélecteur "${selector}" dans le container.`);
//
//     return elements;
// }

export function getSecureElementById(id_tag, container = null) {
    const element = container !== null ? container.getElementById(id_tag) : document.getElementById(id_tag);
    return testElement(element, `#${id_tag}`);
}

export function getSecureClosestElement(selector, element) {
    return testElement(element.closest(selector), selector);
}

function testElement(element, selector) {
    if(element === null) throwError(`Impossible de trouver l'élément avec le sélecteur "${selector}".`);

    return element;
}
