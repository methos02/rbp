/* ------------------ */
/* FONCTIONS COMMUNES */
/* ------------------ */
let isHistory = (typeof history.pushState === 'undefined')? 0 : 1;

$('body').scrollspy({ target: '.navbar-secondaire', offset: 150 });

if (navigator.userAgent.indexOf('Safari') !== -1 && navigator.userAgent.indexOf('Chrome') === -1) {
    $('.parallax-cont').addClass('parallax-ios');
}

//Message pour l'utilisateur
$(window).on('load',function(){
    if($('.message').html() !== ''){
        $('#message-flash').slideDown();
    }
});

//Réduire message
$(document).on('click', 'a[data-action=message-close]', function(e){
    e.preventDefault();
    $('#message-flash').slideUp(500, function(){ $(this).remove();});
});

/* Déroulement des menus */
$(document).on('click', 'a[data-href]', function (e) {
    e.preventDefault();

    let link = $(this).attr('data-href');
    $('html, body').animate({ scrollTop: $('[id='+link+']').offset().top - 101  }, 750);
});

//Prévention des link
$(document).on('click', '.link-prevent', function (e) {
    e.preventDefault();
});

/* Modification du menu */
$(document).on('click', 'a[data-link]', function(){
    //Recherche de l'ancre
    let url = window.location.pathname;
    let ancre = $(this).attr('data-link');

    //modification de l'url
    history.pushState(null, "", url+'#'+ancre);

    $('ul[class*=navbar-section]>li').removeClass('active');
    $(this).parent('li').addClass('active');
});

/* Inscription: changement d'étape */
$(document).on('click', 'a[data-menu]', function(e){
    e.preventDefault();

    let menu = $(this).attr('data-menu');
    $('li[data-form]').hide();
    $('li[data-form=' + menu + ']').show();
    e.stopPropagation();
});

/* Inscription */
$(document).on('submit', 'form[name=inscription]', function(e){
    e.preventDefault();
    let data = new FormData(this);

    $.ajax({
        url:"/t-inscription",
        type: 'post',
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success:function(data) {
            $('.message').html(data.message);
            $('#message-flash').slideDown(500);
        }
    });
});

/* Envoie de mail nouveau mot de passe ou mail validation*/
$('form[name*=mail_]').on('submit', function(e){
    e.preventDefault();
    let mail = $(this).find('input[name=mail]').val();
    let action = $(this).attr('name');

    $.post("/t-" + action,{mail:mail},function(data) {
        $('.message').html(data.message);
        $('#message-flash').slideDown(500);
        $('[data-nav=gestion]').removeClass('open');
        $('[data-form]').hide();
        $('[data-form=form_connexion]').show();
    },'json');
});

/* Modification mot de passe */
$('form[name=mdp_modif]').on('submit', function(e){
    e.preventDefault();
    let data = new FormData(this);

    $.ajax({
        url:"/t-mdp_modif",
        type: 'post',
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success:function(data) {
            if (data.success === 1) {
                window.location = '/accueil';
                return;
            }

            $('.message').html(data.message);
            $('#message-flash').slideDown(500);
        }
    });
});

// Réaffichage du menu de connection
$('[data-ajax]').on('click', function(e){
    e.preventDefault();

    $.post('includes/header/form_connection.php', function(data){
        $('[data-nav=gestion]').replaceWith(data);
    });
});

/* ------- */
/* Article */
/* ------- */
//Afficher l'article
$(document).on('click','button[data-lecture]', function(e){
    e.preventDefault();
    $(this).attr('disabled',true);

    let attr = $(this).attr('data-lecture');
    article_affiche(attr);

    $(this).attr('disabled', false);
});

function article_affiche (attr){
    let article = $('div[data-article=' + attr + ']');
    let side = $('div[data-title=' + attr + ']');

    side.toggleClass('pos-center');
    article.toggleClass('pos-center');

    resize_article(article);
}

/* Changement de la taille de la div article */
$('[data-article] form').on('DOMSubtreeModified',function(){
    let article = $(this).closest('[data-article]');
    resize_article(article, true);
});

function resize_article(article, force){
    let parallax = article.closest('.parallax-cont');
    let article_height = article.outerHeight(true);
    let paralax_height = window.innerHeight - $('.navbar-default').outerHeight(true);

    //hauteur si l'article est au centre avec un écran
    if(screen.width >= 740) {
        if (article_height > paralax_height && (article.hasClass('pos-center') === true || force === true)) {
            parallax.animate({height:article_height},1000);
        }  else {
            parallax.animate({height:window.innerHeight - 101},300);
        }
    } else {
        if (article_height > paralax_height / 2 && (article.hasClass('pos-center') === true || force === true)) {
            parallax.animate({height:article_height},1000);
        }  else {
            parallax.animate({height: window.innerHeight/2},300).css("height","");
        }
    }
}

/* --------- */
/*   CLUB    */
/* --------- */
//Affichage des membres d'honneur
$('select[name=membre_h]').on('change', function(e){
    e.preventDefault();
    let id_membreh = $(this).val();

    $.post("/t-membreh_getFiche", {id_membreh:id_membreh}, function(data) {
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('.affiche_membre_h').replaceWith(data.fiche);
    },'json');
});

/* ------------------- */
/* NATATION - PLONGEON */
/* ------------------- */
//Changement de saison
$(document).on('change','select[name=competition_saison]', function() {
    let id_saison = $(this).val();
    let id_section = $('body').data('id_section');

    $.post("/t-competitions_get", {id_section: id_section, id_saison: id_saison}, function (data) {
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        } 
        
        $('#table_competition').html(data.calendrier);
        resize_article($('div[data-article=competition]'), true);
    }, 'json');
});

/* affichage de la compétition*/
$(document).on('click', 'a[class*=affiche-competition]', function(e){
    e.preventDefault();
    let id_competition = $(this).closest('tr').data('id_competition');

    $.post("/fiche/competition",{id_competition:id_competition}, function(data) {
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        let modal = $('#Modal');
        modal.find('.modal-content').html(data.fiche);
        modal.modal("show");
    }, 'json');
});

/* ------------ */
/*   NATATION   */
/* ------------ */
/* Changement de href pour télécharger documentation*/
$(document).on('change','select[data-download=document]',function () {
    let link = $(this).val();
    $('a[class*=competition-link]').attr('href',link);
});

/* ------------ */
/* WATER - POLO */
/* ------------ */
/* Changement des categories en fonction de la saison demandé*/
$(document).on('change','select[name=calendrier_saison]', function(){
    let id_saison = $(this).val();

    $.post("/t-match_calendrier_select", {id_saison:id_saison}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();

        $('.btns-categorie').html(data.btn);
        $('#match').css('background-image','url(images/equipe_17.jpg)');

        $('#table-match').html(data.calendrier);
        resize_article($('div[data-article=match]'), true);

    },'json');
});

$(document).on('click','.btn-categorie', function(e){
    e.preventDefault();
    let btn = $(this);
    let id_categorie = btn.attr('data-id_cat');
    let id_saison = $('select[name=calendrier_saison]').val();

    $.post("/t-match_calendrier_btn", {id_saison:id_saison, id_categorie:id_categorie}, function(data) {
        if (data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('[data-id_cat]').removeClass('btn-primary');
        btn.addClass('btn-primary');

        $('#match').css('background-image','url(images/equipe_'+id_categorie+'.jpg)');

        $('#table-match').html(data.calendrier);
        resize_article($('div[data-article=match]'), true);
    },'json');
});

/* Affichage modal match */
$(document).on('click','tr[data-ID_match]', function(e){
    if($(e.target).is('input') || $(e.target).is('span[class*=glyphicon]') || $(e.target).is('button[class*=btn-report]')) {return;}
    let id_match = $(this).attr('data-id_match');

    $.post("/fiche/match",{id_match:id_match},function(data){
        if (data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('.modal-content').html(data.fiche);
        $('#Modal').modal('show');
    }, 'json');
});

/* ------------- */
/*    CONTACT    */
/* ------------- */
//submit du message
$('form[data-action=contact]').on('submit',function(e) {
    e.preventDefault();
    let form = $(this);
    let formdata = new FormData(this);

    $.ajax({
        url:'/t-contact_message',
        type:'post',
        contentType: false,
        processData: false,
        dataType: 'json',
        data: formdata,
        success: function(data){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();

            if($(data.message).hasClass('alert-danger')) {return}

            form.find(':input[type!=submit]').each(function(){
                if($(this).is('select')) {
                    $(this).val('-1');
                } else {
                    $(this).val('');
                }
                $(this).removeClass('input_valide input_erreur');
            });
        }
    }, 'json');
});

/* ------------ */
/*   SPONSORS   */
/* ------------ */
//Affiche sponsor
$(document).on('click', 'a[data-affiche=sponsor]', function(e){
    e.preventDefault();
    let id_sponsor = $(this).closest('div[data-id_sponsor]').attr('data-id_sponsor');

    $.post("/fiche/sponsor", {id_sponsor:id_sponsor}, function(data) {
        if(data.message !== ''){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        let modal = $('#Modal');
        modal.find('.modal-content').html(data.fiche);
        modal.modal("show");
    }, 'json');
});

//affichage des sponsors en fonction des section
$('select[name=spo_section]').on('change', function(e){
    e.preventDefault();
    let id_section = $(this).val();

    $.post("/t-sponsors_get", {id_section:id_section}, function(data) {
        if(data.message !== ''){
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('[data-affiche=sponsors]').html(data.sponsors)

    }, 'json');
});

/* ------------- */
/*  ALBUM PHOTO  */
/* ------------- */
//Afficher un l'album
$('.contenu-photo').on('click','.div-album', function(e){
    e.preventDefault();
    let slug = $(this).data('slug');
    afficheAlbum(slug)
});

function afficheAlbum (slug) {
    $.post('/t-album_affiche',{slug:slug}, function(data){
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        let photos = [];
        $.each(data.photos, function(key, value) {
            photos.push({
                'src': '/photo/'+ value,
                'thumb': '/photo/'+ value
            });
        });

        $('#album').lightGallery( {
            dynamic: true,
            dynamicEl: photos,
            thumbnail:true,
            animateThumb: false,
            showThumbByDefault: false
        });

        $('body').css('overflow','hidden');
    }, 'json');
}

$('#album').on('onCloseAfter.lg', function() {
    $(this).data('lightGallery').destroy(true);
});

//récupération de la saison
$('#photo_sSection').on('change', function(e) {
    e.preventDefault();
    let s_section = $(this).val();

    if(s_section === '-1') { return;}

    $.post('/t-album_change_section', {s_section:s_section}, function(data){
        let $selectSaison = $('#photo_idSaison');
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('.contenu-photo').html(data.albums);
        $('a[data-modif=photos]').attr('href','/photo_manage/' + s_section);
        $selectSaison.html(data.saison);

        history.replaceState({}, "", "/photo/" + s_section);

        if(data.success === 1) {
            $selectSaison.prop('disabled', false);
            return;
        }

        $selectSaison.prop('disabled', true);
    },'json')
});

$('#photo_idSaison').on('change', function (e){
    e.preventDefault();
    let id_saison = $(this).val();
    let s_section = $('#photo_sSection').val();

    if(id_saison !== '-1' && s_section !== '-1') {
        $.post('/t-album_change_saison', {id_saison:id_saison, s_section:s_section}, function(data){
            if(data.message !== "") {
                $('.message').html(data.message);
                $('#message-flash').fadeIn();
                return;
            }

            $('.contenu-photo').html(data.albums);

        }, 'json')
    }
});

/* ---------- */
/*    NEWS    */
/* ---------- */
//affichage des news en fonction des sections
$('select[name=newsSection]').on('change', function(e){
    e.preventDefault();
    change_news('1');
    news_historique('1');
});

//lecture de le news
$('[data-div=news]').on('click', '[data-affiche_news]', function(e){
    if($(e.target).is('.glyphicon')) { return; }
    let id_news = $(this).data('affiche_news');

    $.post('/t-news_affiche', {id_news:id_news}, function(data){
        if(data.message !== "") {
            $('.message').html(data.message);
            $('#message-flash').fadeIn();
            return;
        }

        $('[data-affiche]').html(data.news);
        $('#Modal').modal("show");
    }, 'json')
});

//changement de news
$(document).on('click', '.paginateur-fleche', function(e){
    e.preventDefault();
    if($(this).hasClass('link-prevent')){return;}

    let page = $(this).attr('data-page');
    change_news(page);
    news_historique(page);
});

$(document).on('keyup', '.paginateur', function (e) {
    if (e.keyCode === 13) {
        if($(this).hasClass('')){return;}

        let page = $(this).val();
        change_news(page);
        news_historique(page);
    }
});

//submit adresse mail news
$('.form-mail-news').on('submit', function(e){
    e.preventDefault();

    let mail = $('#news_mail').val();
    let captcha = grecaptcha.getResponse();

    $.post("/t-newsletter_inscription", {mail:mail, captcha: captcha}, function(data) {
        $('.message').html(data.message);
        $('#message-flash').fadeIn();
        grecaptcha.reset();
    },'json');
});

//deplacement de la div mail
$('a[data-action=close-news-mail]').on('click', function(e){
    e.preventDefault();
    $('.div-mail-news').remove();

    let date = new Date();
    date.setTime(date.getTime() + 360 * 24 * 60 * 60 * 1000);

    document.cookie = 'div_mail_news=0; expires=' + date.toGMTString() + '; path=/';
});
