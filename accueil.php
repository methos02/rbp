<?php
include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Accueil';
$newsFactory = News::factory();

$newsArray = $newsFactory->getNewsAccueil();

if(!isset($_SESSION['already_visited']) && !in_array($_SERVER['REMOTE_ADDR'], array('81.240.125.88'))){
    $_SESSION['already_visited'] = true;
    Core_rbp::visiteur();
}

?>
<!DOCTYPE html>
<html>
	<?php include ('includes/head.php') ?>
	<body class="no-sectionBarre">
        <div class="container-fluid">
            <?php include("includes/header.php"); ?>
            <div class="container">
                <div class="margin-top">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                            <li data-target="#myCarousel" data-slide-to="3"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="/images/accueil_1.jpeg" alt="Le club">
                                <div class="carousel-caption" >
                                    <h3 ><a href="club.html">Le club</a></h3>
                                    <p><span class="image-accueil">Le RBP un club d'histoire.</span></p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="/images/accueil_2.jpeg" alt="natation">
                                <div class="carousel-caption">
                                    <h3><a href="natation.html">Natation</a></h3>
                                    <p>Sport alliant la technique et la performance.</p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="/images/accueil_3.jpeg" alt="waterpolo">
                                <div class="carousel-caption">
                                    <h3><a href="waterpolo.html">Water-polo</a></h3>
                                    <p>Sport collectif aquatique.</p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="/images/accueil_4.jpeg" alt="plongeon">
                                <div class="carousel-caption">
                                    <h3><a href="plongeon.html">Plongeon</a></h3>
                                    <p>Sport alliant la gymnastique et le plaisir de l'eau.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <h2 class="row-pad">Dernières News</h2>
                <div class="affiche-news" data-div="news"><?php include ('includes/table/newsTable.php')?></div>
            </div>
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-news" role="document">
                <div class="modal-content" data-affiche="news"></div>
            </div>
        </div>
        <?php include("includes/footer.php"); ?>
        <?php include("includes/script.php"); ?>
	</body>
</html>