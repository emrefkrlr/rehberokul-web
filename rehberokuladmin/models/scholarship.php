<?php
class ScholarshipModel extends DBOperation {

    public static $roles;

    public function roleAuths($role_name, $menu_id) {
        try {
            $this->findByColumn('role', 'role_name' , $role_name);
            $role = $this->single();
            $role_id = $role['role_id'];
            $this->findByColumn('auth', 'role_id', $role_id);
            $this->addAndClause('menu_id', $menu_id);
            return $this->single();
        }catch (Exception $e) {
            error_log($e);
        }

    }

    public function scholarship() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('scholarship');
            $scholarship = $this->resultSet();
            return $scholarship;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function scholarshipAdd() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->findAll('school');
            $result['schools'] = $this->resultSet();
            $this->findAll('college');
            $result['collages'] = $this->resultSet();
            return $result;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function scholarshipPost() {
        try {
            if ($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']){
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $allowed =  array('jpeg','png' ,'jpg', 'JPEG', 'PNG', 'JPG');
                    $filename = $_FILES['file-icerik']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!in_array($ext,$allowed) && !empty($filename) ) {
                        $this->databaseHandler->rollback();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Kaydetme Başarısız! <br />Fotoğraf uzantısı jpg, jpeg veya png olabilir!', 'error');
                        echo '<script>window.location.href ="'.ROOT_URL.'/scholarship";</script>';
                        return;
                    }
                    if ((int)$post['school_id'] != 0 && (int)$post['college_id'] != 0){
                        $this->databaseHandler->rollback();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Kaydetme Başarısız! <br /> Sadece okul yada kolej seçmelisin!', 'error');
                        echo '<script>window.location.href ="'.ROOT_URL.'scholarship";</script>';
                        return;
                    }else if ((int)$post['school_id'] == 0){
                        $school_id = 0;
                        $college_id = (int)$post['college_id'];
                    }else{
                        $school_id = (int)$post['school_id'];
                        $college_id = 0;
                    }




                    $year = $post['year'];
                    $title = str_replace("&#39;","''",$post['title']);
                    $pageDescription = str_replace("&#39;","''",$post['page_description']);
                    $header = str_replace("&#39;","''",$post['header']);
                    $priority = (int)$post['priority'];
                    $content = htmlspecialchars($_POST['content']);
                    $content = str_replace("'", "''", $content);
                    $scholarship_slug =URLHelper::seflinkGenerator($post['title']);

                    $created_date = date("Y-m-d H:i:s");
                    $updated_date = date("Y-m-d H:i:s");
                    $this->summernoteUpload(URLHelper::seflinkGenerator($title));

                    $this->save('scholarship',
                        array('school_id', 'collage_id', 'scholarship_slug', 'title', 'page_description', 'header', 'content', 'img',
                            'status', 'priority', 'created_date', 'updated_date'
                            ),
                        array($school_id, $college_id,$scholarship_slug,$title,$pageDescription,$header,$content,
                            FileUploader::uploadSingleFileToServerScholdership('file-icerik', URLHelper::seflinkGenerator($post['title'].'-'.date("Y-m-d H:i:s"))),
                            1,$priority,$created_date,$updated_date
                    ));
                    $this->databaseHandler->commit();

                    Message::setMessage('Yazı Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'scholarship";</script>';
                } else {
                    echo '<script>window.location.href ="'.ROOT_URL.'scholarship";</script>';
                    return;
                }
            }
        }catch(PDOException $e){
            $this->databaseHandler->rollback();
            echo $e->getMessage();
            Message::setMessage('Kaydetme Başarısız! <br />Yazı/Başlık Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'scholarship";</script>';
        }

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
            $imgPath = "../images/yazilar/".$ttl.'-'.uniqid().'.'.$imgExt; // yüklenecek yer
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


}