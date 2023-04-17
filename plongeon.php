<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Plongeon';
$articleFactory = Article::factory();
$sectionFactory = Section::factory();
$saisonFactory = Saison::factory();
$competitionFactory = Competition::factory();
$sponsorFactory = Sponsor::factory();
$form = Form::factoryForm();
$id_section = Section::PLONGEON['id'];

$articles = $articleFactory->getArticlesBySection($id_section);
$articles = $articleFactory->orderArticlesForSection($articles);

$sponsors = $sponsorFactory->getSponsorsBySection($id_section);

//Récupération des dirigeants
$ids_dirigeant = $sectionFactory -> getIdDirigeants($id_section);
$ids_membres = $sectionFactory -> getDirectionSection($id_section);
$dirigeant =  $sectionFactory -> orderDirigeant($ids_dirigeant, $ids_membres);

//Récupération de la saison
$id_saison = $saisonFactory->getLastSaisonCompetition($id_section);

//Création des options du select saison
$saisons= $saisonFactory->getSaisonsByCompetition($id_section);
$arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);

//Récupération des compétition de la saison en cours
$competitions = $competitionFactory -> getAllCompetition($id_section, $id_saison);
$competitions = $competitionFactory->setsCalendrierParams($competitions, $log);

?>
<!DOCTYPE html>
<html lang="fr">
	<?php include("includes/head.php"); ?>
	<body data-spy="scroll" data-target=".navbar-secondaire" data-id_section="<?php echo $id_section ?>">
        <?php include("includes/header.php"); ?>
        <div class="navbar-default navbar-fixed-top navbar-secondaire hidden-xs">
            <ul class="nav nav-pills navbar-left navbar-form">
                <li role="presentation"><a href="#plongeon" data-href="plongeon">Plongeon</a></li>
                <li role="presentation"><a href="#entrainement" data-href="entrainement">Entrainements</a></li>
                <li role="presentation"><a href="#competition"  data-href="competition">Compétitions</a></li>
                <li class="hidden-xs" role="presentation"><a href="#sponsor" data-href="sponsor">Sponsors</a></li>
            </ul>
            <ul class="nav nav-pills navbar-right navbar-form">
                <li><a href="https://www.facebook.com/RBPplongeon?ref=hl" target="_blank" class="nav-a"><img src="/images/facebook.png" alt="logo facebook"></a></li>
                <li><a href="https://www.flickr.com/photos/ivandupont/sets/72157648406157091/" target="_blank" class="nav-a"><img src="/images/flickr.png" alt="logo flickr"></a></li>
                <?php if($log['droit'] >= Droit::RESP): ?>
                    <li><button class="btn btn-primary margin-left" data-manage="competition"> Ajouter compétition  </button></li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Plongeon -->
        <div class="parallax-cont" id="plongeon" style="background-image: url('/images/plongeon1.jpg');">
            <?php if($log['droit'] >= Droit::REDAC): ?>
                <a href="" class="btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "Plongeon" </a>
            <?php endif; ?>
            <div class="side pos-center pos-left" data-title="plongeon">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Plongeon</span>
                    <button class="article-btn left-btn" data-lecture="plongeon">Lire plus</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="plongeon">
                <button class="btn-close" data-lecture="plongeon"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Plongeon</h3>
                <?= $articles['presentation']; ?>
            </div>
        </div>
        <!-- Entrainement -->
        <div class="parallax-cont" id="entrainement" style="background-image: url('/images/plongeon2.jpg');">
            <?php if($log['droit'] >= Droit::REDAC): ?>
                <a href="" class="btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "L'entrainement" </a>
            <?php endif; ?>
            <div class="col-md-8 col-md-offset-2 article pos-left" data-article="entrainement">
                <button class="btn-close right-close" data-lecture="entrainement"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Entraînements</h3>
                <?= $articles['entrainement']; ?>
            </div>
            <div class="side side-right pos-center pos-right" data-title="entrainement">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Entraînements</span>
                    <button class="article-btn right-btn" data-lecture="entrainement">Lire plus</button>
                </div>
            </div>
        </div>
        <!-- Compétition -->
        <div class="parallax-cont" id="competition" style="background-image: url('/images/plongeon3.jpg');">
            <div class="side pos-center pos-left" data-title="competition">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Compétition</span>
                    <button class="article-btn left-btn" data-lecture="competition">Lire plus</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="competition">
                <button class="btn-close" data-lecture="competition"><span class="glyphicon glyphicon-remove" ></span></button>
                <div data-affiche="competition">
                    <div class="row-flex header-competition">
                        <?= $form->select('competition_saison', 'Saison', $arrSaiIdToSaison, ['width' => 'tier', 'verif' => 0, 'default' => $id_saison])?>
                        <div class="competition-legende">
                            <span class="glyphicon glyphicon-ok" style="color: #5cb85c"></span> RBP présent
                            <span class="glyphicon glyphicon glyphicon-alert" style="color: darkorange"></span> RBP absent
                            <span class="glyphicon glyphicon glyphicon-remove" style="color: red"></span> Annulé
                        </div>
                    </div>
                    <div class="col-xs-12 row-pad" id="table_competition"><?php include ('includes/table/competitionsTable.php') ?></div>
                </div>
                <div id="form-competition" style="display: none"></div>
            </div>
        </div>
        <!-- Sponsor -->
        <div class="parallax-cont div-sponsor"  id="sponsor">
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
                <div class="modal-content">
                </div>
            </div>
        </div>
        <?php include("includes/footer.php"); ?>
        <?php include("includes/script.php"); ?>
	</body>
</html>	
