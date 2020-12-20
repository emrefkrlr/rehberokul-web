<?php
class UserModel extends DBOperation {
    public static $roles;
    public static $schools;
    public static $school_executive;
    public static $owner_schools;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }
    
    public function setRoles() {
        $this->findAll('role');
        self::$roles = $this->resultSet();
    }

    public function setSchoolExecutive($user_id) {
        $this->findByColumn('school_executive', 'user_id', $user_id);
        self::$school_executive = $this->single();
    }

    public function getNumberOfSchools($user_id) {
        $this->count('school_owner');
        $this->where('user_id', $user_id);
        $count = $this->single();
        $count = $count['total'];
        return $count;
    }

    public function setOwnerSchools() {
        $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
        $ownerSchools = $this->resultSet();
        $oSchools = array();
        foreach ($ownerSchools as $school) {
            $this->findByColumn('school', 'id', $school['school_id']);
            $this->addAndClause('state', 2);
            $oSchools[] = $this->single();
        }

        self::$owner_schools = $oSchools;
    }

    public function setSchools() {
        $this->findAll('school');
        $this->where('state', 2);
        self::$schools = $this->resultSet();
    }
    
    
    public function all_users() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('user');
            $this->orderBy('creation_date', 'desc');
            //$this->findByColumn('user','email', $_SESSION['user_data']['email'], 'NOT');
            $users = $this->resultSet();
            return $users;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function owners() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('user', 'role_id', 2);
            $this->orderBy('creation_date', 'desc');
            //$this->findByColumn('user','email', $_SESSION['user_data']['email'], 'NOT');
            $users = $this->resultSet();
            return $users;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function executives() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('user', 'role_id', 4);
            $this->orderBy('creation_date', 'desc');
            //$this->findByColumn('user','email', $_SESSION['user_data']['email'], 'NOT');
            $users = $this->resultSet();
            return $users;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function executive() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $owner_schools = $this->resultSet();
            $users = array();
            foreach ($owner_schools as $owner_school) {
                $this->findByColumn('school_executive', 'school_id', $owner_school['school_id']);
                $this->orderBy('id', 'desc');
                $school_executive = $this->resultSet();
                foreach ($school_executive as $executive) {
                    if($executive) {
                        $this->findByColumn('user', 'role_id', 4);
                        $this->addAndClause('id', $executive['user_id']);
                        $users[] = $this->single();
                    }
                }


            }
            return $users;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function parents() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('user', 'role_id', 3);
            $this->orderBy('creation_date', 'desc');
            //$this->findByColumn('user','email', $_SESSION['user_data']['email'], 'NOT');
            $users = $this->resultSet();
            return $users;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    private function send_confirmation_email($user_email, $user_first_name, $userLink, $userToken) {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // DB'deki demand satırındaki email adresine mail yolla
        define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
        require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
        require_once('../php/Forms/Classes/EmailOperations.php');
        require_once('../php/Classes/MysqliDb.php');

        $db = new MysqliDb('localhost', 'rehberok_web_user', 'P(ie*igC*juoRehberO', 'rehberok_web_db');
        $emailOps = new EmailOperations;

        $first_name = $emailOps->convertTextToTitleCase($user_first_name);
        $email = $user_email;


        $buttonRedirectLink = "https://www.rehberokul.com/hesap-dogrulama/".$userLink."/".$userToken;

        $dbOpStatus = true;

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
            }
        }
    }
    
    public function viewEdit($link) {
        if(Controller::getRequestId() == $_SESSION['user_data']['link'] 
                || $this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->setRoles();
            $this->setSchools();
            $this->findByColumn('user', 'link', $link);
            $user = $this->single();
            $this->setSchoolExecutive($user['id']);
            if($user) {
                return $user;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function viewAdd() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setRoles();
            $this->setSchools();
            return self::$roles;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->setRoles();
            $this->setSchools();
            $this->findByColumn('user', 'link', $link);
            $user = $this->single();
            $this->setSchoolExecutive($user['id']);
            if($user) {
                return $user;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDeleteExecutive($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->setOwnerSchools();
            $this->findByColumn('user', 'link', $link);
            $user = $this->single();
            $this->setSchoolExecutive($user['id']);
            if($user) {
                return $user;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEditExecutive($link) {
        if(Controller::getRequestId() == $_SESSION['user_data']['link']
            || $this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->setOwnerSchools();
            $this->findByColumn('user', 'link', $link);
            $user = $this->single();
            $this->setSchoolExecutive($user['id']);
            if($user) {
                return $user;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    public function viewAddExecutive() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setOwnerSchools();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    
    public function detail($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->setRoles();
            $this->setSchools();
            $this->findByColumn('user', 'link', $link);
            $user = $this->single();
            $this->setSchoolExecutive($user['id']);
            if($user) {
                return $user;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailExecutive($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->setOwnerSchools();
            $this->findByColumn('user', 'link', $link);
            $user = $this->single();
            $this->setSchoolExecutive($user['id']);
            if($user) {
                return $user;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function edit($link) {
        try {
            if(Controller::getRequestId() == $_SESSION['user_data']['link'] 
                || $this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->findByColumn('user','link', $link);
                    $selectedUser = $this->single();
                    $menuPath = '';
                    if($selectedUser['role_id'] == 2) {
                        $menuPath = 'owners';
                    } elseif ($selectedUser['role_id'] == 3) {
                        $menuPath = 'parents';
                    } elseif ($selectedUser['role_id'] == 4) {
                        $menuPath = 'executives';
                    } else {
                        $menuPath =  'all_users';
                    }
                    $this->databaseHandler->beginTransaction();
                    if($post['password'] == $post['password_verification']) {
                       
                        $this->setWhereConditionForUpdate('link', $link);
                        if($post['password'] == '') {
                            $this->updateByColumn('user', array(
                                'first_name' => $post['first_name'],
                                'last_name' => $post['last_name'],
                                'phone' => $post['phone'],
                                'email' => $post['email'],
                                'is_active' => $post['is_active'],
                                'role_id' => $post['role'],
                                'link' => URLHelper::seflinkGenerator($post['email'])
                            ), $link);
                        } else {
                            $this->updateByColumn('user', array(
                                'first_name' => $post['first_name'],
                                'last_name' => $post['last_name'],
                                'password' => hash("sha384", $post['password']),
                                'phone' => $post['phone'],
                                'email' => $post['email'],
                                'is_active' => $post['is_active'],
                                'role_id' => $post['role'],
                                'link' => URLHelper::seflinkGenerator($post['email'])
                            ), $link);
                        }
                        
                       
                        $this->databaseHandler->commit();
                        

                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        $_SESSION['user_data']['full_name'] = $link == $_SESSION['user_data']['link'] ? $post['first_name'].' '.$post['last_name'] : $_SESSION['user_data']['full_name'];
                        $_SESSION['user_data']['email'] = $link == $_SESSION['user_data']['link'] ? $post['email'] : $_SESSION['user_data']['email'];
                        $_SESSION['user_data']['link'] = $link == $_SESSION['user_data']['link'] ? URLHelper::seflinkGenerator($post['email']) : $_SESSION['user_data']['link'];

                        Message::setMessage('Başarıyla Güncellendi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'user/'.$menuPath.'";</script>';
                    } else {
                        Message::setMessage('Güncelleme Başarısız! <br />Parolalar Uyuşmuyor!', 'error');
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        echo '<script>window.location.href ="'.ROOT_URL.'user/viewEdit/'.$link.'";</script>';
                    }
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback(); 
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Kullanıcı Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';     
        }
        return;
    }

    public function editExecutive($link) {
        try {
            if(Controller::getRequestId() == $_SESSION['user_data']['link']
                || $this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->findByColumn('user','link', $link);
                    $selectedUser = $this->single();
                    $this->databaseHandler->beginTransaction();
                    if($post['password'] == $post['password_verification']) {


                        $hasActiveExecutive = false;

                        $this->findByColumn('school_executive', 'school_id', $post['school']);
                        $school_executives = $this->resultSet();
                        foreach ($school_executives as $school_executive ) {
                            $this->findByColumn('user', 'id', $school_executive['user_id']);
                            $executiveUser = $this->single();
                            if($executiveUser['is_active'] == 1 && ($post['is_active'] == 1 && $post['is_active'] != $selectedUser['is_active'])) {// Eğer school_executivede okula ait yetkili var ise ve bu aktif bir kullanıcı ise ve eklerken aktif seçildiyse
                                $hasActiveExecutive = true;
                            }
                        }
                        if($hasActiveExecutive) {
                            $this->databaseHandler->rollback();
                            Message::setMessage('Kaydetme Başarısız! <br />Okula Ait Aktif Yetkili Bulunmaktadır! Diğer Yetkiliyi Pasif Duruma Çekebilir ya da Silebilirsiniz!', 'error');
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            echo '<script>window.location.href ="'.ROOT_URL.'user/viewEditExecutive/'.$link.'";</script>';
                        } else {
                            $this->setWhereConditionForUpdate('link', $link);
                            if($post['password'] == '') {
                                $this->updateByColumn('user', array(
                                    'first_name' => $post['first_name'],
                                    'last_name' => $post['last_name'],
                                    'phone' => $post['phone'],
                                    'email' => $post['email'],
                                    'is_active' => $post['is_active'],
                                    'link' => URLHelper::seflinkGenerator($post['email'])
                                ), $link);
                            } else {
                                $this->updateByColumn('user', array(
                                    'first_name' => $post['first_name'],
                                    'last_name' => $post['last_name'],
                                    'password' => hash("sha384", $post['password']),
                                    'phone' => $post['phone'],
                                    'email' => $post['email'],
                                    'is_active' => $post['is_active'],
                                    'link' => URLHelper::seflinkGenerator($post['email'])
                                ), $link);
                            }
                            $this->databaseHandler->commit();
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            $_SESSION['user_data']['full_name'] = $link == $_SESSION['user_data']['link'] ? $post['first_name'].' '.$post['last_name'] : $_SESSION['user_data']['full_name'];
                            $_SESSION['user_data']['email'] = $link == $_SESSION['user_data']['link'] ? $post['email'] : $_SESSION['user_data']['email'];
                            $_SESSION['user_data']['link'] = $link == $_SESSION['user_data']['link'] ? URLHelper::seflinkGenerator($post['email']) : $_SESSION['user_data']['link'];

                            Message::setMessage('Başarıyla Güncellendi!', 'success');
                            echo '<script>window.location.href ="'.ROOT_URL.'user/executive";</script>';
                        }

                    } else {
                        $this->databaseHandler->rollback();
                        Message::setMessage('Güncelleme Başarısız! <br />Parolalar Uyuşmuyor!', 'error');
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        echo '<script>window.location.href ="'.ROOT_URL.'user/viewEditExecutive/'.$link.'";</script>';
                    }
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Kullanıcı Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
        }
        return;
    }

    private function createToken($inputValue) {
        $returnValue = sha1(URLHelper::seflinkGenerator($inputValue).uniqid());
        return $returnValue;
    }
    
    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    if($post['password'] == $post['password_verification']) {
                        $this->databaseHandler->beginTransaction();
                        // Add User
                        $token = $this->createToken($post['email']);
                        $this->save('user',
                                array('token', 'first_name', 'last_name', 'phone', 'email', 'password', 'is_active', 'role_id', 'link'),
                                array($post['is_active'] == 0 ? $token : '', $post['first_name'], $post['last_name'], $post['phone'],
                                    $post['email'], hash("sha384", $post['password']), $post['is_active'], $post['role'], URLHelper::seflinkGenerator($post['email'])));
                        if($post['is_active'] == 0)
                            $this->send_confirmation_email($post['email'], $post['first_name'], URLHelper::seflinkGenerator($post['email']), $token);

                        // Add School Executive
                        if($post['school']){
                            $addedUserId = $this->lastInsertId();
                            $this->save('school_executive',
                                array('school_id', 'user_id'),
                                array($post['school'], $addedUserId));
                        }


                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Başarıyla Kaydedildi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'user/all_users";</script>';
                    } else {
                        $this->databaseHandler->rollback();
                        Message::setMessage('Kaydetme Başarısız! <br />Parolalar Uyuşmuyor!', 'error');
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        echo '<script>window.location.href ="'.ROOT_URL.'user/viewAdd";</script>';
                    }
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Kaydetme Başarısız! <br />Kullanıcı Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'user/all_users";</script>';
        }
        return;
    }

    public function addExecutive() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    if($post['password'] == $post['password_verification']) {
                        $this->databaseHandler->beginTransaction();
                        $token = $this->createToken($post['email']);

                        // Add Executive
                        $this->save('user',
                            array('token', 'first_name', 'last_name', 'phone', 'email', 'password', 'is_active', 'role_id', 'link'),
                            array('', $post['first_name'], $post['last_name'], $post['phone'],
                                $post['email'], hash("sha384", $post['password']), $post['is_active'], 4, URLHelper::seflinkGenerator($post['email'])));

                        // Add School Executive
                        $addedUserId = $this->lastInsertId();
                        $hasActiveExecutive = false;

                        $this->findByColumn('school_executive', 'school_id', $post['school']);
                        $school_executives = $this->resultSet();
                        foreach ($school_executives as $school_executive ) {
                            $this->findByColumn('user', 'id', $school_executive['user_id']);
                            $executiveUser = $this->single();
                            if($executiveUser['is_active'] == 1 && $post['is_active'] == 1) {// Eğer school_executivede okula ait yetkili var ise ve bu aktif bir kullanıcı ise ve eklerken aktif seçildiyse
                                $hasActiveExecutive = true;
                            }
                        }
                        if($hasActiveExecutive) {
                            $this->databaseHandler->rollback();
                            Message::setMessage('Kaydetme Başarısız! <br />Okula Ait Aktif Yetkili Bulunmaktadır! Diğer Yetkiliyi Pasif Duruma Çekebilir ya da Silebilirsiniz!', 'error');
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            echo '<script>window.location.href ="'.ROOT_URL.'user/viewAddExecutive";</script>';
                        } else {
                            $this->save('school_executive',
                                array('school_id', 'user_id'),
                                array($post['school'], $addedUserId));
                            $this->databaseHandler->commit();
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            Message::setMessage('Başarıyla Kaydedildi!', 'success');
                            echo '<script>window.location.href ="'.ROOT_URL.'user/executive";</script>';
                        }

                    } else {
                        $this->databaseHandler->rollback();
                        Message::setMessage('Kaydetme Başarısız! <br />Parolalar Uyuşmuyor!', 'error');
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        echo '<script>window.location.href ="'.ROOT_URL.'user/viewAddExecutive";</script>';
                    }
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Kaydetme Başarısız! <br />Okula Ait Yetkili Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'user/executive";</script>';
        }
        return;
    }


    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                        rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                    else
                        unlink($dir. DIRECTORY_SEPARATOR .$object);
                }
            }
            rmdir($dir);
        }
    }

    public function deleteExecutive($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->findByColumn('user', 'link', $link);
                    $currentUser = $this->single();



                    $this->findByColumn('gallery', 'user_id', $currentUser['id']);
                    $this->addAndClause('isdir', 1);
                    $galleriesAddedByUser = $this->resultSet();
                    foreach($galleriesAddedByUser as $gallery) {
                        $this->findByColumn('school_gallery', 'gallery_id', $gallery['id']);
                        $galleryId = $this->single(); // school gallery de yetkili tarafından eklenen galeri
                        if(!$galleryId) { // eğer school gallery de yoksa sil
                            $this->deleteByColumn('gallery', 'parent', $gallery['id']); //galerideki fotolar
                            $this->execute();
                            $this->deleteByColumn('gallery', 'id', $gallery['id']); // galeri
                            $this->execute();
                            $this->rrmdir($gallery['href']);
                        }
                    }

                    $this->deleteByColumn('user', 'link', $link);
                    $this->execute();
                    $this->deleteByColumn('school_executive', 'user_id', $currentUser['id']);
                    $this->execute();

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'user/executive";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'user/all_users";</script>';
        }
        return;
    }


    
    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->findByColumn('user', 'link', $link);
                    $currentUser = $this->single();
                    $this->findByColumn('gallery', 'user_id', $currentUser['id']);
                    $this->addAndClause('isdir', 1);
                    $galleriesAddedByUser = $this->resultSet();
                    foreach($galleriesAddedByUser as $gallery) {
                        $this->findByColumn('school_gallery', 'gallery_id', $gallery['id']);
                        $galleryId = $this->single(); // school gallery de kullanıcı tarafından eklenen galeri
                        if(!$galleryId) { // eğer school gallery de yoksa sil
                            $this->deleteByColumn('gallery', 'parent', $gallery['id']); //galerideki fotolar
                            $this->execute();
                            $this->deleteByColumn('gallery', 'id', $gallery['id']); // galeri
                            $this->execute();
                            $this->rrmdir($gallery['href']);
                        }
                    }

                    $this->deleteByColumn('user', 'link', $link);
                    $this->execute();
                    $this->deleteByColumn('school_executive', 'user_id', $currentUser['id']);
                    $this->execute();

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'user/all_users";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Silme Başarısız! Kullanıcıya Ait Okullar Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'user/all_users";</script>';
        }
        return;
    }

}

