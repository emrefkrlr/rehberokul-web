<?php
class DemandsModel extends DBOperation {
    public static $roles;
    public static $cities;
    public static $towns;
    public static $subtowns;
    public static $schools;
    public static $parents;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    private function isPremium($school_type) {
        $this->findByColumn('payment', 'user_id', $_SESSION['user_data']['user_id']);
        $this->addAndClause('school_type', $school_type);
        $this->addAndClause('state', 2);//Onaylı
        $this->orderBy('id', 'DESC'); // En son ödeme
        $payments = $this->single();
        if(strtotime($payments['end_date']) < time()) {
            return false;
        } else {
            return true;
        }
    }

    private function isPremiumSpesific($school_id) {
        $this->findByColumn('payment', 'user_id', $_SESSION['user_data']['user_id']);
        $this->addAndClause('school_id', $school_id);
        $this->addAndClause('state', 2);//Onaylı
        $this->orderBy('id', 'DESC'); // En son ödeme
        $payments = $this->single();
        if(strtotime($payments['end_date']) < time()) {
            return false;
        } else {
            return true;
        }
    }

    public function hideDetails($str) {
        if(!$this->isPremium()) {
            if(empty($str)) {
                return 'xxxxxxxxxx';
            } else {
                $firstTwoLetters = mb_substr($str,0,2, 'utf-8');
                for($i = 0; $i < 9; $i++) {
                    $firstTwoLetters = $firstTwoLetters.'x';
                }
                return $firstTwoLetters;
            }
        } else {
            return $str;
        }

    }

    public function hideAllDetails($str) {
        if(empty($str)) {
            return 'xxxxxxxxxx';
        } else {
            $firstTwoLetters = mb_substr($str,0,2, 'utf-8');
            for($i = 0; $i < 9; $i++) {
                $firstTwoLetters = $firstTwoLetters.'x';
            }
            return $firstTwoLetters;
        }
    }


    public function getSchoolType($type) {
        $this->findByColumn('school_type', 'id', $type);
        $schoolType  = $this->single();
        return $schoolType['name'];
    }

    public function getSchoolTypeBySchoolId($school_id) {
        $this->findByColumn('school', 'id', $school_id);
        $school = $this->single();
        $this->findByColumn('school_type', 'id', $school['type']);
        $schoolType  = $this->single();
        return $schoolType['name'];
    }

    public function getRoleId($user_id) {
        $this->findByColumn('user', 'id', $user_id);
        $user = $this->single();
        if($user) {
            return $user['role_id'];
        }
        return 0;
    }

    public function getUser($user_id) {
        $this->findByColumn('user', 'id', $user_id);
        $user = $this->single();
        return $user;
    }

    public function getCity($sehir_key) {
        $this->findByColumn('city', 'sehir_key',$sehir_key);
        $city = $this->single();
        return $city['name'];
    }

    public function getSchool($school_id) {
        $this->findByColumn('school', 'id',$school_id);
        $school = $this->single();
        return $school['name'];
    }

    public function getTown($ilce_key) {
        $this->findByColumn('town', 'ilce_key',$ilce_key);
        $town = $this->single();
        return $town['name'];
    }

    public function getInterestedSchools($demand_id) {
        $this->findByColumn('demand_schools_interested', 'demand_id', $demand_id);
        $this->groupBy('user_id');
        $this->groupByAddColumn('demand_id');
        $interested_schools = $this->resultSet();

        $this->findByColumn('demand', 'id', $demand_id);
        $demand = $this->single();

        $result = '';
        foreach($interested_schools as $row) {
            $this->findByColumn('school_owner', 'user_id', $row['user_id']);
            $ownerSchools = $this->resultSet();
            if(count($ownerSchools) > 0) {
                foreach ($ownerSchools as $school) {
                    $this->findByColumn('school', 'id', $school['school_id']);
                    $this->addAndClause('state', 2);
                    $cSchool = $this->single();
                    if($demand['school_type'] == $cSchool['type']) {
                        $result = $result.'<br>'.$cSchool['name'];
                    }

                }
            }
        }
        return $result;

    }

    public function setCities() {
        $this->findAll('city');
        $this->orderBy('is_listed', 'desc');
        self::$cities = $this->resultSet();
    }

    public function setTowns($sehir_key) {
        $this->findByColumn('town', 'ilce_sehirkey', $sehir_key);
        self::$towns = $this->resultSet();
    }

    public function setSubTowns($ilce_key) {
        $this->findByColumn('subtown', 'mahalle_ilcekey', $ilce_key);
        self::$subtowns = $this->resultSet();
    }

    public function setParents() {
        $this->findByColumn('user', 'role_id', 3);
        $parents = $this->resultSet();
        self::$parents = $parents;

    }

    public function setSchools() {
        $this->findAll('school');
        self::$schools = $this->resultSet();
    }

    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $schoolIds = $this->resultSet();
            $demandsResult = array();
            foreach ($schoolIds as $schoolId) {
                $this->findByColumn('school', 'id', $schoolId['school_id']);
                $this->addAndClause('state', 2);
                $school = $this->single();
                $this->findByColumn('demand', 'ilce_key', $school['ilce_key']);
                $this->addOrClause('mahalle_key', $school['mahalle_key']);
                $this->having('state', 1);
                $this->addAndClause('is_active', 1);
                $this->orderBy('create_date', 'DESC');
                $demands = $this->resultSet();
                foreach($demands as $demand) {
                    $this->findByColumn('demands_interested', 'user_id', $_SESSION['user_data']['user_id']);
                    $this->addAndClause('demand_id', $demand['id']);
                    $interested_demand = $this->single();
                    if(!in_array($demand, $demandsResult) &&  !$interested_demand) {
                        $demandsResult[] = $demand;
                    }
                }
            }
            // Eğer hiç bölgesinde talep yoksa bütün onaylanmış talepleri getir
//            if(count($demandsResult) <= 0) {
//                $this->findByColumn('demand', 'state', 1);
//                $demandsResult = $this->resultSet();
//            }
            return $demandsResult;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function spesific() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $schoolIds = $this->resultSet();
            $demandsResult = array();
            foreach ($schoolIds as $schoolId) {
                $this->findByColumn('demand', 'school_id', $schoolId['school_id'] );
                $this->addAndClause('state', 1);
                $this->addAndClause('is_active', 1);
                $this->orderBy('create_date', 'DESC');
                $demands = $this->resultSet();
                foreach($demands as $demand) {
                    $this->findByColumn('demands_interested', 'user_id', $_SESSION['user_data']['user_id']);
                    $this->addAndClause('demand_id', $demand['id']);
                    $interested_demand = $this->single();
                    if(!in_array($demand, $demandsResult) &&  !$interested_demand) {
                        $demandsResult[] = $demand;
                    }
                }
            }
            return $demandsResult;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function interested() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('demands_interested', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('id', 'DESC');
            $interestedDemands = $this->resultSet();
            $demandsResult = array();
            foreach ($interestedDemands as $interestedDemand) {
                $this->findByColumn('demand', 'id', $interestedDemand['demand_id']);
                $demand = $this->single();
                $demandsResult[] = $demand;
            }
            return $demandsResult;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function interest($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            try {
                $this->findByColumn('demand', 'link', $link);
                $demand = $this->single();
                if($this->isPremium($demand['school_type'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->findByColumn('email_template', 'id', 4); // Veli Talep
                    $veli_talep_email = $this->single();

                    $this->count('demands_interested');
                    $this->where('demand_id', $demand['id']);
                    $interested_schools = $this->single();
                    $interested_schools_count = $interested_schools['total'];


                    // Eğer kurum sahibinin talepteki okul türüne ait okulu var ise işlemleri yap
                    $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
                    $schoolIds = $this->resultSet();
                    $count = 0 ;
                    foreach ($schoolIds as $schoolId) {
                        $this->findByColumn('school', 'id', $schoolId['school_id']);
                        $schoolC = $this->single();
                        if($demand['school_type'] == $schoolC['type']) {
                            $count++;
                        }
                    }

                    if($count == 0) {
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Taleple İlgilenebilmek İçin Talepteki Okul Türüne Ait Bir Okula Sahip Olmalısınız!', 'error');
                        echo '<script>window.location.href ="' . ROOT_URL . 'demands";</script>';
                        return;
                    }



                    if(($demand['quota'] != 'Sınır Yok' && $interested_schools_count < +$demand['quota']) || $demand['quota'] == 'Sınır Yok') {
                        $this->save('demands_interested',
                            array('user_id', 'demand_id'),
                            array($_SESSION['user_data']['user_id'], $demand['id']));


                        $this->save('demand_schools_interested',
                            array('user_id', 'demand_id'),
                            array($_SESSION['user_data']['user_id'], $demand['id'],));

                        if($demand['user_id'] != 0) {
                            $this->save('all_user_notifications',
                                array('school_id', 'user_id', 'school_type', 'interested_user', 'type', 'title', 'content', 'link'),
                                array($demand['school_id'], +$demand['user_id'], $demand['school_type'], $_SESSION['user_data']['user_id'], '0', 'Talebinizle İlgilenildi! ',
                                    'talebinizle ilgilendi!', $link));


                            // DB'deki demand satırındaki email adresine mail yolla
                            define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
                            require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
                            require_once('../php/Forms/Classes/EmailOperations.php');
                            require_once('../php/Classes/MysqliDb.php');

                            $db = new MysqliDb('localhost', 'rehberok_web_user', 'P(ie*igC*juoRehberO', 'rehberok_web_db');
                            $emailOps = new EmailOperations;

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

                        } else {
                            // DB'deki demand satırındaki email adresine mail yolla
                            define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
                            require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
                            require_once('../php/Forms/Classes/EmailOperations.php');
                            require_once('../php/Classes/MysqliDb.php');

                            $db = new MysqliDb('localhost', 'demosite_rehberokuluser', 'RHBR_okul_2020!', 'demosite_rehberokuldb');
                            $emailOps = new EmailOperations;


                            $db->where('user_id', $_SESSION['user_data']['user_id']);
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
                                $db->where('id', $_SESSION['user_data']['user_id']);
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
                                }
                            }

                        }
                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Taleple İlgilendiğiniz Veliye İletilmiştir!', 'success');
                        echo '<script>window.location.href ="' . ROOT_URL . 'demands/interested";</script>';
                    } else {
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Talep Belirlenen Kotaya Ulaştığından Taleple İlgilenemezsiniz!', 'error');
                        echo '<script>window.location.href ="' . ROOT_URL . 'demands";</script>';
                        return;
                    }
                } else {
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Taleple İlgilenebilmek İçin Premium Üye Olmalısınız!', 'error');
                    echo '<script>window.location.href ="' . ROOT_URL . 'demands";</script>';
                    return;
                }
            } catch(PDOException $e) {
                $this->databaseHandler->rollback();
                unset($_SESSION['token']);
                Security::changeSessionIdAndCsrf();
                Message::setMessage('Aynı Taleple Tekrar İlgilenemezsiniz!', 'error');
                echo '<script>window.location.href ="'.ROOT_URL.'demands";</script>';
            }


        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function interestSpesific($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            try {
                $this->findByColumn('demand', 'link', $link);
                $demand = $this->single();
                if($this->isPremiumSpesific($demand['school_id'])) {
                    $this->databaseHandler->beginTransaction();


                    $this->save('demands_interested',
                        array('user_id', 'demand_id'),
                        array($_SESSION['user_data']['user_id'], $demand['id']));

                    $this->save('demand_schools_interested',
                        array('user_id', 'demand_id'),
                        array($_SESSION['user_data']['user_id'], $demand['id']));

                    $this->save('all_user_notifications',
                        array('user_id', 'school_type', 'interested_user', 'type', 'title', 'content', 'link'),
                        array(+$demand['user_id'], $demand['school_type'], $_SESSION['user_data']['user_id'], 'school', 'Talebinizle İlgilenildi! ',
                            'talebinizle ilgilendi!', $link));

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Taleple İlgilendiğiniz Veliye İletilmiştir!', 'success');
                    echo '<script>window.location.href ="' . ROOT_URL . 'demands/spesific";</script>';
                } else {
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Taleple İlgilenebilmek İçin Premium Üye Olmalısınız!', 'error');
                    echo '<script>window.location.href ="' . ROOT_URL . 'demands/spesific";</script>';
                    return;
                }
            } catch(PDOException $e) {
                $this->databaseHandler->rollback();
                unset($_SESSION['token']);
                Security::changeSessionIdAndCsrf();
                Message::setMessage('Aynı Taleple Tekrar İlgilenemezsiniz!', 'error');
                echo '<script>window.location.href ="'.ROOT_URL.'demands/spesific";</script>';
            }


        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detail($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
                $this->findByColumn('demand', 'link', $link);
                $demand = $this->single();
                $this->setCities();
                $this->setTowns($demand['sehir_key']);
                $this->setSubTowns($demand['ilce_key']);
                if($demand) {
                    $this->save('demand_schools_interested',
                    array('user_id', 'demand_id'),
                    array($_SESSION['user_data']['user_id'], $demand['id']));

                    return $demand;
                } else {
                    echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                    return;
                }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailSpesific($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
                $this->findByColumn('demand', 'link', $link);
                $demand = $this->single();
                $this->setSchools();
                if ($demand) {
                    return $demand;
                } else {
                    echo '<script>window.location.href ="' . ROOT_URL . '";</script>';
                    return;
                }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailInterested($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('demand', 'link', $link);
            $demand = $this->single();
            $this->setCities();
            $this->setTowns($demand['sehir_key']);
            $this->setSubTowns($demand['ilce_key']);
            if($demand) {
                return $demand;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailSpesificInterested($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('demand', 'link', $link);
            $demand = $this->single();
            $this->setSchools();
            if ($demand) {
                return $demand;
            } else {
                echo '<script>window.location.href ="' . ROOT_URL . '";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

}

