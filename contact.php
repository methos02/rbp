<?php include __DIR__.'/includes/init.php';
$meta['nom'] = 'Royal Brussels Poseidon - Contact';
?>
<!DOCTYPE html>
<html>
	<?php include("includes/head.php"); ?>
	<body class="no-sectionBarre">
        <?php include("includes/header.php"); ?>
        <div class="div-contact container-fluid">
            <div class="row row-contact">
                <div class="col-md-6 reference info-adresse" style="background-image: url('/images/contact.jpg');">
                    <div class="adresse">
                        <h2>Piscine du Complexe Sportif Poseidon</h2>
                        <p>Avenue des Vaillants, 2 <br>1200 Woluwé St Lambert</p>
                    </div>
                </div>
                <div class="col-md-6 form-contact" style="background-color: white">
                    <svg class="svg-contact" viewBox="0 0 100 400">
                        <path d="M 40,0 L 100,0 L 100,400  L90,400 Z" class="path-article"></path>
                        <line x1="40" y1="-10" x2="88" y2="410" stroke="black" stroke-width="20"></line>
                    </svg>
                    <h3>Contact</h3>
                    <?php include('includes/form/message_form.php') ?>
                </div>
            </div>
        </div>
        <div class="div-map row-pad">
            <div id="map"></div>
        </div>
        <?php include("includes/footer.php"); ?>
        <?php include("includes/script.php"); ?>
        <script>
            function initMap() {
                var uluru = {lat: 50.843321, lng: 4.428405};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 18,
                    center: uluru
                });
                var marker = new google.maps.Marker({
                    position: uluru,
                    map: map
                });
            }
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-aaBXPZekwm1j8jxAgq6fY3qW6IkbN0k&callback=initMap">
        </script>
	</body>
</html>	