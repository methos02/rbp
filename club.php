<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - club';

$articleFactory = Article::factory();
$sectionFactory = Section::factory();
$clubFactory = Club::factory();
$form = Form::factoryForm();

$articles = $articleFactory->getArticlesBySection(Section::COMITE['id']);
$articles = $articleFactory->orderArticlesForSection($articles);

//Récuparation du CA
$cas = $sectionFactory->getCategorieCa();
$membres_ca = $sectionFactory->getCaMembre();
$dirigeant =  $sectionFactory -> orderDirigeant($cas, $membres_ca);

//select membre h
$membres_h = $clubFactory -> getAllMembreH();
$arrayMembreH = $clubFactory -> arrMembreIdToName($membres_h);

$id_membre = $clubFactory -> getIdMembreHAlphabet();
$membre_h = $clubFactory -> getMembreH($id_membre);
$membre_h = $clubFactory -> setParams($membre_h);
?>
<!DOCTYPE html>
<html>
<?php include("includes/head.php"); ?>
	<body data-spy="scroll" data-target=".navbar-secondaire">
        <?php include("includes/header.php"); ?>
        <div class="navbar navbar-default navbar-fixed-top navbar-secondaire hidden-xs">
            <ul class="nav nav-pills navbar-left navbar-form">
                <li role="presentation"><a href="#club" data-href="club">Club</a></li>
                <li role="presentation"><a href="#cotisation" data-href="cotisation">Inscription</a></li>
                <li role="presentation"><a href="#historique" data-href="historique">Historique</a></li>
                <li role="presentation"><a href="#photo" data-href="photo"> Photos </a></li>
                <li role="presentation"><a href="#membre_h" data-href="membre_h">Membres d'honneur</a></li>
            </ul>
            <?php if($log['droit'] >= Droit::REDAC) : ?>
                <div class="navbar-form navbar-right">
                    <a class="btn btn-default btn-primary" href="/membreh_manage">Ajouter un Membre d'honneur </a>
                </div>
            <?php endif; ?>
        </div>
        <!-- club -->
        <div class="parallax-cont" id="club" style="background-image: url('/images/club1.jpg');">
            <?php if($log['droit'] >= Droit::REDAC) : ?>
                <a href="" class="modif-custom-div btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "Club" </a>
            <?php endif; ?>
            <div class="side pos-center pos-left" data-title="club">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Le club</span>
                    <button class="article-btn left-btn" data-lecture="club">Lire plus</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="club">
                <button class="btn-close" data-lecture="club"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Le club</h3>
                <?= $articles['presentation']; ?>
                <div class="suite-article">
                    <strong>Responsable de la section:</strong>
                    <?= $dirigeant ?>
                    <div class="row">
                        <div class="col-md-1 col-xs-3"><img src="/images/pdf.png"></div>
                        <div class="col-md-5 col-xs-9 margin-dl">
                            <div class="strong"> Statuts du club </div>
                            <a href="/documents/statuts_2012.pdf" target="_blank"> Télécharger </a>
                        </div>
                        <div class="col-md-1 hidden-xs"><img src="/images/pdf.png"></div>
                        <div class="col-md-5 col-xs-9 margin-dl">
                            <div class="strong"> Réglement d'ordre interrieur </div>
                            <a href="/documents/roi_2015.pdf" target="_blank"> Télécharger </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inscription -->
        <div class="parallax-cont" id="cotisation" style="background-image: url('/images/club2.jpg');">
            <?php if($log['droit'] >= Droit::REDAC) : ?>
                <a href="" class="modif-custom-div btn btn-primary btn-modif-left hidden-xs" data-modif="article"> Modifier "Cotisation" </a>
            <?php endif; ?>
            <div class="col-md-8 col-md-offset-2 article pos-left" data-article="cotisation">
                <button class="btn-close right-close" data-lecture="cotisation"><span class="glyphicon glyphicon-remove" ></span></button>
                <div class="suite-article">
                    <h3 class="h-section">Inscription</h3>
                    <p>​Le certificat médical est obligatoire pour tous les membres licenciés "compétiteurs" et doit être renouvelé avant le 10 décembre de chaque année. Le certificat médical devra être daté entre le 1 aoùt et le 30 novembre 2017 afin de réactiver la licence pour l'année civile suivante.</p>
                    <div class="row">
                        <div class="col-md-1"><img src="/images/pdf.png"></div>
                        <div class="col-md-9 margin-dl">
                            <div class="strong"> Licence et certificat médicale </div>
                            <a href="/documents/licence_cm_2022-2023.pdf" target="_blank"> Télécharger </a>
                        </div>
                    </div>
                </div>
                <h3 class="h-section">Cotisation</h3>
                <?= $articles['cotisation']; ?>
                <div class="suite-article">
                    <div class="row margin-bot">
                        <div class="col-md-1"><img src="/images/pdf.png"></div>
                        <div class="col-md-9 margin-dl">
                            <div class="strong"> Cotisation </div>
                            <a href="/documents/lettre_cotisation_2022-2023.pdf" target="_blank"> Télécharger </a>
                        </div>
                    </div>
                    <small>* Ces réductions ci-dessus sont accordées aux membres considérés comme étant à charge sur le plan fiscal, et ce pour autant que le 1er enfant ait payé une cotisation pleine.</small>
                </div>
            </div>
            <div class="side side-right pos-center pos-right text-right" data-title="cotisation">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad">Inscription</span>
                    <button class="article-btn right-btn" data-lecture="cotisation">Lire plus</button>
                </div>
            </div>
        </div>
        <!-- Historique -->
        <div class="parallax-cont" id="historique" style="background-image: url('/images/club3.jpg');">
            <?php if($log['droit'] >= Droit::REDAC) : ?>
                <a href="" class="modif-custom-div btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "Historique" </a>
            <?php endif; ?>
            <div class="side pos-center pos-left" data-title="historique">
            <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
            </svg>
            <div class="side-intitule">
                <span class="article-h row-pad">Historique</span>
                <button class="article-btn left-btn" data-lecture="historique">Lire plus</button>
            </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="historique">
                <button class="btn-close" data-lecture="historique"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Historique</h3>
                <?= $articles['historique']; ?>
            </div>
        </div>
        <!-- Les photos -->
        <div class="parallax-cont" id="photo" style="background-image: url('/images/club_photo.jpg');">
            <div class="side side-right pos-center pos-right text-right">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h side-photo row-pad">Photos</span>
                    <a href="/photo/<?php echo Section::COMITE['slug'] ?>" class="article-btn right-btn"> Afficher </a>
                </div>
            </div>
        </div>
        <!-- Membre d'honneur -->
        <div class="container-fluid reference" id="membre_h">
            <div class="row-membreh">
                <h2>Membre d'honneur </h2>
                <?= $form->select('membre_h', "Membre d'honneur", $arrayMembreH, ['verif' => 0])?>
            </div>
            <div class="row">
                <?php include ('includes/fiche/membrehFiche.php') ?>
            </div>
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog responsive-modale" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>
        <?php include("includes/footer.php"); ?>
        <?php include("includes/script.php"); ?>
	</body>
</html>	
