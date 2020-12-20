<?php
class NotificationsModel extends DBOperation {
    public static $roles;
    public static $users;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function getNumberOfSchoolsOfAnOwner($owner_id) {
        $this->count('school_owner');
        $this->where('user_id', $owner_id);
        $numOfSchools = $this->single();
        return $numOfSchools['total'];
    }

    public function owner() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
                $this->findByColumn('all_user_notifications', 'user_id', $_SESSION['user_data']['user_id']);
                $this->addAndClause('is_active', 1);
                $this->orderBy('publish_date', 'desc');
                $fetchData = $this->resultSet();
                return $fetchData;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
        }

    }

    public function parent() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {

                $this->findByColumn('all_user_notifications', 'user_id', $_SESSION['user_data']['user_id']);
                $this->addAndClause('is_active', 1);
                $this->orderBy('publish_date', 'desc');
                $fetchData = $this->resultSet();
                return $fetchData;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
        }
    }

    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('notification', array(
                        'state' => 0
                    ), $link);

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Bildirim Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'notification";</script>';

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
            echo '<script>window.location.href ="'.ROOT_URL.'notification";</script>';
        }
        return;
    }

}

