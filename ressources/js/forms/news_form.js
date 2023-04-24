import {removeErrors} from "../utils/form";
import {validateForm} from "./form";

export function validateNewsForm(login_form) {
    removeErrors(login_form);

    const rules = {
        "section_id" : { tests : [
                (value) => value === "" ? 'La section est requise.' : "",
                value => Number.isInteger(value) || value <= 0 ? "La section est invalide." : ""
            ]
        },
        "title" : {tests : { required : 'Le titre est requit.'}},
        "content" : {tests : { required : 'Le contenu est requit.'}}
    };

    const formDatas = new FormData(login_form);

    return { 'errors' : validateForm(rules, formDatas), 'formDatas' : formDatas};
}
