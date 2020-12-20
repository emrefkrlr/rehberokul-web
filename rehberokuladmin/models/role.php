<?php
class RoleModel extends DBOperation {
    public static $menuItems;
    
    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }
    
    public function setMenutItems() {
        $this->findByColumn('menu', 'parent_id', '0');
        $this->addAndClause('menu_name', 'Anasayfa', 'NOT');
        //$this->addAndClause('menu_name', 'Kullanıcılar', 'NOT');
        $this->addAndClause('menu_name', 'Roller', 'NOT');
        self::$menuItems = $this->resultSet();
    }
    
    public function getRoleName($roleId) {
        $this->findByColumn('role', 'role_id', $roleId);
        $role = $this->single();
        return $role['role_name'];
    }
    
    public function getMenuName($menuId) {
        $this->findByColumn('menu', 'id', $menuId);
        $role = $this->single();
        return $role['menu_name'];
    }
    
    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('auth', 'role_id', 1, 'NOT');
            $this->addAndClause('menu_id', 1, 'NOT');
            $roles = $this->resultSet();
            return $roles;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function viewEdit($link) {
        if(Controller::getRequestId() == $_SESSION['user_data']['link'] 
                || $this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->setMenutItems();
            $this->findByColumn('auth', 'link', $link);
            $role = $this->single();
            if($role) {
                return $role;
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
            $this->setMenutItems();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->setMenutItems();
            $this->findByColumn('auth', 'link', $link);
            $role = $this->single();
            if($role) {
                return $role;
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
            $this->setMenutItems();
            $this->findByColumn('auth', 'link', $link);
            $role = $this->single();
            if($role) {
                return $role;
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
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    if(isset($post['auth'])) {
                        $this->databaseHandler->beginTransaction();
                        $this->findByColumn('auth', 'link', $link);
                        $authObj = $this->single();
                        $roleId = $authObj['role_id'];
                        $this->findByColumn('role', 'role_id', $roleId);
                        $role = $this->single();
                        $roleLink = $role['link'];
                        $this->setWhereConditionForUpdate('link', $roleLink);
                        $this->updateByColumn('role', array(
                            'role_name' => $post['role_name'],
                            'link' => URLHelper::seflinkGenerator($post['role_name'])
                        ), $roleLink);
                        
                        $yetkiList = $post['auth'];
                        $this->setWhereConditionForUpdate('link', $link);
                        $this->updateByColumn('auth', array(
                            'menu_id' => $post['menu'],
                            'reading' =>in_array("reading", $yetkiList) ? 1 : 0,
                            'adding' =>in_array("adding", $yetkiList) ? 1 : 0,
                            'editing' =>in_array("editing", $yetkiList) ? 1 : 0,
                            'deleting' =>in_array("deleting", $yetkiList) ? 1 : 0,
                            'check_news' =>in_array("check_news", $yetkiList) ? 1 : 0,
                            'link' => URLHelper::seflinkGenerator($roleId." ".$post['menu'])
                        ), $link);
                        
                         $this->save('role_auth_log',
                                    array('role_id', 'role_name', 'role_link', 'auth_id', 'menu_id', 'reading', 'adding', 'editing', 'deleting', 'check_news', 'auth_link', 'islem_tipi', 'user_id'),
                                    array( $roleId, $post['role_name'], URLHelper::seflinkGenerator($post['role_name']), $authObj['id'], $post['menu'],
                                        in_array("reading", $yetkiList) ? 1 : 0, in_array("adding", $yetkiList) ? 1 : 0, in_array("editing", $yetkiList) ? 1 : 0,
                                        in_array("deleting", $yetkiList) ? 1 : 0, in_array("check_news", $yetkiList) ? 1 : 0,
                                        URLHelper::seflinkGenerator($roleId." ".$post['menu']), 'Güncelleme', $_SESSION['user_data']['user_id']));
                        
                        
                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Başarıyla Güncellendi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'role";</script>';
                    } else {
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Yetkileri Seçiniz!', 'error');
                        unset($_SESSION['token']);
                        echo '<script>window.location.href ="'.ROOT_URL.'role/viewEdit/'.$link.'";</script>';
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
            Message::setMessage('Güncelleme Başarısız! <br />Rol ve Menü Yetkileri Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'role";</script>'; 
        }
        return;
    }
    
    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    if(isset($post['auth'])) {
                        $this->databaseHandler->beginTransaction();
                        $this->findByColumn('role', 'role_name', $post['role_name']);
                        $selectedRole = $this->single();
                        $yetkiList = $post['auth'];
                        if(strlen($selectedRole['role_name']) == 0) {
                            $this->save('role',
                                    array('role_name', 'link'),
                                    array($post['role_name'], URLHelper::seflinkGenerator($post['role_name'])));
                        
                            $lastRoleId = $this->lastInsertId();
                            
                            $this->findByColumn('role', 'role_name', $post['role_name']);
                            $selectedRole = $this->single();
                            $this->save('auth', array('role_id', 'menu_id', 'reading', 'adding', 'editing', 'deleting','check_news', 'link'),
                                array($selectedRole['role_id'], 1, 1, 0, 0, 0, 0, URLHelper::seflinkGenerator($selectedRole['role_id']." 1")));
                        
                            $lastAuthId = $this->lastInsertId();
                            
                            $this->save('role_auth_log',
                                    array('role_id', 'role_name', 'role_link', 'auth_id', 'menu_id', 'reading', 'adding', 'editing', 'deleting', 'check_news', 'auth_link', 'islem_tipi', 'user_id'),
                                    array( $lastRoleId, $post['role_name'], URLHelper::seflinkGenerator($post['role_name']), $lastAuthId, 1, 1, 0, 0, 0, 0, URLHelper::seflinkGenerator($selectedRole['role_id']." 1"), 'Ekleme', $_SESSION['user_data']['user_id']));
                        }

                        $this->save('auth',
                            array('role_id', 'menu_id', 'reading', 'adding', 'editing', 'deleting','check_news', 'link'),
                            array($selectedRole['role_id'], $post['menu'], in_array("reading", $yetkiList) ? 1 : 0,
                                in_array("adding", $yetkiList) ? 1 : 0, in_array("editing", $yetkiList) ? 1 : 0, 
                                in_array("deleting", $yetkiList) ? 1 : 0, in_array("check_news", $yetkiList) ? 1 : 0, URLHelper::seflinkGenerator($selectedRole['role_id']." ".$post['menu'])));              
                        
                        $lastAuthId = $this->lastInsertId();
                            
                            $this->save('role_auth_log',
                                    array('role_id', 'role_name', 'role_link', 'auth_id', 'menu_id', 'reading', 'adding', 'editing', 'deleting', 'check_news', 'auth_link', 'islem_tipi', 'user_id'),
                                    array( $lastRoleId, $post['role_name'], URLHelper::seflinkGenerator($post['role_name']), $lastAuthId, $post['menu'],
                                        in_array("reading", $yetkiList) ? 1 : 0, in_array("adding", $yetkiList) ? 1 : 0, in_array("editing", $yetkiList) ? 1 : 0,
                                        in_array("deleting", $yetkiList) ? 1 : 0, in_array("check_news", $yetkiList) ? 1 : 0,
                                        URLHelper::seflinkGenerator($selectedRole['role_id']." ".$post['menu']), 'Ekleme', $_SESSION['user_data']['user_id']));
                        
                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Başarıyla Kaydedildi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'role";</script>';
                    } else {
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Yetkileri Seçiniz!', 'error');
                        echo '<script>window.location.href ="'.ROOT_URL.'role/viewAdd";</script>';
                    }
                    return;
                } else {
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Kaydetme Başarısız!', 'error');
                    echo '<script>window.location.href ="'.ROOT_URL.'role/viewAdd";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback(); 
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Kaydetme Başarısız! <br />Rol ve Menü Yetkileri Mevcut Olabilir, Güncellemeyi Deneyiniz!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'role";</script>'; 
        }
    }
    
    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('auth', 'link', $link);
                    $authObj = $this->single();
                    $roleId = $authObj['role_id'];   
                    $this->findByColumn('role', 'role_id', $roleId);
                    $role = $this->single();
                    
                    $this->deleteByColumn('auth', 'link', $link);
                    $this->execute();
                    $this->count('auth');
                    $this->where('role_id', $roleId);
                    $roleCount = $this->single();
                    $count = $roleCount['total'];
                    if($count < 2) { //sadece anasayfa yetkisi kaldıysa
                        $this->deleteByColumn('auth', 'role_id', $roleId);
                        $this->execute();
                        $this->deleteByColumn('role', 'role_name', $this->getRoleName($roleId));
                        $this->execute();
                    }
                    
                    $this->save('role_auth_log',
                                    array('role_id', 'role_name', 'role_link', 'auth_id', 'menu_id', 'reading', 'adding', 'editing', 'deleting', 'check_news', 'auth_link', 'islem_tipi', 'user_id'),
                                    array( $roleId, $role['role_name'], URLHelper::seflinkGenerator($role['role_name']), $authObj['id'], $authObj['menu_id'],
                                        $authObj['reading'], $authObj['adding'], $authObj['editing'],
                                        $authObj['deleting'], $authObj['check_news'],
                                        URLHelper::seflinkGenerator($roleId." ".$authObj['menu_id']), 'Silme', $_SESSION['user_data']['user_id']));
                        
                    
                    
                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'role";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback(); 
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Silme Başarısız! Role ait kullanıcılar mevcut olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'role";</script>'; 
        }
    }
}

