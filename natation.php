<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - natation';
$articleFactory = Article::factory();
$sectionFactory = Section::factory();
$saisonFactory = Saison::factory();
$competitionFactory = Competition::factory();
$sponsorFactory = Sponsor::factory();
$form = Form::factoryForm();
$id_section = Section::NATATION['id'];

$articles = $articleFactory->getArticlesBySection($id_section);
$articles = $articleFactory->orderArticlesForSection($articles);

$sponsors = $sponsorFactory->getSponsorsBySection($id_section);

//Récupération des dirigeants
$ids_dirigeant = $sectionFactory -> getIdDirigeants($id_section);
$ids_membres = $sectionFactory -> getDirectionSection($id_section);
$dirigeant =  $sectionFactory -> orderDirigeant($ids_dirigeant, $ids_membres);

//Récupération de la saison
$id_saison = (isset($_POST['ID_saison']) && is_numeric($_POST['ID_saison']))? $_POST['ID_saison'] : Saison::factory()->getLastSaisonCompetition($id_section);

$saisons = $saisonFactory->getSaisonsByCompetition($id_section);
$arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);

//R2cupération des compétition de la saison en cours
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
                <li role="presentation"><a href="#natation" data-href="natation"> Natation </a></li>
                <li role="presentation" ><a href="#groupe" data-href="groupe"> Groupes </a></li>
                <li role="presentation" ><a href="#competition" data-href="competition"> Compétitions </a></li>
                <li role="presentation" ><a href="#photo" data-href="photo"> Photos </a></li>
                <li role="presentation" ><a href="#sponsor" data-href="sponsor">Sponsors</a></li>
            </ul>
            <?php if($log['droit'] >= Droit::RESP): ?>
                <div class="navbar-form navbar-right hidden-xs" data-manage="competition"><button class="btn btn-primary"> Ajouter compétition  </button></div>
            <?php endif;?>
        </div>
        <!-- Natation -->
        <div class="parallax-cont" id="natation" style="background-image: url('/images/natation1.jpg');">
            <?php if ($log['droit'] >= Droit::REDAC) : ?>
                <a href="" class="btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "Natation" </a>
            <?php endif; ?>
            <div class="side pos-center pos-left" data-title="natation">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Natation</span>
                    <button class="article-btn left-btn" data-lecture="natation">Lire plus</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="natation">
                <button class="btn-close" data-lecture="natation"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Natation</h3>
                <?= $articles['presentation'] ?>
                <div class="suite-article">
                    <strong>Responsable de la section:</strong>
                    <?= $dirigeant ?>
                </div>
            </div>
        </div>
        <!-- Les groupes -->
        <div class="parallax-cont" id="groupe" style="background-image: url('/images/natation2.jpg');">
            <?php if ($log['droit'] >= Droit::REDAC) : ?>
                <a href="" class="btn btn-primary btn-modif-left hidden-xs" data-modif="article"> Modifier "Les Groupes" </a>
            <?php endif; ?>
            <div class="col-md-8 col-md-offset-2 article pos-left" data-article="groupe">
                <button class="btn-close right-close" data-lecture="groupe"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Groupes</h3>
                <?= $articles['groupe'] ?>
            </div>
            <div class="side side-right pos-center pos-right" data-title="groupe">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Groupes</span>
                    <button class="article-btn right-btn" data-lecture="groupe">Lire plus</button>
                </div>
            </div>
        </div>
        <!-- Competition -->
        <div class="parallax-cont" id="competition" style="background-image: url('/images/natation3.jpg');">
            <div class="side pos-center pos-left" data-title="competition">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Compétition</span>
                    <button class="article-btn left-btn" data-lecture="competition">Afficher</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="competition">
                <button class="btn-close right-close" data-lecture="competition"><span class="glyphicon glyphicon-remove" ></span></button>
                <div data-affiche="competition">
                    <div class="row-flex header-competition">
                        <?= $form->select('competition_saison', 'Saison', $arrSaiIdToSaison, ['width' => 'tier','verif' => 0, 'default' => $id_saison])?>
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
        <!-- Les photos -->
        <div class="parallax-cont" id="photo" style="background-image: url('/images/nat_photo.jpg');">
            <div class="side side-right pos-center pos-right text-right">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h side-photo row-pad">Photos</span>
                    <a href="/photo/<?php echo Section::NATATION['slug'] ?>" class="article-btn right-btn"> Afficher </a>
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
                <div class="modal-content">
                </div>
            </div>
        </div>
        <?php include("includes/footer.php"); ?>
        <?php include("includes/script.php"); ?>
	</body>
</html>	
