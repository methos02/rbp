/* ------------ */
/*   PISCINES   */
/* ------------ */
//Afficher form modif
$(document).on('click', '[data-add=piscine],[data-manage=piscine]', function(e) {
    e.preventDefault();
    let id_piscine = $(this).attr('data-manage') === "piscine" ? $(this).closest('span').data('id_piscine') : undefined;

    $.post("/f-piscine",{id_piscine:id_piscine},function(data) {
        if(data.indexOf('danger') !== -1) {
            $('.message').html(data);
            $('#message-flash').fadeIn();
            return;
        }

        $('[data-include=piscine_form]').html(data);
        $('.modal-title').html( id_piscine !== undefined ? "Modifier l'abum" : 'Ajouter une piscine');
        $('#Modal').modal("show");
    });
});

//Ajout/modification des piscines
$('form[name=form-piscine]').on('submit', function(e){
    e.preventDefault();
    let formData = new FormData (this);
    let url = ($(this).find('input[name=id_piscine]').length !== 0)? 'update': 'add';

    $.ajax({
        url:'/t-piscine_' + url,
        type:'post',
        contentType: false,
        processData: false,
        dataType: 'json',
        data: formData,
        success: function(data){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();

            if(data.success === 1) {
                window.location = '/piscines';
            }
        }
    }, 'json');
});

//récupération des infos d'une piscine
$('select[name=id_piscine]').on('change',function(){
    let id_piscine = $(this).val();
    let form = $('form[data-manager=piscine]');

    if(id_piscine === '-1') {
        $('input[name=id_piscine]').remove();
        $('#btn-supp').hide();
        $('#btn-cancel').hide();
        form.find(':input').val('').removeClass('input_valide input_erreur');
        return;
    }

    $.post('/f-piscine', {id_piscine:id_piscine}, function(data){
        $('form[data-manager=piscine]').html(data);
        $('#btn-cancel').show();
        $('#btn-supp').show();
    });
});

//suppression de la piscine
$('#table-piscine').on('click', '[data-supp=piscine]',function(e){
    e.preventDefault();
    let tr = $(this).closest('tr');
    let id_piscine = getIdSupp(this, 'piscine');

    $.post('/t-piscine_supp', {id_piscine:id_piscine}, function(data){
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1) {
            tr.remove();
            $('#Modal').modal("hidde");
            $('[data-include=piscine_form]').html('');
        }
    }, 'json');
});

//Annulation de modification
$('#btn-cancel').on('click', function(e){
    e.preventDefault();
    $('input[name=id_piscine]').remove();
    $('#btn-supp').hide();
    $('#btn-cancel').hide();
    $('form[data-manager=piscine]').find(':input').val('').removeClass('input_valide input_erreur');
    $('select[name=id_piscine]').val('-1');
});

/* ----------- */
/*   ARTICLES  */
/* ----------- */
/* Modification des div custom*/
$(document).on('click', 'a[data-modif=article]', function(e){
    e.preventDefault();
    let div_article = $(this).siblings('[data-article]');
    let article = div_article.find('[data-id_article]');
    let attr = div_article.data('article');
    let id_article = article.data('id_article');

    $.post("/f-article", {id_article:id_article}, function(data) {
        if(data.indexOf('danger') !== -1) {
            $('.message').html(data);
            $('#message-flash').fadeIn();
            return;
        }

        $('a[data-modif=article]').fadeOut();
        div_article.find('.btn-close').hide();
        div_article.find('.suite-article').hide();
        article.html(data);

        CKEDITOR.replace('modif_article_' + id_article, {});

        if(div_article.hasClass('pos-center')) {
            resize_article(article);
        } else {
            article_affiche(attr);
        }
    });
});

/* submit Modification des div custom*/
$(document).on('click', 'button[name=valide-modif]', function(e){
    e.preventDefault();
    let id_article = $(this).parent('form').data('id_article');
    let div_article = $(this).closest('[data-article]');
    let article = CKEDITOR.instances.modif.getData();

    $.post("/t-article_update", {id_article:id_article, article:article}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1){
            replaceArticle(div_article, article);
        }
    }, 'json');
});

/* Annuler submit custom div*/
$(document).on('click', 'button[name=cancel-modif]', function(e){
    e.preventDefault();
    let div_article = $(this).closest('[data-article]');
    let id_article = div_article.find('[data-id_article]').data('id_article');

    $.post("/t-article_affiche", {id_article:id_article}, function(data) {
        if(data['message'] !== ''){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return
        }

        replaceArticle(div_article, data.article);

    }, 'json');
});

function replaceArticle (div_article, text) {
    let article = div_article.find('[data-id_article]');

    article.html(text);
    div_article.find('.suite-article').show();
    div_article.find('.btn-close').show();
    $('a[data-modif=article]').fadeIn();

    resize_article(article);
}

/* ----------- */
/* COMPETITION */
/* ----------- */
//fonction switch
$(document).on('click','[data-change]', function(e){
    e.preventDefault();

    let data = $(this).attr('data-change');
    $(this).closest('span').parent().find('[data-groupe=' + data + ']').toggle();
});

/* ------------------- */
/* NATATION - PLONGEON */
/* ------------------- */
$tableCompetition = $('#table_competition');

//Affichage/fermeture du form compétition
$(document).on('click','[data-close=competition_form]', function(e){
    e.preventDefault();
    switch_form_competition();
});

function switch_form_competition(){
    $('#form-competition').fadeOut(150, function(){
        $('[data-affiche=competition]').fadeIn(150, function(){
            resize_article($('div[data-article=competition]'), true);
        });
    });
}

$(document).on('click','[data-open=competition_form]', function(e){
    e.preventDefault();
    $('#form-competition').fadeIn(150, function(){
        $('[data-affiche=competition]').fadeOut(150, function(){
            resize_article($('div[data-article=competition]'), true);
        });
    });
});

// Récupération des données d'un compétition
$(document).on('click', '[data-manage=competition]', function(e){
    e.preventDefault();
    let id_competition = $(this).closest('span').data('id_competition');
    let id_section = $('body').attr('data-id_section');
    let div_article = $('div[data-article=competition]');

    $.post("/f-competition",{id_competition:id_competition, id_section:id_section}, function(data) {
        if($(data).hasClass('alert-danger')) {
            $('.message').html(data);
            $('#message-flash').slideDown(300);
            return;
        }

        let div_form = $('#form-competition');

        $('[data-affiche=competition]').fadeOut(150, function() {
            div_form.html(data).fadeIn(150, function(){
                resize_article(div_article, true);
            });
        });

        if(!div_article.hasClass('pos-center')) {article_affiche('competition');}
        $('html, body').animate( { scrollTop: div_article.offset().top - 127  }, 750 );
    })
});

/* Confirmation supp competiton */
$tableCompetition.on('click','[data-supp=competition]', function(e){
    e.preventDefault();
    let line = $(this).closest('tr');
    let id_competition = getIdSupp(this, 'competition');

    $.post("/t-competition_supp", {id_competition:id_competition}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1){
            line.remove();
        }
    },'json');
});

//Empécher les submit avec entrée
$('form[name=form-competition]').on('keydown', function(e){
    if(e.keyCode === 13) {
        e.preventDefault();
    }
});

//submit form ajout competiton
$(document).on('submit', 'form[name=form-competition]',function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let url = ($(this).find('input[name=id_competition]').length !== 0)? 'update': 'add';

    $.ajax({
        url:'/t-competition_' + url,
        type:'post',
        contentType: false,
        processData: false,
        dataType: 'json',
        data: formData,
        success: function(data){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();

            if(data.success === 1) {
                if(data.option !== undefined){ $('#id_saison').html(data.option)}
                if(data.competitions !== undefined){ $('#table_competition').html(data.competitions);}

                switch_form_competition();
            }
        }
    }, 'json');
});

//Upload fichier compétition
$(document).on('change','input[data-upload=file]', function(){
    let td = $(this).closest('td');
    let id_competition = $(this).closest('tr').attr('data-id_competition');
    let nom = $(this).attr('name');
    let data = new FormData();

    // Ajout du fichier dans le data
    data.append(nom, $(this)[0].files[0]);
    data.append('id_competition', id_competition);
    data.append('nom', nom);

    $.ajax({
        url: '/t-competition_fichier_upload',
        type: 'post',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        dataType: 'json', // selon le retour attendu
        data: data,
        success: function (data) {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            if(data.link !== undefined) {
                td.html(data.link);
            }
        }
    }, 'json');
});

//Affichage / fermeture form ajout piscine
$(document).on('change','#piscine_add', function(e){
    e.preventDefault();
    let $parts = $('[data-partie=piscine], [data-partie=piscine_add]');

    //changement d'obligation
    $('[data-partie=piscine_add]').find(':input:not([type=hidden],[type=submit], [data-type=numb_rue])').attr('data-obliger', ($(this).is(':checked'))? '1' : null);

    //initialisation
    $parts.find('.input_message').remove();
    $parts.find('.label-input').show();
    $parts.find(':input:not([type=hidden],[type=submit])')
        .val('')
        .removeClass('input_erreur input_valide')
    ;

    $('[data-partie]').toggle();
    resize_article($('div[data-article=competition]'), true);
});

/* ------------------ */
/*  MEMBRE D'HONNEUR  */
/* ------------------ */
//new/update membre d'honneur
$(document).on('submit', '[name=form-membreh]',function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let url = ($(this).find('input[name=id_membreh]').length !== 0)? 'update': 'add';

    $.ajax({
        url: '/t-membreh_' + url,
        type: 'post',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        dataType: 'json', // selon le retour attendu
        data: formData,
        success: function (data) {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();

            if(data.id_membreh !== undefined) {
                window.location = '/membreh_manage/id_membreh-' + data.id_membreh;
            }
        }
    }, 'json')
});

// Confirmation supp adherent
$('#membre_h').on('click','[data-supp=membre_h]', function(e){
    e.preventDefault();
    let id_membre = getIdSupp(this, 'membre_h');

    $.post("/t-membreh_supp",{id_membre:id_membre},function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();


        if(data.fiche !== undefined) {
            $('.affiche_membre_h').replaceWith(data.fiche);
            $('select[name=membre_h]').val(data.id_membreh)
        }

    }, 'json');
});

/* ---------- */
/*    ALBUM   */
/* ---------- */
//form pour créer un nouvel album
$(document).on('click', '[data-manage=album]',function(e){
    e.preventDefault();
    let id_album = $(this).closest('span').data('id_album');

    $.post('/t-album_getForm', {id_album:id_album}, function(data){
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('.modal-content').html(data.form);
        $('#Modal').modal("show");
    }, 'json');
});

//new/update album
$(document).on('submit', '[name=form-album]',function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let url = ($(this).find('input[name=id_album]').length !== 0)? 'update': 'add';

    $.ajax({
        url: '/t-album_' + url,
        type: 'post',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        dataType: 'json', // selon le retour attendu
        data: formData,
        success: function (data) {
            if(data.url=== undefined) {
                let modal_message = $('#modal-message');
                modal_message.html(data.message);
                modal_message.find('#message-flash').fadeIn();
                return;
            }

            document.location.href= data.url;
        }
    }, 'json')
});

//récupération de la saison
$('#liste_sSection').on('change', function(e) {
    e.preventDefault();
    let s_section = $(this).val();

    $.post('/t-album_change_section', {s_section:s_section}, function(data){
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        resetDropzone();
        let selectSaison = $('#liste_id_saison');
        $('#list_album').html(data.liste);

        history.replaceState({}, "", "/photo_manage/" + s_section);

        if(data.success === 1){
            selectSaison.html(data.saison).prop('disabled', false);
            return;
        }

        selectSaison.html(data.saison).prop('disabled', true);
    },'json');
});

//recupération des albums
$('#liste_id_saison').on('change', function (e){
    e.preventDefault();
    let id_saison = $(this).val();
    let s_section = $('#liste_sSection').val();

    $.post('/t-album_get_liste',{id_saison:id_saison, s_section:s_section}, function(data){
        if( data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('#list_album').html(data.liste);
    }, 'json');

    resetDropzone();
});

//Supprimer un album
$(document).on('click', '[data-supp=album]', function(e){
    e.preventDefault();
    let li = $(this).closest('li');
    let id_album = getIdSupp(this, 'album');

    $.post('/t-album_supp',{id_album:id_album}, function(data){
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1) {
            li.remove();

            if($('input[type=hidden][name=id_album]').val() === id_album) {
                $('.dz-preview').remove();
                $('#photoupload').hide();

                $('input[name=nom]').val('');
                $('form[id=album] select').val('-1');
                $('form[id=album] button').html('Enregistrer');
                $('input[name=id_album]').val('');

                $(':input').removeClass('input_valide input_erreur');
            }
        }
    },'json');
});

//Définition de la photo de couverture
$('.dropzone').on('click', '.dz-image', function(e){
    e.preventDefault();
    let thumbnail = $(this);

    if(!thumbnail.closest('.dz-preview').hasClass('dz-complete') || thumbnail.closest('.dz-preview').hasClass('dz-error')) {return;}

    let nom = thumbnail.find('img').attr('alt');
    let zone = $('#photoupload');
    let id_album = zone.find('input[name=id_album]').val();

    $.post('/t-album_change_cover', {nom:nom, id_album:id_album}, function(data){
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1){
            $('.dz-image').removeAttr('style');
            thumbnail.css('border','4px solid #e2ba4a');
            zone.find('input[name=id_album]').attr('data-cover',nom);
        }
    },'json');
});

function resetDropzone() {
    $('#photoupload').hide();
    $('.dz-preview').remove();
    $('.dz-message').show();
    $('#alubm-title').html('');
}
/* ----------- */
/*    NEWS     */
/* ----------- */
// submit news
$(document).on('submit','form[name=form-news]', function(e){
    e.preventDefault();
    let url = '/t-' + $(this).attr('action');
    let data = new FormData(this);

    $('.btn-content').hide();
    $('.btn-loader').show();

    $.ajax({
        url: url,
        type: 'post',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        dataType: 'json', // selon le retour attendu
        data: data,
        success: function (data) {
            if(data.message !== ""){
                $('.message').html(data.message);
                $('#message-flash').fadeIn();
                $('.btn-content').show();
                $('.btn-loader').hide();
                return;
            }

            document.location.href="/news"
        }
    });
});

// Confirmation supp news
$(document).on('click','[data-supp=news]', function(e){
    e.preventDefault();
    let id_news = getIdSupp(this, 'news');

    $.post("/t-news_supp", {id_news:id_news}, function(data) {
        if(data.success === 1){
            window.location.reload();
            return;
        }

        $('.message').html(data.message);
        $('#message-flash').fadeIn();
    }, 'json');
});

/* ----------- */
/*   MEMBRES   */
/* ----------- */
// Changement de droit
$('.form-membre').on('change', 'select[name=droit]', function(e){
   e.preventDefault();
   let tr = $(this).closest('tr,.row-flex');

   let id_membre = tr.attr('data-id_membre');
   let id_droit = $(this).val();

   if(id_droit === '1' || id_droit === '2') {
       tr.find('input[type=checkbox]').attr('disabled', false);
   } else {
       tr.find('input[type=checkbox]').attr({'disabled': true, 'checked':false});
   }

   if (id_membre !== undefined) {
        $.post('/t-membre_droit_modif',{id_membre:id_membre, id_droit:id_droit}, function(data){
            if(data.message !== undefined){
                $('.message').html(data.message);
                $('#message-flash').fadeIn();
            }
        }, 'json');
   }

//Changement de section
}).on('click','input[type=checkbox][name!="id_sections[]"]', function () {
    let id_membre = $(this).closest('tr').attr('data-id_membre');
    let id_section = $(this).attr('name');
    let statut;
    if($(this).is(':checked')) {statut = 1;} else {statut = 0;}

    $.post('/t-membre_section_modif', {id_membre: id_membre, id_section:id_section, statut:statut}, function(data){
        if(data.message !== undefined){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
        }
    },'json');
});

//Changer la value de l'input en fonction de l'option sur laquelle on a cliqué
$('#liste-membre').on('input',function(){
    let val = $(this).val();
    let attr = $("option[value='"+val+"']").attr('data-ID_adherent');

    $('input[name=id_membre]').val(attr);
});

/* -------------- */
/*    SPONSORS    */
/* -------------- */
$('form[name=form-sponsor]').on('submit', function(e){
    e.preventDefault();
    let formData = new FormData (this);
    let url = ($(this).find('input[name=id_sponsor]').length !== 0)? 'update': 'add';

    $.ajax({
        url:'/t-sponsor_' + url,
        type:'post',
        contentType: false,
        processData: false,
        dataType: 'json',
        data: formData,
        success: function(data){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();

            if(data.url !== undefined) {
                window.location = data.url;
            }
        }
    }, 'json');
});

/* Confirmation supp d'un sponsors */
$(document).on('click','[data-supp=sponsor]', function(e){
    e.preventDefault();
    let fiche = $(this).closest('div[data-id_sponsor]');
    let id_sponsor = getIdSupp(this, 'sponsor');

    $.post("/t-sponsor_supp",{id_sponsor:id_sponsor},function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1) {
            fiche.remove();
        }
    }, 'json');
});

/* -------------- */
/*    ADHERENT    */
/* -------------- */
let $div_adherents = $('[data-div="adherents"]');
//fonction si check catergorie
$(document).on('click','input[type=checkbox][name*=categorie]' , function () {
    let div_parent = $(this).closest('.form-inline');
    let input_parent = div_parent.closest('div[data-div]');
    let id_section = input_parent.attr('data-div');

    if($(this).is(':checked')) {
        input_parent.find('input[name*=section]').val(id_section);
        div_parent.find('input[name*=fonction]').prop('checked', true);
    } else  if(div_parent.find('input[type=checkbox][name*=categorie]:checked').length === 0) {
        input_parent.find('input[name*=section]').val('');
        div_parent.find('input[name*=fonction]').prop('checked', false);
    }

    let nb_check = div_parent.find('input[type=checkbox][name*=categorie]:checked').length;
    let intitule = nb_check <= 1 ? ' catégorie': ' catégories';
    div_parent.find('.a-intitule').html(nb_check + intitule);
});

//autocomplete input section quand fonction est checke
$(document).on('click', 'input[type=checkbox][name*=fonction]',function (e) {
    e.stopPropagation();
    let input_parent = $(this).closest('.form-inline');
    let div_racine = input_parent.closest('[data-div]');
    let id_section = div_racine.data('div');

    if($(this).is(':checked')) {
        input_parent.find('input[name*=section]').val(id_section);
        input_parent.find('.input-group-right').addClass('open');
        return
    }

    if(div_racine.find('[type=checkbox][name*=fonction]:checked').length === 0){
        div_racine.find('input[name*=section]').val('');
    }

    input_parent.find('input[name*=categorie]').prop('checked', false);
    input_parent.find('.a-intitule').html( '0 catégorie');
    input_parent.find('.input-group-right').removeClass('open');
});

//switch bouton section
$(document).on('click', 'a[data-div]',function(e){
    e.preventDefault();
    let id_section = $(this).attr('data-div');
    let color = $(this).attr('data-color');

    $('a[data-div]').attr('class','btn btn-default');
    $(this).addClass(color);

    $('div[data-div]').hide();
    $('div[data-div=' + id_section + ']').show();
});

//Changement de form
$('.ul-adherent > li > a').on('click', function(e){
    e.preventDefault();
    $('form[name=forms_adherent]').data('cible', $(this).attr('href'));
});

//detecter le formulaire rejeté
$(document).on('erreur', 'form[name=forms_adherent][action=adherent_modif]', function(){
    let message = '<div class="alert alert-danger message-unique" style="display:none" id="message-flash"><div class="message-title"> Vous devez introduire un adhérent.</div><a href="" class="message-close" data-action="message-close"><span class="glyphicon glyphicon-remove" ></span></a></div>';
    $('.message').html(message);
    $('#message-flash').fadeIn();
});

//submit form
$(document).on('submit', 'form[name=forms_adherent]', function(e){
    e.preventDefault();
    let url = '/t-' + $(this).attr('action');
    let cible = $(this).data('cible');
    let data = new FormData(this);

    $.ajax({
        url: url,
        type: 'post',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        dataType: 'json', // selon le retour attendu
        data: data,
        success: function (data) {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();

            if(data.id_adherent !== undefined){
                $('.ul-adherent').attr('data-id_adherent', data.id_adherent);
                $('form[name=adherent_form]').prepend('<input type="hidden" name="id_adherent" value="' + data.id_adherent +'">')
            }

            if(data.success === 1 && cible !== undefined){
                change_form(cible)
            }
        }
    }, 'json');
});

//changement de form
function change_form(cible) {
    let form_cible = $('form[action=' + cible +']');
    if(form_cible.length !== 0) { form_cible.show(); return; }

    let url = '/f-' + cible;
    let type = cible === 'adherent_form'? 'GET' : 'POST';
    let id_ads = $('.ul-adherent').data('id_ads');

    let data = jQuery.param({id_ads: id_ads});

    if(type === 'POST') {
        data = new FormData();
        data.append('id_ads', id_ads);
    }

    $.ajax({
        url: url,
        type: type,
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        data: data,
        success: function (data) {
            if($(data).hasClass('alert-danger')) {
                $('.message').html(data);
                $('#message-flash').fadeIn();
                return;
            }

            $('form[name=forms_adherent]').replaceWith(data);
        }
    });
}

/* Afficher fiche adherent*/
$(document).on('click','a[data-affiche=adherent]', function(e){
    e.preventDefault();
    let id_ads = $(this).closest('tr').attr('data-id_ads');

    $.post("/t-adherent_getFiche", {id_ads:id_ads}, function(data) {
        if(data.message !== ""){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
        }else {
            let modal = $('#Modal');
            modal.find('.modal-content').html(data.adherent);
            modal.modal("show");
        }
    }, 'json');
});

/* Confirmation supp adherent */
$div_adherents.on('click','[data-supp=adherent]', function(e){
    e.preventDefault();
    let input = $(this);
    let id_adherent = getIdSupp(this, 'adherent');

    $.post("/t-adherent_supp", {id_adherent:id_adherent}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1){
            input.closest('tr').remove();
        }
    }, 'json');
});

/* Réinscription */
$div_adherents.on('click','[data-action=reinscrire]', function(e){
    e.preventDefault();
    let $link = $(this);
    let id_adherent = $link.data('id_adherent');

    $.post("/t-adherent_reinscription", {id_adherent:id_adherent}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1) {
            $link.closest('[data-div=confirm]').remove();
        }
    }, 'json');
});

/* Préinscription */
$div_adherents.on('click','[data-action=preinscrire]', function(e){
    e.preventDefault();
    let $link = $(this);
    let id_adherent = $link.data('id_adherent');

    $.post("/t-adherent_preinscription", {id_adherent:id_adherent}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1) {
            $link.remove();
        }
    }, 'json');
});

/* Préinscription */
$('[data-div=preinscrits]').on('click','[data-supp=preinscrire]', function(e){
    e.preventDefault();
    let $link = $(this);
    let id_adherent = $link.data('id_adherent');

    $.post("/t-adherent_suppPreinscription", {id_adherent:id_adherent}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        if(data.success === 1) {
            $link.closest('tr').remove();
        }
    }, 'json');
});
/* -------------------- */
/*    BARRE ADHERENT    */
/* -------------------- */
let $barreAdherent = $('[data-div=barre-adherent]');
$barreAdherent.on('changeDatalist', 'input[name=id_adherent_name]', function(){
    let id_adherent = $(this).val();

    if (id_adherent === "") {
        resetBarre();
        return;
    }

    $.post("/t-barre_getAdherent", {id_adherent: id_adherent}, function(data) {
        if(data.message !== ""){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('[data-div=adherents]').html(data.tableau);
        $('select[name=id_saison]').html(data.options);
        $('select[name=statut]').val('vide').attr('disabled', 'disabled');
        $('select[name=id_section]').val('all').attr('disabled', 'disabled');
    }, 'json');
});

$barreAdherent.on('change', 'select[name=id_saison], select[name=id_section], select[name=statut]', function(){
    let id_adherent_name = $('input[name=id_adherent_name]').val();
    let id_saison = $('select[name=id_saison]').val();

    if(id_adherent_name !== "") {
        $.post("/t-barre_getAdherentBySaison", {id_adherent: id_adherent_name, id_saison: id_saison}, function(data) {
            if(data.message !== ""){
                $('.message').html(data.message);
                $('#message-flash').fadeIn();
                return;
            }

            $('[data-div=adherents]').html(data.tableau);
            $('select[name=statut]').val('vide').attr('disabled', 'disabled');
            $('select[name=id_section]').val('all').attr('disabled', 'disabled');
        }, 'json');

        return;
    }

    let id_section = $('select[name=id_section]').val();
    let statut = $('select[name=statut]').val();

    $.post("/t-barre_getSaison", {id_saison: id_saison, id_section: id_section, statut: statut}, function(data) {
        if(data.message !== ""){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('[data-div=adherents]').html(data.tableau);
    }, 'json');

});

$('input[name=adherent_name]').on('resetDatalist', function () {
    resetBarre();
});

function resetBarre () {
    $.post("/t-barre_reset", function(data) {
        $('[data-div=adherents]').html(data.tableau);
        $('select[name=id_saison]').html(data.options);
        $('select[name=statut]').val('vide').removeAttr('disabled');
        $('select[name=id_section]').val('all').removeAttr('disabled');
    }, 'json');

}

/* ---------------- */
/*    COTISATION    */
/* ---------------- */
//gestion cotisation retirer le disabled ou le mettre si l'input des montant payé
$(document).on('change', 'select[name*="[id_cotisation]"]', function(){
    let tr = $(this).closest('tr');
    let input_montant = tr.find('input[name*="[montant]"]');

    let id_cotisation = $(this).val();

    if(id_cotisation === "5" || id_cotisation === "1"){
        input_montant .val('') .attr('disabled', true);
        return;
    }

    input_montant.attr('disabled', false);
});

//desactiver autre chose que les chiffres sur le montant cotisation
$(document).on('keypress', 'input[name*="[montant]"]', function(e){
    let keyCode = e.keyCode;

    if (keyCode > 31 && (keyCode < 48 || keyCode > 57)) {
        return false;
    }
});

$(document).on('submit', 'form[name=gestion_cotisations]', function(e){
    e.preventDefault();
    let data = new FormData(this);

    $.ajax({
        url: '/t-adherents_cotisation',
        type: 'post',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        dataType: 'json', // selon le retour attendu
        data: data,
        success: function (data) {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
        }
    }, 'json');
});

function getIdSupp(link, items) {
    return $(link).closest('span').siblings('span[data-id_' + items + ']').data('id_' + items );
}