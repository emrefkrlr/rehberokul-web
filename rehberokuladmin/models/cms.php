<?php
class CMSModel extends DBOperation {
    public static $roles;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function schooltype() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('setting', 'name', 'okul-tipi', null,
                array('slug', 'top_header', 'top_content', 'popular_header', 'popular_content', 'bottom_header',
                    'bottom_content', 'photo') );
            $schoolTypes = $this->resultSet();
            return $schoolTypes;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function schooltypeViewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('setting', 'slug', $link);
            $this->addAndClause('name', 'okul-tipi');
            $schoolType = $this->single();
            if($schoolType) {
                return $schoolType;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function schooltypeDetail($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('setting', 'slug', $link);
            $this->addAndClause('name', 'okul-tipi');
            $schoolType = $this->single();
            if($schoolType) {
                return $schoolType;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function schooltypeEdit($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
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
                        echo '<script>window.location.href ="'.ROOT_URL.'cms/schooltype";</script>';
                        return;
                    }

                    $this->findByColumn('setting', 'slug', $link);
                    $this->addAndClause('name', 'okul-tipi');
                    $school_type = $this->single();
                    $old_fotograf = $school_type['photo'];
                    !empty($_FILES['file-icerik']['name']) ? unlink($old_fotograf) : '';
                    $this->setWhereConditionForUpdate('slug', $link);
                    $this->updateByColumn('setting', array(
                        'top_header' => $post['top_header'],
                        'top_content' => $post['top_content'],
                        'popular_header' => $post['popular_header'],
                        'popular_content' => $post['popular_content'],
                        'bottom_header' => $post['bottom_header'],
                        'bottom_content' => $post['bottom_content'],
                        'photo' => !empty($_FILES['file-icerik']['name']) ? FileUploader::uploadSingleFileToServerSchoolType('file-icerik', $school_type['slug']) : $school_type['photo']
                    ), $link);



                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('İçerik Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'cms/schooltype";</script>';
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
            echo '<script>window.location.href ="'.ROOT_URL.'cms/schooltype";</script>';
        }
        return;
    }

}

