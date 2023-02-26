/* Version 3.0 */
let erreur;
let PATH_DATALIST = '/t-dataliste_';
let PATH_APPERCU = '/images/empty.png';

/* ----------------- */
/*   DOCUMENTATION   */
/* ----------------- */
/*
data-obliger="1" si l'input est obligé
data-type => type de verification a faire
data-message => personnalisation du message d'erreur

<input type="submit" data-verif="NOM DU FORM">
data-verif pour activer la vérification du form

confirmation de mot de passe => les deux inputs doivent avoir le même attr name l'un finissant par _1 et l'autres par _2
uform => under form, gestion des formulaires avec onglet

CLASS
row-flew -> Pour faire une ligne d'input
    -> order: pour répartir de mannière identique les inputs avec cette class
    -> demi: input de 50%
    -> tier: input 33%
*/
//Zone de personnalisation des messages d'erreur
let msgErreur = {
    cp : {
        "defaut" : "Le code postale est invalide.",
        "empty_defaut" : "Code postale requit.",
    },

    date : {
        "defaut": "La date contient des caractères invalide.",
        "empty_defaut": "Date requise.",
        "jour_defaut" : "Le jour est incorrecte.",
        "mois_defaut" : "Le mois est incorrecte.",
        "futur_defaut": "La date doit être dans le futur.",
        "scolaire_defaut": "Date hors saison.",
        "passe_defaut": "La date doit être dans le passé.",
        "coherence_defaut": "Date incorrecte.",
        "birth": "Votre date d'anniversaire contient des caractères invalide.",
        "passe_birth": "Votre date d'anniversaire doit être dans le passé.",
        "coherence_birth": "Votre date d'anniversaire n'est pas cohérente"
    },

    dataList : {
        "empty_defaut": "Champ requit.",
        "empty_piscine": "Lieu de la compétition requis.",
        "unfound_defaut": "Donnée introuvable.",
        "unfound_piscine": "Aucune piscine trouvée.",
        "false_defaut": "Ce champs contient des caractères invalides.",
        "false_piscine": "Nom de piscine invalide."
    },

    file : {
        'empty_defaut' : 'Fichier requit.',
        'size_defaut' : 'Le fichier est trop gros.',
        'type_defaut' : 'Type du fichier invalide.'
    },

    heure : {
        "defaut" : "Heure invalide.",
        "empty_defaut" : "Heure non précisée.",
        "obliger_defaut" : "Heure requise."
    },

    iban : {
        'empty_defaut' : "L'iban doit être rempli.",
        'defaut': "L'iban contient des caractères invalides."
    },

    img : {
        'sizeMax_defaut' : "Les dimensions de l'image sont trop grande.",
        'sizeMin_defaut' : "Les dimensions de l'image sont trop petite.",
        'carre_defaut' : "L'image doit un carré.",
        'cover_defaut' : "L'image ne respecte pas la proportion 8/5."
    },

    licence : {
        "defaut" : "Le numéro de licence contient des caractères invalides."
    },

    mail : {
        "empty_defaut" : "L'adresse mail doit être indiquée.",
        "empty2_defaut" : "La confirmation de l'adresse mail doit être indiquée.",
        "defaut" : "L'adresse mail est invalide.",
        "2_defaut" : "La confirmation de l'adresse mail est invalide."
    },

    mdp : {
        "empty_defaut" : "Mot de passe requit.",
        "empty2_defaut" : "Confirmation requise.",
        "defaut" : "Le mot de passe contient des caractères invalides.",
        "2_defaut" : "La confirmation du mot de passe contient des caractères invalides.",
        "length_defaut" : "Le mot de passe doit comporter minimum 6 caractères.",
        "length2_defaut" : "La confirmation du mot de passe doit comporter minimum 6 caractères."
    },

    nom : {
        'empty_defaut' : "Nom requit.",
        'defaut': "Le nom contient des caractères invalides.",
        'empty_nom' : "Votre nom doit être rempli.",
        'nom': "Votre nom contient des caractères invalides.",
        'empty_prenom' : "Prénom requit.",
        'prenom': "Votre prénom contient des caractères invalides.",
        'empty_banque' : "Le nom de votre banque doit être rempli.",
        'empty_nationalite': "Nationalité requise.",
        'banque': "Le nom de votre banque contient des caractères invalides."
    },

    numb : {
        'defaut': "Le nombre contient des caractères invalides."
    },

    numb_rue : {
        "defaut" : "Le numéro de la rue est invalide.",
    },

    rue : {
        "defaut" : "Le nom de la rue contient des caractères invalides.",
        "empty_defaut" : "Nom de rue requit.",
    },

    select : {
        "defaut" : "Veuillez remplir ce select."
    },

    site : {
        "defaut" : "L'adresse du site est invalides.",
        "empty_defaut" : "Adresse du site requise.",
    },

    tel : {
        "defaut" : "Téléphone invalide."
    },

    texte : {
        "defaut" : "Vous devez introduire un texte.",
        "length_defaut": "Le texte est trop long",
        "chapitre" : "Vous n'avez pas complété votre chapitre.",
        "resume" : "Vous n'avez pas complété votre résumé.",
        "length_resume" : "Votre résumé est trop long"
    },

    titre : {
        'empty_defaut' : "Le titre doit être rempli.",
        'defaut': "Le titre contient des caractères invalides.",
        'empty_pseudo' : "Votre pseudo doit être rempli.",
        'pseudo': "Votre pseudo contient des caractères invalides.",
        'empty_intitule' : "L'intitule de votre mail doit être rempli.",
        'intitule': "L'intitule de votre mail contient des caractères invalides.",
        'empty_roman' : "Le titre du roman doit être rempli.",
        'roman': "Le titre du roman contient des caractères invalides.",
        'empty_chapitre' : "Le titre du chapitre doit être rempli.",
        'chapitre': "Le titre du chapitre contient des caractères invalides."
    },

    ville : {
        "defaut" : "La ville est invalides.",
        "empty_defaut" : "Ville requise.",
    }
};

let fileType = {
    'img':  ["image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png"],
    'photo': ["image/jpg", "image/jpeg"],
    'pdf' : ["application/pdf"]
};

let fileParam = {
    defaut: {
        'size' : '3000000'
    },

    img: {
        'size' : '3000000',
        'heightMax' : '0',
        'heightMin' : '0',
        'widthMax' : '1512',
        'widthMin' : '1024'
    },

    cover: {
        'size' : '3000000',
        'heightMax' : '945',
        'heightMin' : '640',
        'widthMax' : '1512',
        'widthMin' : '1024',
        'forme' : 'cover'
    },

    pdf: {
        'size' : '5000000'
    }
};

let exp = {
    'cp' : /^[0-9]{0,5}$/,
    'iban' : /^[a-zA-Z]{2}[0-9a-zA-Z]{2}\\s?([0-9a-zA-Z]{4}\\s?){2,5}$/,
    'licence' : /^[a-zA-Z0-9/\s]{0,40}$/,
    'nom' : /^[a-zA-ZÀ-ÿ\s'-]{0,80}$/,
    'numb' : /^[0-9]+$/,
    'numb_rue' : /^[0-9]{1,5}[0-9A-Za-z\\s/-]{0,5}$/,
    'rue' : /^[a-zA-ZÀ-ÿ0-9\s'\-."]{0,100}$/,
    'site' : /^(https?:\/\/)?([\da-z.-]+).([a-z]{0,6})+$/,
    'tel' : /^[0-9\-/.]{9,}$/,
    'titre' : /^[a-zA-Z0-9À-ÿ\s'\-_()./:,?!"]{0,80}$/,
    'ville' : /^[a-zA-ZÀ-ÿ._\s-]{0,40}$/
};

let multiInput = ['date', 'heure'];
let paternInput = ['iban', 'site', 'tel'];

$(document).on('input focusout','input[type=text][data-type], textarea[data-type], input[type=password][data-type]', function(e){
    verifInput(this, e.type);
});

$(document).on('change','select[data-type=select], input[data-type=file]',function(e){
    verifInput(this, e.type);
});

function verifInput(champ, event){
    erreur = undefined;

    let $champ = $(champ);
    let type = $champ.attr('data-type');
    let regex = new RegExp(exp[type]);

    let input = {
        champ:champ,
        label: $champ.closest('label'),
        $champ: $champ,
        value: $champ.val().trim(),
        obliger: $champ.attr('data-obliger'),
        message: $champ.attr('data-message')
    };

    // Initialisation a chaque appel de fonction
    if (type !== 'datalist') {initialisation(champ);}
    if (input.obliger !== '1' && input.value === "" && multiInput.indexOf(type) === -1){return false;}

    // Champs particulier
    if (type === 'date'){ verifdate(input, event);return;}
    if (type === 'heure') { verifInputHeure(input, event);return;}
    if (type === 'texte') { veriftexte(input); return;}
    if (type === 'mdp') { verifMdp(input, event); return;}
    if (type === 'mail') { verifMail(input, event); return;}
    if (type === 'select') { verifSelect(input); return;}
    if (type === 'datalist') { verifDatalist(input); return;}
    if (type === 'file') {   verifFile(input); return;}

    if(input.value === "" && input.obliger === "1") { erreur = getMessage(type, input.message, 'empty_'); }

    if (erreur === undefined && !regex.test(input.value)) {
        erreur = (event !== 'focusout' && paternInput.indexOf(type))? "" :getMessage(type, input.message);
    }

    if(erreur !== undefined) {
        Erreur(input.champ, erreur);
        return false;
    }

    valide(input.champ);
}

/* ------------- */
/*     DATES     */
/* ------------- */
function verifdate(input, event){
    let span_date = input.$champ.closest('label');
    let input_name = span_date.attr('data-nom');
    let type = span_date.attr('data-type');
    let obliger = span_date.attr('data-obliger');
    let message = span_date.attr('data-message');

    let jour = span_date.find('input[name = jour_' + input_name + ']').val();
    let mois = span_date.find('input[name = mois_' + input_name + ']').val();
    let annee = span_date.find('input[name = annee_' + input_name + ']').val();

    /* Initialisation */
    span_date.removeClass('input_valide input_erreur');

    //Verification que la value est bien numéric
    if (!$.isNumeric(input.value) && input.value !== "") { erreur = getMessage('date', message);}

    //Vérification de l'input
    if (erreur === undefined && jour !== "" && verifJour(jour)) { erreur = getMessage('date', message, 'jour_');}
    if (erreur === undefined && mois !== "" && verifMois(mois)) { erreur = getMessage('date', message, 'mois_');}

    //verification que l'un des input du champ ne contient pas des carractères invalide
    if (erreur === undefined && ((!$.isNumeric(jour) && jour !== "") || (!$.isNumeric(mois) && mois !== "") || (!$.isNumeric(annee) && annee !== ""))) { erreur =getMessage('date', message); }

    //fin de la fonction si tous les champs ne sont pas rempli
    if (erreur === undefined && jour === "" && mois === "" && annee === "" && obliger === "1" && event === "submit") { erreur = getMessage('date', message, 'empty_'); }
    if (erreur === undefined && jour === "" && mois === "" && annee === "" && obliger !== "1") { return false; }
    if (erreur === undefined && (jour.length !== 2 || mois.length !== 2 || annee.length !== 4)) { return false; }

    if (erreur === undefined && verifDateCoherence(jour,mois,annee) === false) { erreur = getMessage('date', message, 'coherence_'); }

    if(erreur === undefined && type !== undefined){
        if(type === 'futur' && verifDateFutur(jour, mois, annee) === false){ erreur = getMessage('date',message, 'futur_'); }
        else if(type === 'scolaire' && verifDateScolaire(mois, annee) === false){ erreur = getMessage('date',message, 'scolaire_'); }
        else if(type === 'passe' && verifDatePasse(jour, mois, annee) === false){ erreur = getMessage('date',message, 'passe_'); }
    }

    //insertion de l'erreur
    if(erreur !== undefined) {
        Erreur(span_date, erreur);
        return false;
    }

    valide(span_date);
}

function verifJour(jour){
    return ((jour > 31 || jour < 1) && jour.length === 2);
}

function verifMois(mois){
    return ((mois > 12 || mois < 1) && mois.length === 2);
}

function verifDateCoherence(jour,mois,annee){
    /* Définition du nombre de jours max dans le moi */
    let max_day;

    switch (mois) {
        case '02':
            if (annee % 4 === 0) {
                max_day = (annee % 1000) ? 29 : 30;
            }
            else
                max_day = 28;
            break;

        case '01':
        case '03':
        case '05':
        case '07':
        case '08':
        case '10':
        case '12':
            max_day = 31;
            break;

        case '04':
        case '06':
        case '09':
        case '11':
            max_day = 30;
            break;
    }

    /* Cohérence du jour par rapport au mois */
    if ( jour > max_day || jour === "") {
        return false;
    }
}

function verifDateFutur(jour, mois, annee){
    let d = new Date();

    if(annee.val() < d.getFullYear()){
        annee.removeClass("input_valide").addClass("input_erreur");
        return false
    }

    else if(mois.val() < d.getMonth()+1 && annee.val() === d.getFullYear()){
        mois.removeClass("input_valide").addClass("input_erreur");
        return false
    }

    else if(jour.val() < d.getDate() && mois.val() === d.getMonth() +1 && annee.val() === d.getFullYear()){
        return false
    }
}

function verifDateScolaire(mois, annee){
    let annee_valide = anneeValide();

    if (annee_valide[0] !== parseInt(annee) && annee_valide[1] !== parseInt(annee)){ return false; }
    /* Vérification que le mois se situe entre  09/ 1er année et 08/ 2nd année */
    else if((parseInt(mois) < 9 && parseInt(annee) === annee_valide[0]) || (parseInt(mois) > 8 && parseInt(annee) === annee_valide[1])){ return false; }

    return true;
}

function verifDatePasse(jour, mois, annee){
    let d = new Date();

    if(parseInt(annee) > d.getFullYear()){ return false; }
    else if(parseInt(mois) > d.getMonth()+1 && parseInt(annee) === d.getFullYear()){ return false; }
    else if(parseInt(jour) > d.getDate()+1 && parseInt(mois) === d.getMonth() +1 && parseInt(annee) === d.getFullYear()){ return false; }

    return true;
}

/* ---------------- */
/*      L'HEURE     */
/* ---------------- */
function verifInputHeure(input, event){
    let name = input.$champ.attr('name');
    let span_heure = input.$champ.closest('label');
    let input_name = span_heure.attr('data-nom');
    let obliger = span_heure.attr('data-obliger');

    //Récupération des valeurs jour/mois/annee
    let heure = $('input[name = heure_' + input_name + ']').val();
    let minute = $('input[name = minute_' + input_name + ']').val();

    /* Initialisation */
    span_heure.removeClass('input_erreur input_valide');

    //Verification que la value est bien numéric
    if (!$.isNumeric(input.value) && input.value !== "") { erreur = getMessage('date', input.message);}

    if((heure.length === 0 || minute.length === 0) && event === 'submit'){erreur = getMessage('heure', input.message, 'empty_');}
    if(obliger === "1" && heure.length === 0 && minute.length === 0  && event === 'submit') {erreur = getMessage('heure', input.message,'obliger_');}

    //fin de la fonction si tous les champs ne sont pas rempli
    if (erreur === undefined && input.value.length !== 2) { return false; }

    if (name.indexOf('heure') !== -1 && verifHeure(input.value) === false) {erreur = getMessage('heure', input.message); }
    if (name.indexOf('minute') !== -1 && verifMinute(input.value) === false) {erreur = getMessage('heure', 'input.message'); }

    //insertion de l'erreur
    if(erreur !== undefined) {
        Erreur(span_heure, erreur);
        return false;
    }

    valide(span_heure);
}

function verifHeure(heure){
    if (isNaN(heure) === true || heure < 0 || heure > 23) { return false; }
}

function verifMinute(minute) {
    if (isNaN(minute) === true || minute < 0 || minute > 59) { return false; }
}

/* -------------- */
/*      TEXTE     */
/* -------------- */
function veriftexte(input){
    let name = input.$champ.attr('name');
    let cke = $('#cke_' + name);
    let div_erreur = cke.length !== 0 ? cke: input.champ;
    let max = $('span[class=compteur-'+name+'-max]').html();

    cke.find('.message-cke').remove();

    if(input.value.length === 0 && input.obliger === '1'){ erreur = getMessage('texte', input.message); }
    if(erreur === undefined && max !== undefined && input.value.length > max){ erreur = getMessage('texte', input.message, 'length_'); }

    if( erreur !== undefined) {
        Erreur(div_erreur, erreur);
        input.$champ.addClass('input_erreur');
        return false;
    }

    valide(div_erreur);
    input.$champ.addClass('input_valide');
}

/* -------------- */
/*  MOT DE PASSE  */
/* -------------- */
function verifMdp(input, event){
    let nom = input.$champ.attr('name').substring(0, input.$champ.attr('name').length - 2);
    let input_2 = $('input[name = '+ nom +'_2]');
    let isConfirmation = (input_2.attr('name') === input.$champ.attr('name'));
    let regex = new RegExp(/^([0-9A-Za-z$@%*+\\-_!?,.;:=]+){0,25}$/);

    if(input.value.length === 0 && input.obliger === "1") {
        erreur = isConfirmation ? getMessage('mdp', input.message, "empty2_"): getMessage('mdp', input.message, "empty_");
    }

    if (erreur === undefined && !regex.test(input.value)  && input.value.length !== 0) {
        erreur = isConfirmation ? getMessage('mdp', input.message, "2_"): getMessage('mdp', input.message);
    }

    if (erreur === undefined && input.value.length < 6 && input.obliger === "1") {
        erreur = (event === 'focusout' && isConfirmation)? getMessage('mdp', input.message, "length2_") : "";
        erreur = (event === 'focusout' && !isConfirmation)? getMessage('mdp', input.message, "length_"): "";
    }

    if(erreur === undefined && $('input[type=password][name=' + nom +'_2]').length !== 0 && input_2.val().length !== 0){
        verif2Mdp(nom, event);

        if(isConfirmation) {return false;}
    }

    if( erreur !== undefined) {
        Erreur(input.champ, erreur);
        return false;
    }

    valide(input.champ);
}

function verif2Mdp(nom, event){
    let input_2 = $('input[name = '+ nom +'_2]');
    let mdp1 = $('input[name = '+ nom +'_1]').val();
    let mdp2 = input_2.val();

    /*Initialisation */
    input_2.removeClass('input_erreur input_valide');

    /* Vérrification */
    if(mdp1 !== mdp2){
        erreur = (event === "focusout" || event === "submit")?'Les mots de passe sont différents.':'';
        Erreur(input_2, erreur);
        return false
    }

    valide(input_2);
}

/* ------------ */
/* ADRESSE MAIL */
/* ------------ */
function verifMail(input, event) {
    let nom = input.$champ.attr('data-nom');
    let input_2 = $('input[name = '+ nom +'_2]');
    let isConfirmation = (input_2.attr('name') === input.$champ.attr('name'));
    let regex = new RegExp(/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/);

    if(input.value.length === 0 && input.obliger === "1") {
        erreur = isConfirmation ? getMessage( 'mail', input.message,"empty2_"): getMessage('mail', input.message, "empty_");
    }

    if (erreur === undefined && !regex.test(input.value) && input.value.length !== 0) {
        erreur = (event === 'focusout' && isConfirmation)?  getMessage('mail', input.message, "2_"): "";
        erreur = (event === 'focusout' && !isConfirmation)? getMessage('mail', input.message): "";
    }

    if(erreur === undefined && $('input[data-type=mail][data-nom =' + nom +']').length === 2&& input_2.val().length !== 0) {
        verif2mail(nom, event);

        if(isConfirmation) {return false;}
    }

    if( erreur !== undefined) {
        Erreur(input.champ, erreur);
        return false;
    }

    valide(input.champ);
}

function verif2mail(nom, event){
    let input_2 = $('input[name= '+ nom + '_2]');
    let mail_1 = $('input[name=' + nom + '_1]').val();
    let mail_2 = input_2.val();

    /*Initialisation*/
    input_2.removeClass('input_erreur input_valide');

    if(mail_1 !== mail_2){
        erreur = (event === "focusout" || event === "submit")?'Les adresses mails sont différentes.':'';
        Erreur(input_2, erreur);
        return false
    }

    valide(input_2);
}

/* ------------- */
/*   DATALIST    */
/* ------------- */
//Animation Datalist
$(document).on('input','input[id*=liste-]',function ()  {
    let $input = $(this);
    let name = $input.attr('name');
    let page = $input.data('page');
    let message = $input.data('message');
    let $list = $('#' + name);
    let search = $('#liste-' + name).val();

    initialisation($input);

    if(search === "") {
        $list.html('');
        $('input[name=id_' + name + ']').val('').trigger('changeDatalist');
        return;
    }

    if(foundDatalistOption(name, search) === false && search !== "") {
        $.post(PATH_DATALIST + page, {search:search, name: name}, function(data){
            if(data.message !== ""){
                Erreur($input, getMessage('dataList', message, data.message));
                return;
            }

            $('#liste-' + name).removeAttr('autocomplete');
            if(data.datalist !== '') {
                $('#' + name).html(data.datalist);
            } else {
                $('#empty').html(data.empty);
            }

            getDatalistOption(name, search);
        }, 'json');

        return;
    }

    getDatalistOption(name, search);
});

function getDatalistOption (name, search) {
    let idOption = false;
    let $datalist = $('#' + name);
    let $inputHiden = $('input[name=id_' + name + ']');

    $datalist.find('option').each( function(){
        let valOption = $(this).val();
        if(valOption.toLowerCase() === search.toLowerCase()) {
            idOption = $(this).data('id_' + name);
        }
    });

    if(idOption !== false) {
        $inputHiden.val(idOption).trigger('changeDatalist');
        return idOption;
    }

    $inputHiden.val('');
    return idOption;
}

function foundDatalistOption (name, value) {
    let found = false;
    let $datalist = $('#' + name);

    $datalist.find('option').each( function(){
        let valOption = $(this).val();

        if(valOption.toLowerCase().indexOf(value.toLowerCase()) !== -1) {
            found = true;
        }
    });

    return found;
}

//Vérification de l'input datalist si rechargement des données
function verifDatalist(input){
    if(input.value === "" && input.obliger === "1"){
        Erreur(input.champ, getMessage('dataList', input.message, "empty_"));
        return;
    }

    if (input.value === "" && !foundDatalistOption (input.$champ, input.value)) {
        Erreur(input.champ, getMessage('dataList', input.message, "unfound_"));
        return;
    }

    if (input.value !== "") {
        valide(input.champ);
    }
}

$(document).on('click', 'button[data-action=datalist_reset]', function(e){
    e.preventDefault();
    let input = $(this).closest('label');

    input.find('input[type=hidden]').val('');
    input.find('datalist').html('');
    input.find('input[type=text]').removeClass('input_valide input_erreur').val('').trigger('resetDatalist');
});

/* ------------- */
/*   CHECKBOX    */
/* ------------- */
$('input[type=checkbox][data-type]').on('change',function(){
    $(this).removeClass("input_valide input_erreur");

    if( $(this).is(':checked')){
        $(this).addClass("input_valide");
    } else if( $(this).attr('data-obliger')) {
        $(this).addClass('input_erreur');
    }
});

/* ------------- */
/*    SELECT     */
/* ------------- */
function verifSelect(input) {
    if (input.value === "-1" && input.obliger === '1') {
        Erreur(input.champ, getMessage('select', input.message));
        return false
    }

    input.$champ.addClass("input_valide");
}

/* ---------- */
/* INPUT FILE */
/* ---------- */
$(document).on('click','button[data-file]:not([disabled]), .label-file', function(e){
    if(!$(e.target).is('input[type=file]')) {e.preventDefault();}
    if(!$(e.target).is('button') && !$(e.target).is('input[type=file]')){ return;}

    let name = $(this).attr("data-file");
    $(this).closest('div').find('input[type=file][name= ' + name + ']').trigger('click');
});

function verifFile(input){
    let file = input.champ.files[0];
    let $fileName = input.label.find('[data-fileName]');
    let type = input.$champ.data('accept');
    let option = input.$champ.data('option');
    let extention = (option !== undefined)? option: type;
    let param = getDefautFileParam(option);

    //initialisation
    $fileName.html('Aucun fichier');
    input.label.find('[data-appercu]').attr('src', PATH_APPERCU);

    if (file === undefined && input.obliger === "1") {
        erreur = getMessage('file', input.message, 'empty_');
    }

    if (erreur === undefined && file.size > param.size) {
        erreur = getMessage('file', input.message, 'size_');
    }

    if (erreur === undefined && fileType[extention].indexOf(file.type) === -1) {
        erreur = getMessage('file', input.message, 'type_');
    }

    if (erreur === undefined && type === "img") {
        verifImg(input, file, param);
        return;
    }

    if(erreur !== undefined) {
        Erreur(input.champ, erreur);
        return false;
    }

    valide(input.champ);
    $fileName.html(file.name);
}

function verifImg(input, file, param){
    let reader = new FileReader();
    let img = new Image;

    reader.onload = function (e) {
        img.src = e.target.result;
        img.onload = function() {
            let img_width = this.width;
            let img_height = this.height;

            if (erreur === undefined && (img_width > param.widthMax || img_height > param.heightMax)) {
                erreur = getMessage('img', input.message, "sizeMax_");
            }

            if (erreur === undefined && (img_width < param.widthMin || img_height < param.heightMin)) {
                erreur = getMessage('img', input.message, "sizeMin_");
            }

            if (erreur === undefined && param.forme === 'carre' && (img_width !== img_height)) {
                erreur = getMessage('img', input.message, "carre_");
            }

            if (erreur === undefined && param.forme === 'cover' && (img_width !== (img_height * 8) / 5)) {
                erreur = getMessage('img', input.message, "cover_");
            }

            if(erreur !== undefined) {
                Erreur(input.champ, erreur);
                return false;
            }

            input.label.find('[data-appercu]').attr('src', e.target.result);
            input.label.find('[data-fileName]').html(file.name);
            valide(input.champ);
        }
    };

    reader.readAsDataURL(file);
}

function getDefautFileParam (option) {
    if(option === undefined || fileParam[option] === undefined) {return fileParam.defaut;}
    return fileParam[option];
}
/* ------------ */
/*  VERIF FORM  */
/* ------------ */
$(document).on('click', 'button[data-verif], input[type=submit][data-verif], a[data-verif]', function (e){
    e.preventDefault();
    let name = $(this).data('verif');
    let form = $('form[name=' + name + ']');

    //suppression des erreurs input vide non obligatoire
    form.find(':input').filter(function () {
        return $(this).val() === '' && $(this).hasClass('input_erreur')
    }).each(function(){
        $(this).removeClass('input_erreur');
    });

    //verrification des adresses
    form.find('input[data-type=rue]').each(function() {
        let name = ($(this).attr('name').split('_'))[1];
        let inputs = form.find(':input[name=rue_' + name + '], :input[name=cp_' + name + '], :input[name=ville_' + name + ']');
        let inputs_valide = inputs.filter(function() { return $(this).hasClass('input_valide')});

        if((inputs_valide.length !== 3 && inputs_valide.length !== 0) || (inputs_valide.length !== 3 && form.find(':input[name=numbRue_' + name + ']').val() !== '')) {
            inputs.filter(function () {
                return $(this).val() === ''
            }).each(function(){
                let message = $(this).data('message');
                let type = $(this).data('type');

                Erreur(this, getMessage(type, message, 'empty_'));
            });
        }
    });

    form.find('div[class*=cke_editor_]').each(function() {
        let name = $(this).attr('id').split('_')[1];
        CKEDITOR.instances[name].updateElement();
    });

    //faire le test des inputs non verifier
    form.find(':input:not([type=hidden], [type=submit])').filter(function () {
        return !$(this).hasClass('input_valide') && !$(this).hasClass('input_erreur')
    }).each(function(){
        verifInput(this, 'submit');
    });

    form.find("[data-btn_uform][class*=btn-neg-erreur]").each(function(){
        //$(this).attr('title',"Cette section comporte une erreur.");
    });

    if(form.find(':input[class*=_erreur], [class*=border-][class*=_erreur]').length === 0) {
        form.trigger('submit');
        return;
    }

    form.trigger('erreur');
});

/* initialisation */
function initialisation(champ){
    let label = $(champ).closest('label');
    $(champ).removeClass('input_valide input_erreur');

    label.find('.label-input').show();
    label.find('.input_message').remove();
}

/* insertion de l'erreur */
function Erreur(champ, message){
    let uform = $(champ).closest("[data-uform]");
    let label = $(champ).closest('label');
    label.find("[data-erreur]").remove();

    $(champ).addClass('input_erreur');
    label.find('label').show();

    if(message !== undefined && message !== ""){
        label.find('.label-input').after('<span class="input_message" data-erreur="input">' + message + '</span>');
        label.find('.label-input').hide();
    }

    if (uform.length !== 0) {
        var d_uform = uform.attr('data-uform');
        var inputs = uform.find('input, textarea, select').filter(function() {

            return ($(this).val() === '' && $(this).attr("data-obliger") === 1) || $(this).hasClass('input_erreur');
        });

        if(inputs.length !== 0) {
            var btn = form.find('[data-btn_uform=' + d_uform + ']');

            btn.addClass('btn-erreur').removeClass('btn-native btn-valide');
            if(btn.is('[class*=-neg-]')) {btn.removeClass('btn-neg-native btn-neg-valide').addClass('btn-neg-erreur');}
        }
    }
}

function valide (champ) {
    let form = $(champ).closest('form');
    let uform = $(champ).closest("[data-uform]");
    $(champ).addClass('input_valide');

    if (uform.length !== 0) {
        var d_uform = uform.attr('data-uform');
        var inputs = uform.find('input, textarea').filter(function() {
            return ($(this).val() === '' && $(this).attr("data-obliger") === 1) || $(this).hasClass('input_erreur');
        });

        if(inputs.length === 0) {
            form.find('[data-btn_uform=' + d_uform + ']')
                .addClass('btn-valide')
                .removeClass('btn-native btn-erreur')
                .tooltip('destroy')
                .removeAttr('data-original-title')
            ;
        }
    }
}

/* Determination des Années valide pour les event*/
function anneeValide(){
    let anneeValide = $('form').attr('data-saison');

    if(anneeValide !== undefined){
        return anneeValide.split('-');
    }

    let d = new Date();
    let annee = d.getFullYear();
    let mois = d.getMonth()+1;

    if(mois >= 9){
        return [annee, annee+1];
    }
    else{
        return [annee-1, annee];
    }
}

/* ------------------- */
/* INPUT DATE ET HEURE */
/* ------------------- */
//Simulation du focus
$(document).on('focus','input[class*=date]',function(){
    let border = $(this).closest('span');
    border.addClass('input-focus');
});

$(document).on('focusout','input[class*=date]',function(){
    let border = $(this).closest('span');
    border.removeClass('input-focus');
});

/* --------------- */
/* FONCTIONS KEYUP */
/* --------------- */
$(document).on('keyup','input[data-type=date], input[data-type=heure]',function(e){
    let input = $(this).closest('span[class*=border-]');
    let value = $(this).val();
    let name = $(this).attr('name');

    // Obliger les nombres
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        return;
    }

    //switch auto
    if($(this).hasClass('date-jm') && value.length >= 2){
        if(name.indexOf('jour') !== -1){
            $(input).find('input[name*=mois]').focus();
        } else {
            $(input).find('input[name*=annee]').focus();
        }
    } else if(name.indexOf('heure') !== -1 && value.length === 2) {
        $(input).find('input[name*=minute]').focus();
    }
});

/* --------------- */
/* FONCTIONS DOWN  */
/* --------------- */
$(document).on('keydown','input[data-type=date], input[data-type=heure]',function(e){
    let input = $(this).closest('label');
    let value = $(this).val();
    let name = $(this).attr('name');

    //revenir a l'input précédent en cas de leftMove
    if(e.keyCode === 8 && value.length === 0) {
        if(name.indexOf('annee') !== -1) {
            leftMove(input, 'mois');
        } else if(name.indexOf('mois') !== -1) {
            leftMove(input, 'jour');
        } else if(name.indexOf('minute') !== -1) {
            leftMove(input, 'heure');
        }
        e.preventDefault();
    }

    //Changer d'input avec les fleche
    if(value.slice(0, this.selectionStart).length === 2 && e.keyCode === 39){
        if(name.indexOf('jour') !== -1) {
            rightMove(input, 'mois');
        } else if(name.indexOf('mois') !== -1) {
            rightMove(input, 'annee');
        } else if(name.indexOf('heure') !== -1) {
            rightMove(input, 'minute');
        }
        e.preventDefault();

    }

    if(value.slice(0, this.selectionStart).length === 0 && e.keyCode === 37){
        if(name.indexOf('annee') !== -1) {
            leftMove(input, 'mois');
        } else if(name.indexOf('mois') !== -1) {
            leftMove(input, 'jour');
        } else if(name.indexOf('minute') !== -1) {
            leftMove(input, 'heure');
        }
        e.preventDefault();
    }

    //auto completion
    if(e.keyCode === 9 && value.length === 1){
        $(this).val('0' + value);
    }

    // Allow: leftMove, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode === 65 && e.ctrlKey === true) ||
        // Allow: Ctrl+C
        (e.keyCode === 67 && e.ctrlKey === true) ||
        // Allow: Ctrl+X
        (e.keyCode === 88 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
        return;
    }

    // Ensure that it is a number and stop the keypress
    if ((!e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});

$(document).on('keyup','input[data-type=date], input[data-type=heure]',function(e){
    let input = $(this).closest('label');
    let value = $(this).val();
    let name = $(this).attr('name');

    if(input.hasClass('input_erreur')){return;}

    if(value.length === 2 && ((e.keyCode > 48 && e.keyCode < 57) || (e.keyCode > 96 && e.keyCode < 105))){
        if(name.indexOf('jour') !== -1) {
            rightMove(input, 'mois');
        } else if(name.indexOf('mois') !== -1) {
            rightMove(input, 'annee');
        } else if(name.indexOf('heure') !== -1) {
            rightMove(input, 'minute');
        }
    }
});

function leftMove(gen_input,name) {
    let prec_input = $(gen_input).find('input[name*=' + name +']');
    let value = prec_input.val();

    prec_input.focus().val(value);
}

function rightMove(gen_input,name) {
    let prec_input = $(gen_input).find('input[name*=' + name +']');
    prec_input.focus();
}

/* TOOLS */
function getMessage(type, message, prefix) {
    if(message === undefined) {message = "defaut"}
    if(prefix === undefined) {prefix = ""}

    if(msgErreur[type][prefix + message] !== undefined) {
        return msgErreur[type][prefix + message]
    }

    return msgErreur[type][prefix + "defaut"];
}