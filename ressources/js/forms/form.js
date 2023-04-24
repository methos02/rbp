import {throwError} from "../utils/error";
import {insertError} from "../utils/form";
import {validateLoginForm} from "./login_form";
import {validateNewsForm} from "./news_form";

export function validateForm(rules, formDatas) {
    let value;
    const errors = {};

    Object.entries(rules).forEach(([input]) => {
        if(rules[input].type === 'checkbox') {
            if(formDatas.get(input) === null)  errors[input] = rules[input].error;
            return;
        }

        if(formDatas.get(input) === null) throwError(`L'input ${ input } est introuvable dans le formulaire.`);
        const rule = rules[input].type !== undefined ? defaultRules(rules[input].type) : rules[input];

        value = rule.format !== undefined ? rule.format(formDatas.get(input)) : formDatas.get(input);
        let error = '';
        let i = 0;

        if(Array.isArray(rule.tests)) {
            while ( i < rule.tests.length && error === '') {
                error = rule.tests[i](value);
                i++;
            }
        }

        if(!Array.isArray(rule.tests)) {
            Object.keys(rule.tests).forEach( test_name => {
                const test = defaultTests(test_name);

                error = test(value) ?  rule.tests[test_name] : '';
                if(error !== '') return false;
            });
        }

        if(error !== "") errors[input] = error;
    })

    return errors;
}

function defaultRules(rule_name) {
    const rules = {
        email : {
            tests : [
                value => value === "" ? "Email requit." : '',
                value => !value.match(/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/) ? "L'adresse email semble invalide" : ""
            ]
        },
        telephone : {
            tests : [
                value => value === "" ? "Veuillez indiquer le numéro de téléphone." : '',
                value => !value.match(/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/) ? "Le numéro de téléphone ne semble pas français." : ""
            ]
        },
        password : {
            tests : [
                value => value === "" ? "Veuillez indiquer un mot de passe." : '',
            ]
        },
        confirm_password : {
            tests : [
                value => value === "" ? "Veuillez confirmer votre mot de passe." : '',
            ]
        },
        date_picker: {
            tests : [
                value => value === "" ? "Veuillez sélectionné une période." : '',
            ]
        }
    };

    if(rules[rule_name] === undefined) throwError(`Les règles de validation par défaut n'existe pas pour l'input "${rule_name}"`)
    return rules[rule_name];
}

function defaultTests(test_name) {
    const tests = {
        required : value => value === "",
        int: value => Number.isInteger(value)
    }

    return tests[test_name];
}

// export function validateTabForm(tab) {
//     if(form_validator[tab.dataset.validate] === undefined) throwError(`Aucune validation de formulaire n'a été enregistré pour l'onglet "#${tab.dataset.validate}"`);
//     return form_validator[tab.dataset.validate](tab.closest('form'));
// }

export function validateSubmitForm(form, e) {
    if(form_validator[form.dataset.validate] === undefined) throwError(`Aucune validation de formulaire n'a été enregistré pour le formulaire "#${form.dataset.validate}"`);
    const result = form_validator[form.dataset.validate](form);
    if(Object.keys(result.errors).length === 0) return;

    insertError(form, result.errors);
    e.preventDefault();

}

const form_validator = {
    login_form : validateLoginForm,
    news_form : validateNewsForm,
};
