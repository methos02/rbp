<?php use App\Core\Form;

include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Sponsor';

$articleFactory = Article::factory();
$sponsorFactory = Sponsor::factory();
$form = Form::factoryForm();

$articles = $articleFactory->getArticlesBySection(Section::COMITE['id']);
$articles = $articleFactory->orderArticlesForSection($articles);

//Sponsors à afficher
$sponsors = $sponsorFactory->getSponsorsBySection('all');
?>
<!DOCTYPE html>
<html>
	<?php include("includes/head.php"); ?>
	<body data-spy="scroll" data-target=".navbar-secondaire">
        <?php include("includes/header.php"); ?>
        <div class="navbar-default navbar-fixed-top navbar-secondaire  hidden-xs">
            <ul class="nav nav-pills navbar-left navbar-form">
                <li role="presentation"><a href="#pourquoi" data-href="pourquoi"> Pourquoi ?</a></li>
                <li role="presentation"><a href="#comment"  data-href="comment">Comment ?</a></li>
                <li role="presentation"><a href="#sponsor" data-href="sponsor"> Sponsors / Contact</a></li>
            </ul>
            <?php if($log['droit'] >= Droit::RESP): ?>
                <div class="navbar-form navbar-right hidden-xs"><a class="btn btn-default btn-primary" href="/sponsor_manage">Ajouter un sponsor</a></div>
            <?php endif; ?>
        </div>
        <!-- Pourquoi -->
        <div class="parallax-cont" id="pourquoi" style="background-image: url('/images/spo_sponsor.jpg');">
            <?php if($log['droit'] >= Droit::REDAC): ?>
                <a href="" class="btn btn-primary btn-modif-left hidden-xs" data-modif="article"> Modifier "Pourquoi ?" </a>
            <?php endif; ?>
            <div class="side pos-center pos-left" data-title="pourquoi">
                <svg class="svg left-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 0,0 L 50,0 L 10,410 L 0,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="10" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad"> Pourquoi nous soutenir ? </span>
                    <button class="article-btn left-btn" data-lecture="pourquoi">Lire plus</button>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2 article pos-right" data-article="pourquoi">
                <button class="btn-close" data-lecture="pourquoi"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section">Pourquoi nous soutenir ?</h3>
                <?= $articles['pourquoi']; ?>
            </div>
        </div>
        <!-- comment -->
        <div class="parallax-cont" id="comment" style="background-image: url('/images/spo_pourquoi.jpg');">
            <?php if($log['droit'] >= Droit::REDAC): ?>
                <a href="" class="btn btn-primary btn-modif-right hidden-xs" data-modif="article"> Modifier "Comment ?" </a>
            <?php endif; ?>
            <div class="col-md-8 col-md-offset-2 article pos-left" data-article="comment">
                <button class="btn-close right-close" data-lecture="comment"><span class="glyphicon glyphicon-remove" ></span></button>
                <h3 class="h-section"></h3>
                <div data-affiche="comment">
                    <h3 class="h-section"> Comment nous soutenir ?</h3>
                    <?= $articles['comment']; ?>
                </div>
            </div>
            <div class="side side-right pos-center pos-right" data-title="comment">
                <svg class="svg right-svg pos-center" viewBox="0 0 100 400">
                    <path d="M 50,0 L 100,0 L 100,400 L 90,410 Z" class="path-article"></path>
                    <line x1="50" y1="-10" x2="90" y2="410" stroke="black" stroke-width="20"></line>
                </svg>
                <div class="side-intitule">
                    <span class="article-h row-pad"> Comment nous soutenir? </span>
                    <button class="article-btn right-btn" data-lecture="comment">Lire plus</button>
                </div>
            </div>
        </div>
        <!-- Sponsor -->
        <div class="div-sponsor container-fluid" id="sponsor">
            <div class="row reference">
                <div class="col-md-6">
                    <div class="row-flex">
                        <h2 class="flex">Sponsors </h2>
                        <?= $form->select('spo_section', 'Section:', ['all' => 'Toutes'] + Section::ID_TO_NAME, ['verif' => 0]) ?>
                    </div>
                    <div class="row margin-top" data-affiche="sponsors"><?php include ('includes/table/sponsorsTable.php')?></div>
                </div>
                <div class="col-md-6 margin-top"><?php include('includes/form/message_form.php') ?></div>
            </div>
        </div>
        <?php include("includes/footer.php"); ?>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                </div>
            </div>
        </div>
        <?php include("includes/script.php"); ?>
	</body>
</html>	
