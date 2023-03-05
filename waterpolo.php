<?php
use App\Core\Core_rbp;

$params = include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Water-polo';

$articleFactory = Article::factory();
$sectionFactory = Section::factory();
$sponsorFactory = Sponsor::factory();
$saisonFactory = Saison::factory();
$matchFactory = MatchM::factory();
$formFactory = Form::factoryForm();

$articles = $articleFactory->getArticlesBySection(Section::WATERPOLO['id']);
$articles = $articleFactory->orderArticlesForSection($articles);

$entente = $sectionFactory -> getEquipe();

$sponsors = $sponsorFactory->getSponsorsBySection(Section::WATERPOLO['id']);

//Récupération des dirigeants
$ids_dirigeant = $sectionFactory -> getIdDirigeants(Section::WATERPOLO['id']);
$ids_membres = $sectionFactory -> getDirectionSection(Section::WATERPOLO['id']);
$dirigeant =  $sectionFactory -> orderDirigeant($ids_dirigeant, $ids_membres);

/* Création du select calandrier */
$id_saison = Saison::factory()->getLastSaisonPolo();
$id_currentSaison = Saison::factory()->saisonActive(false);

// Récupération du match
$btn_categorie = $btn_categorie = Core_rbp::getCategorieBtn($id_saison, MatchM::DEFAULT_TEAM);

$matchs = $matchFactory -> getCalendrier($id_saison, MatchM::DEFAULT_TEAM);
$matchs = $matchFactory->setsParams($matchs, $id_currentSaison);

$saisons = $saisonFactory->getSaisonsByPoloCategorie();
$arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
	<?php include('includes/head.php') ?>
	<body data-spy="scroll" data-target=".navbar-waterpolo">
        <?php include('includes/header.php'); ?>
        <div class="navbar-default navbar-fixed-top navbar-secondaire hidden-xs">
            <ul class="navbar-left nav nav-pills navbar-form">
                <li role="presentation"><a href="#polo" data-href="polo"> Water-polo </a></li>
                <li role="presentation"><a href="#adulte" data-href="adulte"> Adulte </a></li>
                <li role="presentation"><a href="#jeune" data-href="jeune"> Jeune </a></li>
                <li role="presentation"><a href="#match" data-href="match"> Calendrier </a></li>
                <li  role="presentation"><a href="#photo" data-href="photo"> Photos</a></li>
                <li  role="presentation"><a href="#sponsor" data-href="sponsor">Sponsors</a></li>
            </ul>
        </div>
        <!-- Waterpolo -->
        <div class="parallax-cont" id="polo" style="background-image: url('/images/waterpolo1.jpg');">
            <?php if ($params['log']['droit'] >= Droit::REDAC) : ?>
                <a href="" class="btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "Water-polo" </a>
            <?php endif; ?>
            <div class="side pos-center pos-left" data-title="polo">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Water-polo</span>
                    <button class="article-btn left-btn" data-lecture="polo">Lire plus</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="polo">
                <button class="btn-close" data-lecture="polo"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Water-polo</h3>
                <?= $articles['presentation']; ?>
                <div class="suite-article">
                    <strong>Responsable de la section:</strong>
                    <?= $dirigeant ?>
                </div>
            </div>
        </div>
        <!-- Senior -->
        <div class="parallax-cont" id="adulte" style="background-image: url('/images/equipe1.jpg');">
            <?php if ($params['log']['droit'] >= Droit::REDAC) : ?>
                <a href="" class="btn btn-primary btn-modif-left hidden-xs" data-modif="article"> Modifier "Section Adulte" </a>
            <?php endif; ?>
            <div class="col-md-8 col-md-offset-2 article pos-left" data-article="adulte">
                <button class="btn-close right-close" data-lecture="adulte"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Equipe Sénior</h3>
                <?= $articles['adulte']; ?>
            </div>
            <div class="side side-right pos-center pos-right" data-title="adulte">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Equipe Sénior</span>
                    <button class="article-btn right-btn" data-lecture="adulte">Lire plus</button>
                </div>
            </div>
        </div>
        <!-- Jeune -->
        <div class="parallax-cont" id="jeune" style="background-image: url('/images/groupe_jeune.jpg');">
            <?php if ($params['log']['droit'] >= Droit::REDAC) : ?>
                <a href="" class="btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "Section Jeune" </a>
            <?php endif; ?>
            <div class="side pos-center pos-left" data-title="jeune">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Section Jeune</span>
                    <button class="article-btn left-btn" data-lecture="jeune">Lire plus</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="jeune">
                <button class="btn-close" data-lecture="jeune"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Section Jeune</h3>
                <?= $articles['jeune']; ?>
                <div class="suite-article">
                    <strong>Horraire</strong>
                    <p>Les entrainements se déroulent le mardi de 19h à 20h45 et le dimanche de 19h à 21h00</p>
                    <strong>Equipe</strong>
                    <p><?= $entente ?></p>
                    <strong>Entraineur</strong>
                    <p>
                        Entraineur débutant: NUMANOVIC Ennis. <br>
                        Entraineur U15-U17: WIDOMSKI Cyprien - HAKEM Simon.
                    </p>
                </div>
            </div>
        </div>
        <!-- Calendrier -->
        <div class="parallax-cont" id="match" style="background-image: url('/images/equipe_17.jpg');">
            <div class="col-md-8 col-md-offset-2 article pos-left" data-article="match">
                <button class="btn-close right-close" data-lecture="match"><span class="glyphicon glyphicon-remove" ></span></button>
                <div data-affiche="match">
                    <div class="row-flex row-calendrier">
                        <?= $formFactory->select('calendrier_saison', 'Saison', $arrSaiIdToSaison, ['null' => 0, 'verif' => 0, 'default' => $id_saison])?>
                        <div class="btns-categorie"><?php echo $btn_categorie; ?></div>
                    </div>
                    <div id="table-match">
                        <?php include ('includes/table/matchsTable.php') ?>
                    </div>
                </div>
            </div>
            <div class="side side-right pos-center pos-right" data-title="match">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Calendrier</span>
                    <button class="article-btn right-btn" data-lecture="match">Afficher</button>
                </div>
            </div>
        </div>
        <!-- photo -->
        <div class="parallax-cont" id="photo" style="background-image: url('/images/wp_photo.jpg');">
            <div class="side pos-center pos-left" data-title="photo">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad"> Photo </span>
                    <a href="/photo/<?php echo Section::WATERPOLO['slug'] ?>" class="article-btn left-btn"> Afficher </a>
                </div>
            </div>
        </div>
        <!-- Sponsor -->
        <div class="parallax-cont div-sponsor" id="sponsor">
            <div class="container-fluid">
                <h2 class="article-h row-pad">Sponsors </h2>
                <div class="row">
                    <div class="col-md-6"><div class="row"><?php include ('includes/table/sponsorsTable.php')?></div></div>
                    <div class="col-md-6"><?php include('includes/form/message_form.php') ?></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content"></div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
        <?php include("includes/script.php"); ?>
	</body>
</html>	
