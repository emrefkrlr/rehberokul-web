<?php
    session_start();
    require 'PHPMailer/PHPMailerAutoload.php';
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $senderHost = "smtp.gmail.com";
        $senderTitle = $_POST['name']." ".$_POST['surname'];
        $senderEmail = "info@algorit.com.tr";
        $senderPassword = "CO2018_Algoritma!";
        $mailSubject = $_POST['subject']." | TR";

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = $senderHost;
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = $senderEmail;
        $mail->Password = $senderPassword;
        $mail->setFrom($senderEmail, $senderTitle);
        $mail->addAddress("info@algorit.com.tr");
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $mailSubject; 
        $mail->msgHTML("<b>Algorit.com.tr sitenizden yeni bir talep var!</b><br><br><b>Ad</b> : ".$_POST['name']."<br><b>Soyad:</b> : ".$_POST['surname']."<br>"."<b>E-Posta</b> : ".$_POST['email']."<br>"."<b>Telefon</b> : ".$_POST['phone']."<br>"."<b>İçerik</b> : ".$_POST['message']);
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
?>