<?php
class PaymentModel extends DBOperation {
    public static $roles;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function getUser($user_id) {
        $this->findByColumn('user', 'id', $user_id);
        $user = $this->single();
        return $user;
    }

    private function convertMonthToTurkishCharacter($date){
        $aylar = array(
            'January'    =>    'Ocak',
            'February'    =>    'Şubat',
            'March'        =>    'Mart',
            'April'        =>    'Nisan',
            'May'        =>    'Mayıs',
            'June'        =>    'Haziran',
            'July'        =>    'Temmuz',
            'August'    =>    'Ağustos',
            'September'    =>    'Eylül',
            'October'    =>    'Ekim',
            'November'    =>    'Kasım',
            'December'    =>    'Aralık',
            'Monday'    =>    'Pazartesi',
            'Tuesday'    =>    'Salı',
            'Wednesday'    =>    'Çarşamba',
            'Thursday'    =>    'Perşembe',
            'Friday'    =>    'Cuma',
            'Saturday'    =>    'Cumartesi',
            'Sunday'    =>    'Pazar',
            'Jan' => 'Oca',
            'Feb' => 'Şub',
            'Mar' => 'Mar',
            'Apr' => 'Nis',
            'May' => 'May',
            'Jun' => 'Haz',
            'Jul' => 'Tem',
            'Aug' => 'Ağu',
            'Sep' => 'Eyl',
            'Oct' => 'Eki',
            'Nov' => 'Kas',
            'Dec' => 'Ara'

        );
        return  strtr($date, $aylar);
    }



    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('payment');
            $this->orderBy('payment_time', 'desc');
            $payments = $this->resultSet();
            return $payments;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewApprove($reference_no_and_school_id) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $ref_and_id = explode("-", $reference_no_and_school_id);
            $reference_no = $ref_and_id[0];
            $school_id = $ref_and_id[1];
            $this->findByColumn('payment', 'reference_no', $reference_no);
            $this->addAndClause('school_id', $school_id);
            $payment = $this->single();
            if($payment) {
                return $payment;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewCancel($reference_no_and_school_id) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $ref_and_id = explode("-", $reference_no_and_school_id);
            $reference_no = $ref_and_id[0];
            $school_id = $ref_and_id[1];
            $this->findByColumn('payment', 'reference_no', $reference_no);
            $this->addAndClause('school_id', $school_id);
            $payment = $this->single();
            if($payment) {
                return $payment;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }


    public function approve($reference_no_and_school_id) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();

                    $ref_and_id = explode("-", $reference_no_and_school_id);
                    $reference_no = $ref_and_id[0];
                    $school_id = $ref_and_id[1];
                    // Set Priority +10 Of School
                    $this->findByColumn('school', 'id', $school_id);
                    $this->addAndClause('state', 2);
                    $school = $this->single();
                    $this->setWhereConditionForUpdate('id', $school_id);
                    $this->updateByColumn('school', array(
                        'priority' => $school['priority']+10
                    ), $school_id);


                    // Set Points 4.0 Of School
                    $this->setWhereConditionForUpdate('id', $school_id);
                    $this->updateByColumn('school', array(
                        'package' => 'Premium',
                        'points' => 4.0
                    ), $school_id);


                    $date = new DateTime('now'); // Start Time

                    // Set Package Duration Dates
                    $this->setWhereConditionForUpdate('reference_no', $reference_no);
                    $this->queryString .= ' AND school_id='.$school_id;
                    $this->updateByColumn('payment', array(
                        'start_date' => $date->format('Y-m-d H:i:s'),
                        'end_date' => $date->modify('+1 year')->format('Y-m-d H:i:s'), // End Times
                        'state' => 2 // Set State 2 Approved
                    ), $reference_no);

                    $this->findByColumn('payment', 'reference_no', $reference_no);
                    $this->addAndClause('state', 2, 'NOT');
                    $notApprovedAllYet = $this->resultSet();

                    if(count($notApprovedAllYet) <= 0) {
                        $this->findByColumn('payment', 'reference_no', $reference_no);
                        $this->addAndClause('state', 2);
                        $approvedAll = $this->resultSet();
// DB'deki demand satırındaki email adresine mail yolla
                        define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
                        require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
                        require_once('../php/Forms/Classes/EmailOperations.php');
                        require_once('../php/Classes/MysqliDb.php');

                        $db = new MysqliDb('localhost', 'rehberok_web_user', 'P(ie*igC*juoRehberO', 'rehberok_web_db');
                        $emailOps = new EmailOperations;

                        $db->where('id', $approvedAll[0]['user_id']);
                        $user = $db->getOne('user');

                        $full_name = $emailOps->convertTextToTitleCase($user['first_name'].' '.$user['last_name']);
                        $email = $user['email'];
                        $phone = $user['phone'];

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
                            $mailSubject = "Premium Paket Satın Alımı Başarılı!";

                            $receiverEmail = $email;

                            $mailHtmlContent = '<div class="email-tem" style="background: #efefef;width: 100%;position: relative;overflow: hidden;">
<div class="email-tem-inn" style="margin: 0 auto;padding: 50px;background: #ffffff;">
<div class="email-tem-main" style="background: #fdfdfd;box-shadow: 0px 10px 24px -10px rgba(0, 0, 0, 0.8);margin-bottom: 50px;border-radius: 10px;">
<div class="email-tem-head" style=" width: 100%;background: #006df0 url(\'https://www.rehberokul.com/images/mail/bg.png\') repeat;padding: 50px;box-sizing: border-box;border-radius: 5px 5px 0px 0px;">
<h2 style = "color: #fff;font-size: calc(16px - 0.1em);text-transform: capitalize;" ><img style = "float: left;padding-right: 25px;width: calc(90px + 0.5em);;" src = "https://www.rehberokul.com/images/mail/letter.png" alt = "" ></h2 >
</div >
<div class="email-tem-body" style = "padding-top: 50px; padding-bottom: 50px;padding-left: 20px;" >
<h3 style = "margin-bottom: 25px; width: 100%;" > Premium Paket Satın Alımı Başarılı </h3 >
<p style = "width: 100%;color: #000000;font-weight: bold;" > Sayın '.$full_name.' </p >
<p style = "width: 100%;" > Tebrikler, aşağıda detayı bulunan kurumlar için premium paket satın alımınız tamamlanmıştır .</p >
<p style = "width: 100%;" ><b > rehberokul . com</b > <br > E - Posta: bilgi@rehberokul . com <br ></p ><div style = "background-color: #f5cd6629;width: 100%;" >
	<br >
    <table style = "text-align: left;width:100%;" >
  <tbody ><tr >
    <th style = "padding-left: 15px;" > İşlem Tarihi </th >
    <td > '.$this->convertMonthToTurkishCharacter($date->format('d-F-Y')).' </td >
    
  </tr >
  <tr >
    <th style = "padding-left: 15px;" > Paket Sona Erme Tarihi </th >
    <td > '.$this->convertMonthToTurkishCharacter($date->modify('+1 year')->format('d-F-Y')).' </td >
  </tr >
</tbody >
</table >
<br >
</div ><div style = "width: 100%;" >
	<br ><br ><br >
    <table style = "text-align: left; width:100%;" >
  <tbody >
  	<tr style = "
    border-bottom: 1pt solid black;
" >
    <th style = "padding-left: 15px;" > KURUM</th >
    <th > KURUM TİPİ </th >
    <th > SÜRE</th >
    <th > TUTAR</th >
	</tr >';
                            foreach ($approvedAll as $record) {
                                $db->where('id', $record['school_id']);
                                $school_record = $db->getOne('school');
                                $mailHtmlContent .= '<tr style = "border-bottom: 1pt solid black;">';
                                $mailHtmlContent .= '<td style = "padding-left: 15px;" > '.$school_record['name'].' </td >';
                                $mailHtmlContent .= $school_record['type'] == 1 ? '<td>Anaokulu veya Kreş</td>' : ($school_record['type'] == 2 ? '<td>İlkokul</td>' : ($school_record['type'] == 3 ? '<td>Ortaokul</td>' : '<td>Lise</td>'));
                                $mailHtmlContent .= '<td > 1 yıl </td >';
                                $mailHtmlContent .= $school_record['type'] == 1 ? '<td style="font-weight: bold;">'.number_format(2500 , 2, ',', '.').' TL</td>' : '<td style="font-weight: bold;">'.number_format(4500 , 2, ',', '.').' TL</td >';
                                $mailHtmlContent .= '</tr >';
                            }


                            $mailHtmlContent .= '</tbody >
</table >
<br ><br ><br >
</div ><div style = "width: 100%;background-color: #f5cd6629;" >
	<br ><br ><br >
    <table style = "text-align: left; width: 90%;margin-left: 5%;" >
  <tbody >
  	<tr style = "border-bottom: 1pt solid black; padding-left: 15px;" >
    <th > İŞLEM ÖZETİ </th >
    <th > TUTAR</th >
	</tr >
  <tr style = "border-bottom: 1pt solid black; padding-left: 15px;" >
    <td > Paket Tutarı </td >
    <td style = "color: #000000;font-weight: bold;" > '.number_format(+$approvedAll[0]['amount'] , 2, ',', '.').' TL </td >
  </tr >
  <tr style = "border-bottom: 1pt solid black; padding-left: 15px;" >
    <td > KDV Tutarı </td >
    <td style = "color: #d60000;font-weight: bold;" > '.number_format(+$approvedAll[0]['kdv'] , 2, ',', '.').' TL </td >
  </tr >
  <tr style = "border-bottom: 1pt solid black; padding-left: 15px;" >
    <td > Rehber Okul İndirimi </td >
    <td style = "color: #009a1a;font-weight: bold;" > -'.number_format(+$approvedAll[0]['discount'] , 2, ',', '.').' TL </td >
  </tr >
  <tr style = "border-bottom: 1pt solid black; padding-left: 15px;" >
    <td > Ödenen Tutar </td >
    <td style = "color: #000000;font-weight: bold;" > '.number_format(+$approvedAll[0]['price'] , 2, ',', '.').' TL </td >
  </tr >
</tbody >
</table >
<br ><br ><br >
</div >
</div >
</div >
<div class="email-tem-foot" style = "text-align: center;margin-left: -50px;" >
<h4 > Takipte Kal </h4 >
<ul style = "position: relative;overflow: hidden;margin:auto;display: table;margin-bottom: 18px;margin-top: 25px;" >
<li style = " float: left;display: inline-block;padding-right: 20px; " ><a href = "https://www.facebook.com/rehberokull/" target = "_blank" ><img src = "https://www.rehberokul.com/images/mail/s1.png" alt = "" ></a ></li >
<li style = " float: left;display: inline-block;padding-right: 20px;" ><a href = "https://www.twitter.com/rehberokul/" target = "_blank" ><img src = "https://www.rehberokul.com/images/mail/s2.png" alt = "" ></a ></li >
<li style = " float: left;display: inline-block;padding-right: 20px;" ><a href = "https://www.instagram.com/rehberokul/" target = "_blank" ><img src = "https://www.rehberokul.com/images/mail/s6.png" alt = "" ></a ></li >
</ul >
<p style = "margin-bottom: 0px;padding-top: 5px;font-size: 10px;" > Rehber Okul </p >
<p style = "margin-bottom: 0px;padding-top: 5px;font-size: 10px;" > Copyright ©️ 2020 Rehber Okul | Tüm Hakları Saklıdır .</p >
</div ></div ></div >';
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
                    }




                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Ödeme Onaylandı!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'payment";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Onaylama Başarısız!'.$e->getMessage(), 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'payment";</script>';
        }
        return;
    }

    public function cancel($reference_no_and_school_id) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $ref_and_id = explode("-", $reference_no_and_school_id);
                    $reference_no = $ref_and_id[0];
                    $school_id = $ref_and_id[1];

                    // Set State 3 (Cancelled)
                    $this->setWhereConditionForUpdate('reference_no', $reference_no);
                    $this->queryString .= ' AND school_id='.$school_id;
                    $this->updateByColumn('payment', array(
                        'state' => 3
                    ), $reference_no);

                    $this->databaseHandler->commit();
                    Message::setMessage('Ödeme İptal Edildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'payment";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'payment";</script>';
        }
        return;
    }


}

