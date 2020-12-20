<?php
function seflinkGenerator($text)
{
    if (preg_match('/[اأإء-ي]/ui', $text)) {
        $text = md5($text);
        return $text;
    } else {
        $seflink = generateSeflink($text);
        return $seflink;
    }

}

function generateSeflink($str, $options = array()) {
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if((isset($post['demandUserId']) && $post['demandUserId'] != '')
    && (isset($post['demandId']) && $post['demandId'] != '')) {
    require_once('../php/Core.php');
    try {

        if(isset($_SESSION['user_data']) && isset($_SESSION['is_logged_in'])) {
            if($_SESSION['user_data']['role'] == 'Kurum Sahibi' ) {
                $userId = $_SESSION['user_data']['user_id'];
            } else {
                echo 99;
                exit();
            }

        } else {
            echo 99;
            exit();
        }


        $demandInterestData = Array (
            'user_id' => $userId,
            'demand_id' => $post['demandId']
        );
        $db->insert('demands_interested', $demandInterestData);
        $db->insert('demand_schools_interested', $demandInterestData);
        if($post['demandUserId'] != 0) { // Sistemde kayıtlı olan bir veli ise notification gönder
            $db->where('id', $post['demandId']);
            $demand = $db->getOne('demand');
            $notificationData = Array (
                'school_id' => $demand['school_id'],
                'user_id' => $demand['user_id'],
                'school_type' => $demand['school_type'],
                'interested_user' => $userId,
                'type' => '0',
                'title' => 'Talebinizle İlgilenildi! ',
                'content' => 'talebinizle ilgilendi!',
                'link' => $demand['link']
            );
            $db->insert('all_user_notifications', $notificationData);

            require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
            require_once('../php/Forms/Classes/EmailOperations.php');
            $emailOps = new EmailOperations;
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $db->where('id', 4); // Veli Talep
            $veli_talep_email = $db->getOne('email_template');

            $db->where('id', $_SESSION['user_data']['user_id']);
            $user = $db->getOne('user');

            $dbtatus = true;

            if ($dbtatus) {
                $senderHost = gethostbyname("mail.rehberokul.com");
                $senderHostPort = 587;
                $senderTitle = "Rehber Okul";
                $senderEmail = "no-reply@rehberokul.com";
                $senderPassword = "noreply+47712116";
                $mailSubject = "Talebinizle İlgilenen Kurumlar Var!";

                $receiverEmail = $user['email'];

                $mailHtmlContent = htmlspecialchars_decode($veli_talep_email['content']);

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

        } else { // DB'deki demand satırındaki email adresine mail yolla
            require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
            require_once('../php/Forms/Classes/EmailOperations.php');


            $emailOps = new EmailOperations;
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $db->where('id', $post['demandId']);
            $demand = $db->getOne('demand');


            $db->where('user_id', $userId);
            $ownerSchools = $db->get('school_owner');
            if($db->count > 0) {
                $result = '';
                $counter = 0;
                foreach ($ownerSchools as $ownerSchool) {
                    $db->where('id', $ownerSchool['school_id']);
                    $db->where('state', 2);
                    $school = $db->getOne('school');
                    if($counter < count($ownerSchools) - 1) {
                        $result .= $school['name'].', ';
                    } else {
                        $result .= $school['name'];
                    }
                }


            } else {
                $db->where('id', $userId);
                $user = $db->getOne('user');
                $result = $user['email'].' mail adresine sahip kurum sahibi ';
            }

            $full_name = $emailOps->convertTextToTitleCase($demand['full_name']);
            $email = $demand['email'];
            $phone = $demand['phone'];

            $isSpam = $emailOps->spamSecurity(array($full_name, $email, $phone));
            $dbtatus = 0;
            if ($isSpam) {
                $dbtatus = true;
            }

            if ($dbtatus) {
                $senderHost = gethostbyname("mail.rehberokul.com");
                $senderHostPort = 587;
                $senderTitle = "Rehber Okul";
                $senderEmail = "no-reply@rehberokul.com";
                $senderPassword = "noreply+47712116";
                $mailSubject = "Talebinizle İlgilenildi!";

                $receiverEmail = $email;

                $mailHtmlContent = '<div class="email-tem" style="background: #efefef;width: 100%;position: relative;overflow: hidden;">
<div class="email-tem-inn" style="margin: 0 auto;padding: 50px;background: #ffffff;">
<div class="email-tem-main" style="background: #fdfdfd;box-shadow: 0px 10px 24px -10px rgba(0, 0, 0, 0.8);margin-bottom: 50px;border-radius: 10px;">
<div class="email-tem-head" style=" width: 100%;background: #006df0 url(\'https://www.rehberokul.com/images/mail/bg.png\') repeat;padding: 50px;box-sizing: border-box;border-radius: 5px 5px 0px 0px;">
<h2 style="color: #fff;font-size: calc(16px - 0.1em);text-transform: capitalize;"><img style="float: left;padding-right: 25px;width: calc(90px + 0.5em);;" src="https://www.rehberokul.com/images/mail/letter.png" alt=""></h2>
</div>
<div class="email-tem-body" style="padding-top: 50px; padding-bottom: 50px;padding-left: 20px;">
<h3 style="margin-bottom: 25px; width: 100%;">' . $mailSubject . '</h3>
<p style="width: 100%;">Merhaba ' . $full_name . ',</p>
<p style="width: 100%;">'. $result .'  talebinizle ilgilendi. </p>
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
                echo 2;
                exit();

            }
        }
        echo 1;
    }catch (Exception $e) {
        echo 0;
    }
}