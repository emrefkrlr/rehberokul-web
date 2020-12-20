<?php
class SssModel extends DBOperation {

    public static $facility_types;
    public static $facilities;
    public static $schools;


    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function setFacilityTypes() {
        $this->findAll('facility_type');
        self::$facility_types = $this->resultSet();
    }

    public function setFacilities() {
        $this->findAll('facility');
        self::$facilities = $this->resultSet();
    }

    public function setSchools($sss_connection) {
        if($sss_connection == 'servis' || $sss_connection == 26) { // 26 facility tablosunda servis idsi
            $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
            $this->addAndClause('transportation', 1);
            self::$schools = $this->resultSet();
        } else if($sss_connection == 'danisman' || $sss_connection == 24) { // 24 facility tablosunda rehberlik idsi
            $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
            $this->addAndClause('counselor', 1);
            self::$schools = $this->resultSet();

        } else if($sss_connection == 'yas-araligi') {
            $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
            $this->addAndClause('age_interval', '', 'NOT');
            self::$schools = $this->resultSet();

        } else if($sss_connection == 'okul-saatleri') { // 24 facility tablosunda rehberlik idsi
            $schools_by_hours = array();
            $this->findAll('school_hours', ['school_id', 'monday_start', 'monday_end']); //fiziksel imkanlar
            $school_hours = $this->resultSet();
            foreach($school_hours as $school_hour) {
                $this->findByColumn('school', 'id', $school_hour['school_id']); // okullardaki fiziksel imkanlar
                $school = $this->single();
                $schools_by_hours[] = $school;
            }
            self::$schools = $schools_by_hours;

        } else if($sss_connection == 'fiziksel-imkanlar') {
            $schools_by_facility = array();
            $this->findByColumn('facility', 'type', 1); //fiziksel imkanlar
            $fiziksel_imkanlar = $this->resultSet();
            foreach($fiziksel_imkanlar as $fiziksel_imkan) {
                $this->findByColumn('school_facility', 'facility_id', $fiziksel_imkan['id']); // okullardaki fiziksel imkanlar
                $schoolIds = $this->resultSet();
                foreach($schoolIds as $schoolId) {
                    $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
                    $this->addAndClause('id', $schoolId['school_id']);
                    $rslt = $this->single();
                    if(!in_array($rslt, $schools_by_facility)) {
                        $schools_by_facility[] = $rslt;
                    }

                }
            }
            self::$schools = $schools_by_facility;

        } else if($sss_connection == 'servisler') {
            $schools_by_facility = array();
            $this->findByColumn('facility', 'type', 2); //fiziksel imkanlar
            $fiziksel_imkanlar = $this->resultSet();
            foreach($fiziksel_imkanlar as $fiziksel_imkan) {
                $this->findByColumn('school_facility', 'facility_id', $fiziksel_imkan['id']); // okullardaki fiziksel imkanlar
                $schoolIds = $this->resultSet();
                foreach($schoolIds as $schoolId) {
                    $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
                    $this->addAndClause('id', $schoolId['school_id']);
                    $rslt = $this->single();
                    if(!in_array($rslt, $schools_by_facility)) {
                        $schools_by_facility[] = $rslt;
                    }

                }
            }
            self::$schools = $schools_by_facility;

        } else if($sss_connection == 'aktiviteler') {
            $schools_by_facility = array();
            $this->findByColumn('facility', 'type', 3); //fiziksel imkanlar
            $fiziksel_imkanlar = $this->resultSet();
            foreach($fiziksel_imkanlar as $fiziksel_imkan) {
                $this->findByColumn('school_facility', 'facility_id', $fiziksel_imkan['id']); // okullardaki fiziksel imkanlar
                $schoolIds = $this->resultSet();
                foreach($schoolIds as $schoolId) {
                    $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
                    $this->addAndClause('id', $schoolId['school_id']);
                    $rslt = $this->single();
                    if(!in_array($rslt, $schools_by_facility)) {
                        $schools_by_facility[] = $rslt;
                    }

                }
            }
            self::$schools = $schools_by_facility;

        } else if($sss_connection == 'yabanci-diller') {
            $schools_by_facility = array();
            $this->findByColumn('facility', 'type', 4); //fiziksel imkanlar
            $fiziksel_imkanlar = $this->resultSet();
            foreach($fiziksel_imkanlar as $fiziksel_imkan) {
                $this->findByColumn('school_facility', 'facility_id', $fiziksel_imkan['id']); // okullardaki fiziksel imkanlar
                $schoolIds = $this->resultSet();
                foreach($schoolIds as $schoolId) {
                    $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
                    $this->addAndClause('id', $schoolId['school_id']);
                    $rslt = $this->single();
                    if(!in_array($rslt, $schools_by_facility)) {
                        $schools_by_facility[] = $rslt;
                    }

                }
            }
            self::$schools = $schools_by_facility;
        } else {
            $schools_by_facility = array();
            $this->findByColumn('school_facility', 'facility_id', $sss_connection); // okullardaki fiziksel imkanlar
            $schoolIds = $this->resultSet();
            foreach($schoolIds as $schoolId) {
                $this->findByColumn('school', 'state' , 2); //Aktif Olanlar
                $this->addAndClause('id', $schoolId['school_id']);
                $rslt = $this->single();
                if(!in_array($rslt, $schools_by_facility)) {
                    $schools_by_facility[] = $rslt;
                }

            }

            self::$schools = $schools_by_facility;
        }



    }



    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('sss');
            $this->orderBy('publish_date', 'desc');
            $ssss = $this->resultSet();
            return $ssss;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('sss', 'link', $link);
            $sss = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            if($sss) {
                return $sss;
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
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->findAll('landing');
            $this->orderBy('priority', 'desc');
            $landings = $this->resultSet();
            return $landings;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('sss', 'link', $link);
            $sss = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            if($sss) {
                return $sss;
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
            $this->findByColumn('sss', 'link', $link);
            $sss = $this->single();
            $this->setSchools($sss['sss_connection']);
            if($sss) {
                return $sss;
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
            $this->findByColumn('sss', 'link', $link);
            $sss = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            if($sss) {
                return $sss;
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

                    $this->databaseHandler->beginTransaction();
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('sss', array(
                        'state' => $post['state'],
                        'sss_place' => $post['sss_place'],
                        'sss_connection' => $post['sss_place'] != 'okul-detay' ? '' : $post['sss_connection'],
                        'sss_answer_type' =>  $post['sss_place'] != 'okul-detay' ? '' : $post['sss_answer_type'],
                        'sss_style' =>  $post['sss_place'] != 'okul-detay' ? '' : $post['sss_style'],
                        'question' => $post['question'],
                        'answer' =>  $post['answer'],
                        'link' => URLHelper::seflinkGenerator($post['question'].'-'.$post['sss_place'].'-'.$post['sss_connection'])
                    ), $link);

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Soru Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'sss";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Soru Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'sss";</script>';
        }
        return;
    }

    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    // Adding a sss
                    $this->save('sss',
                        array('question', 'sss_place', 'sss_connection', 'sss_answer_type',
                            'sss_style', 'answer', 'state', 'link'),
                        array($post['question'], $post['sss_place'], $post['sss_connection'], $post['sss_answer_type'],
                            $post['sss_style'], $post['answer'], $post['state'],
                            URLHelper::seflinkGenerator($post['question'].'-'.$post['sss_place'].'-'.$post['sss_connection'])));

                    $this->databaseHandler->commit();
                    Message::setMessage('Soru Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'sss";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Soru Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'sss";</script>';
        }
        return;
    }

    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->deleteByColumn('sss', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Soru Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'sss";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'sss";</script>';
        }
        return;
    }

}

