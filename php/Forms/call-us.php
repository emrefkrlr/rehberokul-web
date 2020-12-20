<?php
//ini_set('display_errors', 1);
//    ini_set('display_startup_errors', 1);
//    error_reporting(E_ALL);
session_start();
define("INFOSECVAL", "e057857db2cef2bdb5d89fa91505d499bd87d975");
require 'PHPMailer/PHPMailerAutoload.php';
require_once('Classes/EmailOperations.php');
require_once('../Classes/MysqliDb.php');
$dbOps = new MysqliDb('localhost', 'rehberok_web_user', 'P(ie*igC*juoRehberO', 'rehberok_web_db');
$emailOps = new EmailOperations;
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if (!((isset($post['note']) && $post['note'] != '') &&
    (isset($post['school_type']) && $post['school_type'] != '') &&
    (isset($post['email']) && $post['email'] != '') &&
    (isset($post['phone']) && $post['phone'] != '') &&
    (isset($post['full_name']) && $post['full_name'] != ''))) {
    echo 0;
    exit();
}

$full_name = $emailOps->convertTextToTitleCase($post['full_name']);
$email = $post['email'];
$phone = $post['phone'];
$note = $post['note'];
$school_type = $post['school_type'] == 1 ? 'Anaokulu veya Kreş' : ($post['school_type'] == 2 ? 'İlkokul' : $post['school_type'] == 3 ? 'Ortaokul' : 'Lise' ) ;

$isSpam = $emailOps->spamSecurity(array($full_name, $email, $phone, $school_type));
$dbOpStatus = 0;
if ($isSpam) {
    $dbOpStatus = true;
}

if ($dbOpStatus) {
    $senderHost = "mail.rehberokul.com";
    $senderHostPort = 587;
    $senderTitle = $full_name;
    $senderEmail = "no-reply@rehberokul.com";
    $senderPassword = "noreply+47712116";
    $mailSubject = "Yeni Talep Var!";

    $receiverEmail = 'talep@rehberokul.com';

    $mailHtmlContent = '<div class="email-tem" style="background: #efefef;width: 100%;position: relative;overflow: hidden;">
<div class="email-tem-inn" style="margin: 0 auto;padding: 50px;background: #ffffff;">
<div class="email-tem-main" style="background: #fdfdfd;box-shadow: 0px 10px 24px -10px rgba(0, 0, 0, 0.8);margin-bottom: 50px;border-radius: 10px;">
<div class="email-tem-head" style=" width: 100%;background: #006df0 url(\'https://www.rehberokul.com/images/mail/bg.png\') repeat;padding: 50px;box-sizing: border-box;border-radius: 5px 5px 0px 0px;">
<h2 style="color: #fff;font-size: calc(16px - 0.1em);text-transform: capitalize;"><img style="float: left;padding-right: 25px;width: calc(90px + 0.5em);;" src="https://www.rehberokul.com/images/mail/letter.png" alt=""></h2>
</div>
<div class="email-tem-body" style="padding-top: 50px; padding-bottom: 50px;padding-left: 20px;">
<h3 style="margin-bottom: 25px; width: 100%;">' . $mailSubject . '</h3>
<p style="width: 100%;">İsim : ' . $full_name . '</p>
<p style="width: 100%;">Okul Türü : '. $school_type .'  </p>
<p style="width: 100%;">Not : ' . $note . '</p>
<p style="width: 100%;">Telefon : ' . $phone . '</p>
</div>
</div>
<div class="email-tem-foot" style="text-align: center;margin-left: -50px;">
<h4>Takipte Kal</h4>
<ul style="position: relative;overflow: hidden;margin:auto;display: table;margin-bottom: 18px;margin-top: 25px;">
<li style=" float: left;display: inline-block;padding-right: 20px; "><a href="https://www.facebook.com/rehberokull/" target="_blank"><img src="https://www.rehberokul.com/images/mail/s1.png" alt=""></a></li>
<li style=" float: left;display: inline-block;padding-right: 20px;"><a href="https://www.twitter.com/rehberokul/" target="_blank"><img src="https://www.rehberokul.com/images/mail/s2.png" alt=""></a></li>
<li style=" float: left;display: inline-block;padding-right: 20px;"><a href="https://www.instagram.com/rehberokul/" target="_blank"><img src="https://www.rehberokul.com/images/mail/s6.png" alt=""></a></li>
</ul>
<p style="margin-bottom: 0px;padding-top: 5px;font-size: 10px;">Rehber Okul</p>
<p style="margin-bottom: 0px;padding-top: 5px;font-size: 10px;">Copyright ©️ 2020 Rehber Okul | Tüm Hakları Saklıdır.</p>
</div></div></div>';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = $senderHost;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $senderHostPort;
    $mail->SMTPAuth = true;
    // Bu kısmı ben ekledim
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->Username = $senderEmail;
    $mail->Password = $senderPassword;
    $mail->setFrom($email, $senderTitle);
    $mail->addAddress($receiverEmail);
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $mailSubject;
    $mail->msgHTML($mailHtmlContent);
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        exit();
    }
    echo 1;
    exit();

} else {
    echo -1;
    exit();
}
