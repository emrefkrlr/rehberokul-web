<?php
class EmailModel extends DBOperation {

    public static $SECRETKEY ="mysecretkey1234";

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('email_template');
            $this->orderBy('create_date', 'desc');
            $emails = $this->resultSet();
            return $emails;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('email_template', 'link', $link);
            $email = $this->single();
            if($email) {
                return $email;
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
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('email_template', 'link', $link);
            $email = $this->single();
            if($email) {
                return $email;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewSend($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('email_template', 'link', $link);
            $email = $this->single();
            if($email) {
                return $email;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function preview($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('email_template', 'link', $link);
            $email = $this->single();
            if($email) {
                return $email;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function sendTest() {

        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $content = $_POST['content'];
                    $title = str_replace("&#39;","'",$post['mail_subject']);
                    $this->findByColumn('setting', 'name', 'email');
                    $email_settings = $this->single();
                    require_once("assets/php/gmail.php");
                    sendTestEmail($post['test_email'],$content, $title, $email_settings['email_address'], openssl_decrypt($email_settings['email_password'], "AES-128-ECB", self::$SECRETKEY));
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Email Başarıyla Gönderildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Gönderme Başarısız! <br />', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
        }
        return;
    }

    public function sendAll() {

        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $content = $_POST['content'];
                    $title = str_replace("&#39;","'",$post['mail_subject']);
                    $this->findByColumn('setting', 'name', 'email');
                    $email_settings = $this->single();
                    $mail_addresses = array();
                    if($post['send_to_multi'] && $post['send_to_multi'] == 1) { //Veliler
                        $this->findByColumn('user', 'role_id', 3);
                        $veliler = $this->resultSet();
                        foreach ($veliler as $veli) {
                            $mail_addresses[] = $veli['email'];
                        }
                    } else if($post['send_to_multi'] && $post['send_to_multi'] == 2) { // Kurum Sahipleri
                        $this->findByColumn('user', 'role_id', 4); // Okul yetkilisi
                        $this->addAndClause('role_id', 2); // Kurum sahibi
                        $kurumlar = $this->resultSet();
                        foreach ($kurumlar as $kurum) {
                            $mail_addresses[] = $kurum['email'];
                        }
                    } else {
                    }
                    require_once("assets/php/gmail.php");

                    sendMail($mail_addresses,$content, $title, $email_settings['email_address'], openssl_decrypt($email_settings['email_password'], "AES-128-ECB", self::$SECRETKEY));
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Emailler Başarıyla Gönderildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Gönderme Başarısız! <br />', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
        }
        return;
    }

    public function setting() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('setting', 'name', 'email');
            $emailSetting = $this->single();
            if($emailSetting) {
                return $emailSetting;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detail($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('email_template', 'link', $link);
            $email = $this->single();
            if($email) {
                return $email;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function setSetting($name) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('setting', 'name', $name);
                    if($post['email_password'] == $post['password_verification']) {
                        $this->setWhereConditionForUpdate('name', $name);
                        $this->updateByColumn('setting', array(
                            'email_address' => $post['email_address'],
                            'email_password' => openssl_encrypt($post['email_password'], "AES-128-ECB", self::$SECRETKEY)
                        ), $name);

                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Email Ayarları Başarıyla Güncellendi!', 'success');
                        echo '<script>window.location.href ="' . ROOT_URL .'email/setting/'.$name.'";</script>';
                    } else {
                        Message::setMessage('Güncelleme Başarısız! <br />Parolalar Uyuşmuyor!', 'error');
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        echo '<script>window.location.href ="'.ROOT_URL.'email/setting/'.$name.'";</script>';
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
            Message::setMessage('Güncelleme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'email/setting/'.$name.'";</script>';
        }
        return;
    }

    private function summernoteUpload($postTitle) {
        global $ttl;
        $ttl = $postTitle;
        $_POST['content'] = preg_replace_callback("/src=\"data:([^\"]+)\"/", function ($matches) {
            global $ttl;
            list($contentType, $encContent) = explode(';', $matches[1]);
            if (substr($encContent, 0, 6) != 'base64') {
                return $matches[0]; // Eğer base64 yoksa terminate et
            }
            $imgBase64 = substr($encContent, 6);
            $imgFilename = md5($imgBase64); // Dosya adı oluştur
            $imgExt = '';
            switch($contentType) {
                case 'image/jpeg':  $imgExt = 'jpg'; break;
                case 'image/gif':   $imgExt = 'jpg'; break;
                case 'image/png':   $imgExt = 'jpg'; break;
                default:            return $matches[0]; // hiç bir uzantı değilse terminate et
            }
            $imgPath = "assets/images/email/".$ttl.'-'.uniqid().'.'.$imgExt; // yüklenecek yer
            // Eğer kayıtlı değilse sunucuya kaydet
            if (!file_exists($imgPath)) {
                $imgDecoded = base64_decode($imgBase64); // decode base64
                $fp = fopen($imgPath, 'w'); //stream aç
                if (!$fp) {
                    return $matches[0];//eğer başarılı değilse terminate et
                }
                fwrite($fp, $imgDecoded);//stream ile servera yaz
                fclose($fp);//streami kapat
            }

            return 'src="'.$imgPath.'" title="'.$ttl.'" alt="'.$ttl.'"';
        }, $_POST['content']);
    }

    private function deleteSummernoteImagesFromServer($html) {
        preg_match_all( '@src="([^"]+)"@' , $html, $match );
        $src = array_pop($match);
        for( $i=0; $i< count($src); $i++ ) {
            unlink($src[$i]);
        }
    }

    private function editSummernoteImagesAtServer($prevContent, $finalContent) {
        preg_match_all('@src="([^"]+)"@' , $prevContent, $match );
        $src = array_pop($match);
        preg_match_all('@src="([^"]+)"@' , $finalContent, $matchFinal);
        $src_final = array_pop($matchFinal);
        for( $i=0; $i< count($src); $i++ ) {
            if(!in_array($src[$i], $src_final ))
            {
                unlink($src[$i]);
            }
        }

    }

    public function copy($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $this->databaseHandler->beginTransaction();
                $this->findByColumn('email_template', 'link', $link);
                $currentEmail = $this->single();
                $uniqNo = uniqid();
                $title = str_replace("&#39;","''", $currentEmail['title']);

                $content = htmlspecialchars($currentEmail['content']);
                $content = str_replace("'", "''", $content);
                $content = htmlspecialchars_decode($content);

                // Adding a email template
                $this->save('email_template',
                    array('title', 'content', 'link'),
                    array($title.' Taslağı', $content, URLHelper::seflinkGenerator($currentEmail['title'].' Taslağı-'.$uniqNo)));


                $this->databaseHandler->commit();
                unset($_SESSION['token']);
                Security::changeSessionIdAndCsrf();
                Message::setMessage('Email Taslağı Başarıyla Kopyalandı!', 'success');
                echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';

            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Email Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
        }
        return;
    }

    public function edit($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('email_template', 'link', $link);
                    $currentEmail = $this->single();
                    $uniqNo = uniqid();

                    $title = str_replace("&#39;","'",$post['mail_subject']);

                    // Upload Images in Content To Server
                    $this->summernoteUpload(URLHelper::seflinkGenerator($title.'-'.$uniqNo));
                    // Delete Images If Post Had First But Not Now
                    $this->editSummernoteImagesAtServer(htmlspecialchars_decode($currentEmail['content']),
                        htmlspecialchars_decode($_POST['content']));

                    $content = htmlspecialchars($_POST['content']);

                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('email_template', array(
                        'content' => $content,
                        'title' => $title,
                        'link' => URLHelper::seflinkGenerator($post['mail_subject'].'-'.$uniqNo)
                    ), $link);

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Email Taslağı Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Email Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
        }
        return;
    }

    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();


                    $title = str_replace("&#39;","''",$post['mail_subject']);
                    $uniqNo = uniqid();
                    //Upload Images in Content To Server
                    $this->summernoteUpload(URLHelper::seflinkGenerator($title.'-'.$uniqNo));

                    $content = htmlspecialchars($_POST['content']);
                    $content = str_replace("'", "''", $content);

                    // Adding a email
                    $this->save('email_template',
                        array('title', 'content', 'link'),
                        array($post['mail_subject'], $content, URLHelper::seflinkGenerator($post['mail_subject'].'-'.$uniqNo)));

                    $this->databaseHandler->commit();
                    Message::setMessage('Email Taslağı Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Email Taslağı Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
        }
        return;
    }

    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->findByColumn('email_template', 'link', $link);
                    $currentEmail = $this->single();

                    // Delete Images In The Content From Server
                    $this->deleteSummernoteImagesFromServer(htmlspecialchars_decode($currentEmail['content']));
                    // Delete Post
                    $this->deleteByColumn('email_template', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Email Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'email";</script>';
        }
        return;
    }

}

