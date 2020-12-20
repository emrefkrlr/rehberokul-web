<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
function sendTestEmail($sent_to, $icerik, $baslik, $adres, $sifre) {

    define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
    require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
    require_once('../php/Forms/Classes/EmailOperations.php');
    require_once('../php/Classes/MysqliDb.php');

    $emailOps = new EmailOperations;

    $dbtatus = true;

    if ($dbtatus) {
        $senderHost = gethostbyname("mail.rehberokul.com");
        $senderHostPort = 587;
        $senderTitle = "Rehber Okul";
        $senderEmail = $adres;
        $senderPassword = $sifre;
        $mailSubject = "Rehber Okul - ".$baslik;;

        $receiverEmail = $sent_to;

        $mailHtmlContent = $icerik;

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
        }
    }
//        date_default_timezone_set('Europe/Istanbul');
//        require 'PHPMailer/PHPMailerAutoload.php';
//        //sumbission data
//        $ipaddress = $_SERVER['REMOTE_ADDR'];
//        $date = date('d/m/Y');
//        $time = date('H:i:s');
//
//        //form data
//
//        $subject = "Rehber Okul - ".$baslik;
//        $message = $icerik;
//
//        //Create a new PHPMailer instance
//        $mail = new PHPMailer;
//        //Tell PHPMailer to use SMTP
//        $mail->isSMTP();
//        $mail->CharSet = 'utf-8';
//        //Enable SMTP debugging
//        // 0 = off (for production use)
//        // 1 = client messages
//        // 2 = client and server messages
//        $mail->SMTPDebug = 0;
//        //Ask for HTML-friendly debug output
//        $mail->Debugoutput = 'html';
//        //Set the hostname of the mail server
//        $mail->Host = gethostbyname("mail.rehberokul.com");
//        $mail->From = $adres;
//        // use
//        // $mail->Host = gethostbyname('smtp.gmail.com');
//        // if your network does not support SMTP over IPv6
//        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
//        $mail->Port = 587;
//        //Set the encryption system to use - ssl (deprecated) or tls
//        $mail->SMTPSecure = 'tls';
//        //Whether to use SMTP authentication
//        $mail->SMTPAuth = true;
//        $mail->SMTPOptions = array(
//            'ssl' => array(
//                'verify_peer' => false,
//                'verify_peer_name' => false,
//                'allow_self_signed' => true
//            )
//        );
//        //Username to use for SMTP authentication - use full email address for gmail
//        $mail->Username = $adres;
//        //Password to use for SMTP authentication
//        $mail->Password = $sifre;
//        //Set who the message is to be sent from
//        $mail->setFrom($adres);
//        //Set an alternative reply-to address
//        $mail->addReplyTo($adres);
//        //Set who the message is to be sent to
//        $mail->addAddress($sent_to); // reply to aynı zamanda kime gönderildiği
//        //Set the subject line
//        $mail->Subject = $subject;
//        //Read an HTML message body from an external file, convert referenced images to embedded,
//        //convert HTML into a basic plain-text alternative body
//        $mail->msgHTML($message);
//        //Replace the plain text body with one created manually
//        $mail->AltBody = 'Bu bir test mailidir!';
//        //send the message, check for errors
//        if (!$mail->send()) {
//            echo "Mailer Error: " . $mail->ErrorInfo;
//        } else {
//            echo "Message sent!";
//        }
    }

    function sendMail ($sent_to, $icerik, $baslik, $adres, $sifre) {

        date_default_timezone_set('Europe/Istanbul');
        require 'PHPMailer/PHPMailerAutoload.php';
        //sumbission data
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $date = date('d/m/Y');
        $time = date('H:i:s');

        //form data

        $subject = "Rehber Okul - ".$baslik;
        $message = $icerik;

        foreach($sent_to as $email_address) {
            //Create a new PHPMailer instance
            $mail = new PHPMailer;
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = gethostbyname("mail.rehberokul.com");
            $mail->From = $adres;
            // use
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // if your network does not support SMTP over IPv6
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;
            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = $adres;
            //Password to use for SMTP authentication
            $mail->Password = $sifre;
            //Set who the message is to be sent from
            $mail->setFrom($adres);
            //Set an alternative reply-to address
            $mail->addReplyTo($adres);
            //Set who the message is to be sent to
            $mail->addAddress($email_address); // reply to aynı zamanda kime gönderildiği
            //Set the subject line
            $mail->Subject = $subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($message);
            //Replace the plain text body with one created manually
            $mail->AltBody = 'Bu bir test mailidir!';
            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error2: " . $mail->ErrorInfo;
            } else {
                echo "Message sent2!";
            }
        }

    }



