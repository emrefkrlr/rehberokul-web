<?php
//ini_set('display_errors', 1);
//    ini_set('display_startup_errors', 1);
//    error_reporting(E_ALL);
    session_start();
    define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
    require 'PHPMailer/PHPMailerAutoload.php';
    require_once('Classes/EmailOperations.php');
    require_once('../Classes/MysqliDb.php');
    $dbOps = new MysqliDb('localhost', 'rehberok_web_user', 'P(ie*igC*juoRehberO', 'rehberok_web_db');
    $emailOps = new EmailOperations;

    if(!((isset($_POST['first_name']) && trim($_POST['first_name'])!='' )
        && (isset($_POST['last_name']) && trim($_POST['last_name'])!='' )
        && (isset($_POST['email']) && trim($_POST['email'])!='' )
        && (isset($_POST['phone']) && trim($_POST['phone'])!='' )
        && (isset($_POST['user_role']) && trim($_POST['user_role'])!='' )
        && (isset($_POST['password']) && trim($_POST['password'])!='' )
        && (isset($_POST['password_verification']) && trim($_POST['password_verification'])!='' )
        && (isset($_POST['kvkk_control'])))) {
        echo 0;
        exit();
    }

    $first_name = $emailOps->convertTextToTitleCase($_POST['first_name']);
    $last_name = $emailOps->convertTextToTitleCase($_POST['last_name']);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $user_role = $_POST['user_role'];
    $userLink = $emailOps->convertPermalink($email);
    $userToken = $emailOps->createToken($email);
    $password = $emailOps->securePassword($_POST['password']);
    $passwordVerification = $emailOps->securePassword($_POST['password_verification']);

    if($password != $passwordVerification) {
        echo 99;
        exit();
    }

    $buttonRedirectLink = "https://www.rehberokul.com/hesap-dogrulama/".$userLink."/".$userToken;

    $isSpam = $emailOps->spamSecurity(array($first_name, $last_name, $email, $phone, $password));
    $dbOpStatus = 0;
    if($isSpam) {
        $userData = Array ("first_name" => $first_name,
                        "last_name" => $last_name,
                        "email" => $email,
                        "phone" => $phone,
                        "role_id" => $user_role,
                        "password" => $password,
                        "link" => $userLink,
                        "creation_date" => $dbOps->now(),
                        "token" => $userToken,
                        "is_online" => 0,
                        "is_active" => 0
        );
        $dbOpStatus = $dbOps->insert('user', $userData);
    }

    if ($dbOpStatus) {
        $senderHost = gethostbyname("mail.rehberokul.com");
        $senderHostPort = 587;
        $senderTitle = "Rehber Okul";
        $senderEmail = "no-reply@rehberokul.com";
        $senderPassword = "noreply+47712116";
        $mailSubject = "E-Posta Hesabını Doğrula";

        $receiverEmail = $email;

        $mailHtmlContent = '<div class="email-tem" style="background: #efefef;width: 100%;position: relative;overflow: hidden;">
<div class="email-tem-inn" style="margin: 0 auto;padding: 50px;background: #ffffff;">
<div class="email-tem-main" style="background: #fdfdfd;box-shadow: 0px 10px 24px -10px rgba(0, 0, 0, 0.8);margin-bottom: 50px;border-radius: 10px;">
<div class="email-tem-head" style=" width: 100%;background: #006df0 url(\'https://www.rehberokul.com/images/mail/bg.png\') repeat;padding: 50px;box-sizing: border-box;border-radius: 5px 5px 0px 0px;">
<h2 style="color: #fff;font-size: calc(16px - 0.1em);text-transform: capitalize;"><img style="float: left;padding-right: 25px;width: calc(90px + 0.5em);;" src="https://www.rehberokul.com/images/mail/letter.png" alt=""></h2>
</div>
<div class="email-tem-body" style="padding-top: 50px; padding-bottom: 50px;padding-left: 20px;">
<h3 style="margin-bottom: 25px; width: 100%;">'.$mailSubject.'</h3>
<p style="width: 100%;">Merhaba '.$first_name.',</p>
<p style="width: 100%;">Aşağıdaki butona tıklayarak e-posta adresinizi doğrulayabilirsiniz.</p>
<a style="background: #006df0;color: #fff;padding: 12px;border-radius: 2px;margin-top: 15px;position: relative;display: inline-block;" href="'.$buttonRedirectLink.'">Doğrula</a>
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
        $mail->setFrom($senderEmail, $senderTitle);
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
?>