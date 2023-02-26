<?php include __DIR__.'/../includes/init.php';
$adherentFactory = Adherent::factory();
$sectionFactoy = Section::factory();
$saisonFactory = Saison::factory();
$form = Form::factoryForm();

$id_saison = $saisonFactory->saisonActive(false);
$saisons = $adherentFactory->getSaisonByAdherent();
$arrSaiIdToSaison = $saisonFactory->idToSaison($saisons);
$id_adherents = $adherentFactory -> getAdherentsBySaison($id_saison, null);
$adherents = $adherentFactory -> getAdherentSaison($id_adherents, ['multi' => true]);
$adherents = $adherentFactory->setsParams($adherents);

$result['tableau'] = Core_rbp::view('includes/table/adherentsTable', ['adherents' => $adherents, 'id_saison' => $id_saison, 'saisonActive' => Saison::factory()->saisonActive(false)]);
$result['options'] = $form->defineOptions($arrSaiIdToSaison, ['default' => $id_saison]);

echo json_encode($result);