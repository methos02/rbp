<?php use App\Models\News;

include __DIR__.'/../includes/init.php';
$mailFactory = Mail::factory();
$Utils = Utils::factory();
$result['message'] = "";

if (!isset($_POST['mail']) || !$Utils -> checkMail($_POST['mail'])) {
    $result['message'] = Core_rbp::flash('danger', "L'adresse mail est invalide.");
}

if ($result['message'] == "" && empty($_POST['captcha'])) {
    $result['message'] = Core_rbp::flash('danger', "Signature Captcha invalide.");
}

if ($result['message'] == "") {
    $curl = curl_init(Core_rbp::URL_CAPTCHA . $_POST['captcha']);

    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);

    if (json_decode($response)->success == false) {
        $result['message'] = Core_rbp::flash('danger', "Signature Captcha invalide.");
    }
}

if ($result['message'] == "") {
    $mail = $mailFactory->getMailNews($_POST['mail']);

    if (!empty($mail) && $mail['statut'] == News::MAIL_ACTIF) {
        $result['message'] = Core_rbp::flash('danger', "Votre adresse mail est déjà enregistré.", "Vérifiez vos spams ou contactez un entraineur.");
    }
}

if ($result['message'] == "") {
    if (!empty($mail) && $mail['statut'] == News::MAIL_SUPP) {
        $mailFactory->updateMailNews($_POST['mail'], News::MAIL_ACTIF);
    }

    if (empty($mail)) {
        $cle = md5(microtime(TRUE)*100000);
        $mailFactory->addMailNews($_POST['mail'], $cle);
    }

    $result['message'] = Core_rbp::flash('success', "Votre mail a été enregistré.", "A partir de maintenant, vous serez averti dès qu'une news est posté sur le site du R.B.P.");
}

echo json_encode($result);
