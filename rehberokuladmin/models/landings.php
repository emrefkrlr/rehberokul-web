<?php
class LandingsModel extends DBOperation {

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

    public function landings() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('landing');
            $landings = $this->resultSet();
            return $landings;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function landingViewEdit($id) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('landing', 'id', $id);
            $landing = $this->single();
            if($landing) {
                return $landing;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function landingEdit($id) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();

                    /*$allowed =  array('jpeg','png' ,'jpg', 'JPEG', 'PNG', 'JPG');
                    $filename = $_FILES['file-icerik']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!in_array($ext,$allowed) && !empty($filename) ) {
                        $this->databaseHandler->rollback();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Kaydetme Başarısız! <br />Fotoğraf uzantısı jpg, jpeg veya png olabilir!', 'error');
                        echo '<script>window.location.href ="'.ROOT_URL.'cms/schooltype";</script>';
                        return;
                    }*/

                    #$this->findByColumn('landing', 'id', $id);
                    #$landing = $this->single();


                    $this->setWhereConditionForUpdate('id', $id);
                    $this->updateByColumn('landing', array(
                        'page_title' => $post['page_title'],
                        'page_description' => $post['page_description'],
                        'header_content' => $post['header_content'],
                        'landing_content' => htmlspecialchars($_POST['landing_content']),
                        'query' => $post['query'],
                        'priority' => $post['priority'],
                    ), $id);



                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('İçerik Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'cms/landings";</script>';
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
            echo '<script>window.location.href ="'.ROOT_URL.'cms/landings";</script>';
        }
        return;
    }

}