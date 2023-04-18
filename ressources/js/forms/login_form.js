import {removeErrors} from "../utils/form";
import {validateForm} from "./form";

export function validateLoginForm(login_form) {
    removeErrors(login_form);

    const rules = {
        "email" : { type: 'email' },
        "password" : { tests : { required : 'Mot de passe requit.'}}
    };

    const formDatas = new FormData(login_form);

    return { 'errors' : validateForm(rules, formDatas), 'formDatas' : formDatas};
}
