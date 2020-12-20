<?php
class DemandModel extends DBOperation {
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

    public function getRoleId($user_id) {
        $this->findByColumn('user', 'id', $user_id);
        $user = $this->single();
        return $user['role_id'];
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

    public function getInterestedSchoolsReal($demand_id) {
        $this->findByColumn('demands_interested', 'demand_id', $demand_id);
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
                    $this->addAndClause('state',2);
                    $cSchool = $this->single();
                    if($demand['school_type'] == $cSchool['type']) {
                        $result = $result.'<br>'.$cSchool['name'];
                    }

                }
            }
        }
        return $result;
    }

    public function getTown($ilce_key) {
        $this->findByColumn('town', 'ilce_key',$ilce_key);
        $town = $this->single();
        return $town['name'];
    }
    // TIKLAYAN OKULLAR
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
                    $this->addAndClause('state',2);
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
            $this->findByColumn('demand', 'school_id', 0);
            $this->orderBy('create_date', 'DESC');
            $demands = $this->resultSet();
            return $demands;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function parent() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('demand', 'user_id', $_SESSION['user_data']['user_id']);
            $this->addAndClause('is_active', 1);
            $this->orderBy('create_date', 'DESC');
            $demands = $this->resultSet();
            return $demands;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewAddParentDemand() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setCities();
            $this->setParents();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function addParentDemand() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    $date = new DateTime('now');
                    $userId = $_SESSION['user_data']['user_id'];

                    $this->save('demand',
                        array('school_type', 'age', 'quota', 'class', 'user_id', 'school_id', 'sehir_key', 'ilce_key', 'mahalle_key', 'price_interval', 'note', 'state', 'is_active', 'link'),
                        array($post['school_type'], $post['age'], $post['quota'], $post['school_type'] == 1 ? '' : ($post['school_type'] == 2 ? $post['classroom_ilkokul'] : ($post['school_type'] == 3 ? $post['classroom_ortaokul'] : $post['classroom_lise'])),
                            $userId, 0, $post['city'], $post['town'], $post['subtown'], $post['price'], $post['note'], 0, 1, URLHelper::seflinkGenerator($userId.'-0'.'-'.$date->format('Y-m-d H:i:s'))));



                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Talep Başarıyla Eklendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Kaydetme Başarısız! <br />Talep Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
        }
        return;
    }

    public function doneParentDemand($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $this->databaseHandler->beginTransaction();
                $this->setWhereConditionForUpdate('link', $link);
                $this->updateByColumn('demand', array(
                    'state' => 2
                ), $link);

                $this->databaseHandler->commit();
                unset($_SESSION['token']);
                Security::changeSessionIdAndCsrf();
                Message::setMessage('Talebin Durumu Karşılandı Olarak Değiştirildi!', 'success');
                echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';

            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Karşılanamadı!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';
        }
        return;
    }

    public function detailParentDemand($link) {
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

    public function detailParentDemandSpesific($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('demand', 'link', $link);
            $demand = $this->single();
            $this->setSchools();
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

    public function viewEditParentDemand($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
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

    public function editParentDemand($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('demand', 'link', $link);
                    $demand = $this->single();
                    if($demand['state'] == 0 && $demand['is_active'] == 1) {
                        $this->setWhereConditionForUpdate('link', $link);
                        $this->updateByColumn('demand', array(
                            'sehir_key' => $post['city'],
                            'ilce_key' => $post['town'],
                            'mahalle_key' => $post['subtown'],
                            'price_interval' => $post['price'],
                            'class' => $post['school_type'] == 1 ? '' : ($post['school_type'] == 2 ? $post['classroom_ilkokul'] : ($post['school_type'] == 3 ? $post['classroom_ortaokul'] : $post['classroom_lise'])),
                            'age' => $post['age'],
                            'school_type'=> $post['school_type'],
                            'quota'=> $post['quota'],
                            'note'=> $post['note']
                        ), $link);
                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Talep Başarıyla Güncellendi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';
                    } else {
                        $this->databaseHandler->rollback();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Güncelleme Başarısız! <br />Talep Onaylanmış!', 'error');
                        echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';
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
            Message::setMessage('Güncelleme Başarısız! <br />Talep Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';
        }
        return;
    }

    public function viewDeleteParentDemand($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
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

    public function viewDeleteParentDemandSpesific($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('demand', 'link', $link);
            $demand = $this->single();
            $this->setSchools();
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

    public function deleteParentDemand($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('demand', array(
                        'is_active' => 0,
                    ), $link);

                    $this->databaseHandler->commit();
                    Message::setMessage('Talep Başarıyla Pasife Çekildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Pasife Çekme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand/parent";</script>';
        }
        return;
    }

    public function spesific() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('demand', 'school_id', 0, 'NOT');
            $this->orderBy('create_date', 'DESC');
            $demands = $this->resultSet();
            return $demands;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
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

    public function viewAdd() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setCities();
            $this->setParents();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEditSpesific($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('demand', 'link', $link);
            $demand = $this->single();
            $this->setSchools();
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

    public function viewAddDemand($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
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

    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
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

    public function viewDeleteSpesific($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('demand', 'link', $link);
            $demand = $this->single();
            $this->setSchools();
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

    public function detail($link) {
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

    public function detailSpesific($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('demand', 'link', $link);
            $demand = $this->single();
            $this->setSchools();
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

    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    $date = new DateTime('now');
                    $userId = $post['user_id'] == '' ? $_SESSION['user_data']['user_id'] : $post['user_id'];
                    if($post['user_id'] == '') {
                        $this->save('demand',
                            array('school_type', 'age', 'quota', 'class', 'user_id', 'full_name', 'phone', 'email', 'school_id', 'sehir_key', 'ilce_key', 'mahalle_key', 'price_interval', 'note', 'state', 'is_active', 'link'),
                            array($post['school_type'], $post['age'], $post['quota'], $post['school_type'] == 1 ? '' : ($post['school_type'] == 2 ? $post['classroom_ilkokul'] : ($post['school_type'] == 3 ? $post['classroom_ortaokul'] : $post['classroom_lise'])),
                                $userId, $post['full_name'], $post['phone'], $post['email'], 0, $post['city'], $post['town'], $post['subtown'], $post['price'], $post['note'], 1, 1, URLHelper::seflinkGenerator($userId.'-0'.'-'.$date->format('Y-m-d H:i:s'))));

                    } else {
                        $this->save('demand',
                            array('school_type', 'age', 'quota', 'class', 'user_id', 'school_id', 'sehir_key', 'ilce_key', 'mahalle_key', 'price_interval', 'note', 'state', 'is_active', 'link'),
                            array($post['school_type'], $post['age'], $post['quota'], $post['school_type'] == 1 ? '' : ($post['school_type'] == 2 ? $post['classroom_ilkokul'] : ($post['school_type'] == 3 ? $post['classroom_ortaokul'] : $post['classroom_lise'])),
                                $userId, 0, $post['city'], $post['town'], $post['subtown'], $post['price'], $post['note'], 1, 1, URLHelper::seflinkGenerator($userId.'-0'.'-'.$date->format('Y-m-d H:i:s'))));

                    }

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Talep Başarıyla Eklendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Kaydetme Başarısız! <br />Talep Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
        }
        return;
    }

    public function edit($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('demand', 'link', $link);
                    $demand = $this->single();
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('demand', array(
                        'state' => $post['state'] != '' ? $post['state'] : $demand['state']
                    ), $link);

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Talep Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Talep Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
        }
        return;
    }

    public function done($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $this->databaseHandler->beginTransaction();
                $this->setWhereConditionForUpdate('link', $link);
                $this->updateByColumn('demand', array(
                    'state' => 2
                ), $link);

                $this->databaseHandler->commit();
                unset($_SESSION['token']);
                Security::changeSessionIdAndCsrf();
                Message::setMessage('Talep Başarıyla Karşılandı!', 'success');
                echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';

            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Karşılanamadı!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
        }
        return;
    }

    public function approve($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $this->databaseHandler->beginTransaction();
                $this->setWhereConditionForUpdate('link', $link);
                $this->updateByColumn('demand', array(
                    'state' => 1
                ), $link);

                $this->databaseHandler->commit();
                unset($_SESSION['token']);
                Security::changeSessionIdAndCsrf();
                Message::setMessage('Talep Başarıyla Onaylandı!', 'success');
                echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Onaylanamadı!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
        }
        return;
    }

    public function editSpesific($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('demand', 'link', $link);
                    $demand = $this->single();
                    $date = new DateTime('now');
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('demand', array(
                        'state' => $post['state'] != '' ? $post['state'] : $demand['state'],
                        'is_active' => 1
                    ), $link);

                    // Demand admin tarafından onaylandıktan sonra all notificationsa demand kaydı düş
                    if($post['state'] == 1 && $demand['state'] != $post['state']) {

                        $this->findByColumn('school_owner', 'school_id', $demand['school_id']);
                        $school_owner = $this->single();
                        // Adding a notification
                        $this->save('all_user_notifications',
                            array('user_id', 'school_type', 'interested_user', 'type', 'title', 'content', 'link'),
                            array(+$school_owner['user_id'], $demand['school_type'], '1', 'demand', 'Yeni Talep! ',
                                'Tarafınıza Yeni Bir Talep Gelmiştir! Talebi Görüntülemek İçin Aşağıdaki Linke Tıklayınız!',
                                $link));
                    }




                    $selectedSchools = $post['school'];
                    foreach($selectedSchools as $school) {
                        if($demand['school_id'] == +$school) {
                            continue;
                        }

                        $this->findByColumn('school_owner', 'school_id', $school);
                        $school_owner = $this->single();
                        // Adding a notification
                        $this->save('all_user_notifications',
                            array('user_id', 'school_type', 'interested_user', 'type', 'title', 'content', 'link'),
                            array(+$school_owner['user_id'], $demand['school_type'], '1', 'demand', 'Yeni Talep! ',
                                'Tarafınıza Yeni Bir Talep Gelmiştir! Talebi Görüntülemek İçin Aşağıdaki Linke Tıklayınız!',
                                $link));

                        $this->save('demand',
                            array('user_id', 'school_id', 'note', 'state', 'is_active', 'link'),
                            array($demand['user_id'], +$school, $post['note'], 1, 1, URLHelper::seflinkGenerator($demand['user_id'].'-'.$school['id'].'-'.$date->format('Y-m-d H:i:s'))));
                    }

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Talep Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'demand/spesific";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Talep Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand/spesific";</script>';
        }
        return;
    }

    public function addDemand($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('demand', 'link', $link);
                    $demand = $this->single();
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('demand', array(
                        'note' => $post['note'],
                        'sehir_key' => $post['city'],
                        'school_id' => 0,
                        'ilce_key' => $post['town'],
                        'mahalle_key' => $post['subtown'],
                        'price_interval' => $post['price'],
                        'age' => $post['age'],
                        'quota' => $post['quota'],
                        'school_type' =>  $post['school_type'],
                        'class' => $post['school_type'] == 1 ? '' : ($post['school_type'] == 2 ? $post['classroom_ilkokul'] : ($post['school_type'] == 3 ? $post['classroom_ortaokul'] : $post['classroom_lise'])),
                        'state' => $post['state'] != '' ? $post['state'] : $demand['state'],
                        'is_active' => 1
                    ), $link);
                    $this->databaseHandler->commit();
                    Message::setMessage('Genel Talep Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'demand/spesific";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Talep Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand/spesific";</script>';
        }
        return;
    }

    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('demand', array(
                        'is_active' => 0,
                    ), $link);

                    $this->databaseHandler->commit();
                    Message::setMessage('Talep Başarıyla Pasife Çekildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Pasife Çekme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'demand";</script>';
        }
        return;
    }

}

