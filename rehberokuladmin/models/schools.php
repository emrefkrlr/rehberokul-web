<?php
class SchoolsModel extends DBOperation {
    public static $facilities;
    public static $facility_types;
    public static $cities;
    public static $galleries;
    public static $users;
    public static $towns;
    public static $subtowns;
    public static $school_hours;
    public static $school_facilities;
    public static $transportation_points;
    public static $school_galleries;
    public static $school_owner;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function setFacilities() {
        $this->findAll('facility');
        self::$facilities = $this->resultSet();
    }

    public function setFacilityTypes() {
        $this->findAll('facility_type');
        self::$facility_types = $this->resultSet();
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

    public function setSchoolHours($school_id) {
        $this->findByColumn('school_hours', 'school_id', $school_id);
        self::$school_hours = $this->single();
    }

    public function setSchoolFacilities($school_id) {
        $this->findByColumn('school_facility', 'school_id', $school_id);
        self::$school_facilities = $this->resultSet();
    }

    public function setTransportationPoints($school_id) {
        $this->findByColumn('transportation_point', 'school_id', $school_id);
        self::$transportation_points = $this->resultSet();
    }

    public function setSchoolGalleries($school_id) {
        $this->findByColumn('school_gallery', 'school_id', $school_id);
        self::$school_galleries = $this->single();
    }

    public function setSchoolOwner($school_id) {
        $this->findByColumn('school_owner', 'school_id', $school_id);
        self::$school_owner = $this->single();
    }

    public function setUsers() {
        $this->findByColumn('user', 'role_id', 2);
        self::$users = $this->resultSet();
    }

    public function setGalleries() {
        if($_SESSION['user_data']['role'] == 'Yönetici') {
            $this->findAll('gallery');
            $this->where('isdir',1);
            self::$galleries = $this->resultSet();
        } else if($_SESSION['user_data']['role'] == 'Kurum Sahibi'){
            $galleries = array();
            $this->findByColumn('gallery', 'user_id', $_SESSION['user_data']['user_id']);
            $this->addAndClause('isdir', 1);
            $galleriesAddedByUser = $this->resultSet(); // Kurum sahibinin eklediği galeri ve fotoğraflar
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $ownerSchoolIds = $this->resultSet(); // Kurum sahibinin hangi okulları var
            foreach($ownerSchoolIds as $ownerSchoolId) { // Okullara ait başkası tarafından galeri eklendiyse
                $this->findByColumn('school_gallery', 'school_id', $ownerSchoolId['school_id']);
                $schoolGallery = $this->single(); // Okul için seçilen galeri row
                if($schoolGallery['gallery_id'] != 0) { // Rowda gallery id var ise table listesine ekle
                    $this->findByColumn('gallery', 'id', $schoolGallery['gallery_id']);
                    $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                    $this->orderBy('creation_time', 'desc');
                    $galleries = array_merge($galleries, $this->resultSet());
                }

            }
            $galleries = array_merge($galleriesAddedByUser, $galleries);
            self::$galleries = $galleries;
        } else {
            $galleries = array();
            $this->findByColumn('gallery', 'user_id', $_SESSION['user_data']['user_id']);
            $this->addAndClause('isdir', 1);
            $galleriesAddedByUser = $this->resultSet(); // Kurum sahibinin eklediği galeri ve fotoğraflar
            $this->findByColumn('school_executive', 'user_id', $_SESSION['user_data']['user_id']);
            $ownerSchoolIds = $this->resultSet(); // Okul yetkilisinin hangi okul için olduğu
            foreach($ownerSchoolIds as $ownerSchoolId) { // Okullara ait başkası tarafından galeri eklendiyse
                $this->findByColumn('school_gallery', 'school_id', $ownerSchoolId['school_id']);
                $schoolGallery = $this->single(); // Okul için seçilen galeri row
                if($schoolGallery['gallery_id'] != 0) { // Rowda gallery id var ise table listesine ekle
                    $this->findByColumn('gallery', 'id', $schoolGallery['gallery_id']);
                    $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                    $this->orderBy('creation_time', 'desc');
                    $galleries = array_merge($galleries, $this->resultSet());
                }

            }
            $galleries = array_merge($galleriesAddedByUser, $galleries);
            self::$galleries = $galleries;
        }
    }

    public function getCityName($city_id) {
        $this->findByColumn('city','sehir_key', $city_id);
        $city = $this->single();
        return $city['name'];
    }

    public function getTownName($town_id) {
        $this->findByColumn('town','ilce_key', $town_id);
        $town = $this->single();
        return $town['name'];
    }

    public function kindergarten() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('id', 'desc');
            $schoolIds = $this->resultSet();
            $schools = array();
            foreach ($schoolIds as $schoolId) {
                $this->findByColumn('school', 'id', $schoolId['school_id']);
                $school = $this->single();
                if($school['type']==1 ) {
                    $schools[] = $school;
                }

            }
            return $schools;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function executive() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school_executive', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('id', 'desc');
            $executive = $this->single();
            $this->findByColumn('school', 'id', $executive['school_id']);
            $school = $this->resultSet();
            return $school;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function middle() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('id', 'desc');
            $schoolIds = $this->resultSet();
            $schools = array();
            foreach ($schoolIds as $schoolId) {
                $this->findByColumn('school', 'id', $schoolId['school_id']);
                $school = $this->single();
                if($school['type']==2 || $school['type']==3 ) {
                    $schools[] = $school;
                }
            }
            return $schools;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function high() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('id', 'desc');
            $schoolIds = $this->resultSet();
            $schools = array();
            foreach ($schoolIds as $schoolId) {
                $this->findByColumn('school', 'id', $schoolId['school_id']);
                $school = $this->single();
                if($school['type']==4 ) {
                    $schools[] = $school;
                }
            }
            return $schools;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEditKindergarten($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
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
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewAddKindergarten() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setCities();
            $this->setGalleries();
            $this->setUsers();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDeleteKindergarten($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailKindergarten($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
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
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEditMiddle($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewAddMiddle() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setCities();
            $this->setGalleries();
            $this->setUsers();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDeleteMiddle($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailMiddle($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEditHigh($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewAddHigh() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setCities();
            $this->setGalleries();
            $this->setUsers();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDeleteHigh($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailHigh($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school', 'link', $link);
            $school = $this->single();
            $this->setFacilityTypes();
            $this->setFacilities();
            $this->setSubTowns($school['ilce_key']);
            $this->setTowns($school['sehir_key']);
            $this->setCities();
            $this->setSchoolHours($school['id']);
            $this->setSchoolFacilities($school['id']);
            $this->setTransportationPoints($school['id']);
            $this->setSchoolGalleries($school['id']);
            $this->setSchoolOwner($school['id']);
            $this->setGalleries();
            $this->setUsers();
            if($school) {
                return $school;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function editExecutive($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    if($currentSchool['state'] == 1) {
                        $this->sendConfirmationEmail($post['school_email'], $currentSchool['token'], $link);
                    }

                    $content = htmlspecialchars($_POST['content']);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    // Update School Info
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('school', array(
                        'name' => $post['school_name'],
                        'school_email' => $post['school_email'],
                        'contact_email' => $post['contact_email'],
                        'phone' => $post['phone'],
                        'address' => $post['address'],
                        'sehir_key' => $post['city'],
                        'ilce_key' => $post['town'],
                        'mahalle_key' => $post['subtown'],
                        'transportation' => $post['service'],
                        'discount' => $post['discount'],
                        'counselor' => $post['counselor'],
                        'age_interval' => $currentSchool['type'] == 1 ? $post['start_age'].' - '.$post['end_age'] : '',
                        'class_quota' => $post['quota'],
                        'price' => $post['price'],
                        'tax_no' => $post['tax_no'],
                        'description' => $content,
                        'facebook' => $post['facebook'],
                        'twitter' => $post['twitter'],
                        'instagram' => $post['instagram'],
                        'link' => $sefLink
                    ), $link);


                    // Update school hours
                    $this->deleteByColumn('school_hours', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_hours',
                        array('school_id', 'monday_start', 'monday_end', 'tuesday_start', 'tuesday_end',
                            'wednesday_start', 'wednesday_end', 'thursday_start', 'thursday_end', 'friday_start', 'friday_end'),
                        array($currentSchoolId, $post['monday_start'], $post['monday_end'], $post['tuesday_start'], $post['tuesday_end'],
                            $post['wednesday_start'], $post['wednesday_end'], $post['thursday_start'], $post['thursday_end'],
                            $post['friday_start'], $post['friday_end']));

                    // Update school facilities
                    $this->deleteByColumn('school_facility', 'school_id', $currentSchoolId);
                    $this->execute();
                    $facs = $post['facs'];
                    foreach($facs as $facility) {
                        $this->save('school_facility',
                            array('school_id', 'facility_id'),
                            array($currentSchoolId, +$facility));
                    }

                    // Update school tranportation points
                    $this->deleteByColumn('transportation_point', 'school_id', $currentSchoolId);
                    $this->execute();
                    $servc = $post['servc'];
                    foreach($servc as $tpoint) {
                        $this->save('transportation_point',
                            array('school_id', 'ilce_key'),
                            array($currentSchoolId, +$tpoint));
                    }

                    // Adding school gallery
                    $this->deleteByColumn('school_gallery', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_gallery',
                        array('school_id', 'gallery_id'),
                        array($currentSchoolId, $post['gallery']));

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Okul Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/executive";</script>';
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
            echo '<script>window.location.href ="'.ROOT_URL.'schools/executive";</script>';
        }
        return;
    }

    public function editKindergarten($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    if($currentSchool['state'] == 1) { // Eğer okulu admin eklemişse diye sonradan token göndermek için
                        $this->sendConfirmationEmail($post['school_email'], $currentSchool['token'], $link);
                    }


                    $content = htmlspecialchars($_POST['content']);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    // Update School Info
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('school', array(
                        'state' => isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                        'name' => $post['school_name'],
                        'school_email' => $post['school_email'],
                        'contact_email' => $post['contact_email'],
                        'phone' => $post['phone'],
                        'address' => $post['address'],
                        'sehir_key' => $post['city'],
                        'ilce_key' => $post['town'],
                        'mahalle_key' => $post['subtown'],
                        'transportation' => $post['service'],
                        'discount' => $post['discount'],
                        'counselor' => $post['counselor'],
                        'age_interval' => $post['start_age'].' - '.$post['end_age'],
                        'class_quota' => $post['quota'],
                        'price' => $post['price'],
                        'priority' => $post['priority'],
                        'tax_no' => $post['tax_no'],
                        'description' => $content,
                        'facebook' => $post['facebook'],
                        'twitter' => $post['twitter'],
                        'instagram' => $post['instagram'],
                        'link' => $sefLink
                    ), $link);

                    //Update School Owner
                    $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_owner',
                        array('school_id', 'user_id'),
                        array($currentSchoolId,
                            isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                : $_SESSION['user_data']['user_id']));

                    // Update school hours
                    $this->deleteByColumn('school_hours', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_hours',
                        array('school_id', 'monday_start', 'monday_end', 'tuesday_start', 'tuesday_end',
                            'wednesday_start', 'wednesday_end', 'thursday_start', 'thursday_end', 'friday_start', 'friday_end'),
                        array($currentSchoolId, $post['monday_start'], $post['monday_end'], $post['tuesday_start'], $post['tuesday_end'],
                            $post['wednesday_start'], $post['wednesday_end'], $post['thursday_start'], $post['thursday_end'],
                            $post['friday_start'], $post['friday_end']));

                    // Update school facilities
                    $this->deleteByColumn('school_facility', 'school_id', $currentSchoolId);
                    $this->execute();
                    $facs = $post['facs'];
                    foreach($facs as $facility) {
                        $this->save('school_facility',
                            array('school_id', 'facility_id'),
                            array($currentSchoolId, +$facility));
                    }

                    // Update school tranportation points
                    $this->deleteByColumn('transportation_point', 'school_id', $currentSchoolId);
                    $this->execute();
                    $servc = $post['servc'];
                    foreach($servc as $tpoint) {
                        $this->save('transportation_point',
                            array('school_id', 'ilce_key'),
                            array($currentSchoolId, +$tpoint));
                    }

                    // Adding school gallery
                    $this->deleteByColumn('school_gallery', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_gallery',
                        array('school_id', 'gallery_id'),
                        array($currentSchoolId, $post['gallery']));

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Anaokulu Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/kindergarten";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Anaokulu Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
        }
        return;
    }

    private function sendConfirmationEmail($email, $schoolToken, $schoolLink) {
        $buttonRedirectLink = "https://www.rehberokul.com/okul-dogrulama/".$schoolLink."/".$schoolToken;
        // DB'deki demand satırındaki email adresine mail yolla
        define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
        require '../php/Forms/PHPMailer/PHPMailerAutoload.php';
        require_once('../php/Forms/Classes/EmailOperations.php');
        require_once('../php/Classes/MysqliDb.php');

        $db = new MysqliDb('localhost', 'rehberok_web_user', 'P(ie*igC*juoRehberO', 'rehberok_web_db');
        $emailOps = new EmailOperations;

        $db->where('link', $schoolLink);
        $school = $db->getOne('school');

        $dbtatus = true;

        if ($dbtatus) {
            $senderHost = gethostbyname("mail.rehberokul.com");
            $senderHostPort = 587;
            $senderTitle = "Rehber Okul";
            $senderEmail = "no-reply@rehberokul.com";
            $senderPassword = "noreply+47712116";
            $mailSubject = "Okul E-Postanızı Doğrulayın!";

            $receiverEmail = $email;

            $mailHtmlContent = '<div class="email-tem" style="background: #efefef;width: 100%;position: relative;overflow: hidden;">
<div class="email-tem-inn" style="margin: 0 auto;padding: 50px;background: #ffffff;">
<div class="email-tem-main" style="background: #fdfdfd;box-shadow: 0px 10px 24px -10px rgba(0, 0, 0, 0.8);margin-bottom: 50px;border-radius: 10px;">
<div class="email-tem-head" style=" width: 100%;background: #006df0 url(\'https://www.rehberokul.com/images/mail/bg.png\') repeat;padding: 50px;box-sizing: border-box;border-radius: 5px 5px 0px 0px;">
<h2 style="color: #fff;font-size: calc(16px - 0.1em);text-transform: capitalize;"><img style="float: left;padding-right: 25px;width: calc(90px + 0.5em);;" src="https://www.rehberokul.com/images/mail/letter.png" alt=""></h2>
</div>
<div class="email-tem-body" style="padding-top: 50px; padding-bottom: 50px;padding-left: 20px;">
<h3 style="margin-bottom: 25px; width: 100%;">'.$mailSubject.'</h3>
<p style="width: 100%;">Merhaba '.$school['name'].',</p>
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

    public function addKindergarten() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    //$spot = str_replace("&#39;","''",$post['spot']);
                    $content = htmlspecialchars($_POST['content']);
                    $content = str_replace("'", "''", $content);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    $token = $this->createToken($post['school_email']);
                    // Adding a school
                    $this->save('school',
                        array('token','discount', 'type', 'state', 'name', 'school_email', 'contact_email', 'phone', 'address',
                            'sehir_key', 'ilce_key', 'mahalle_key', 'transportation', 'counselor', 'age_interval', 'class_quota',
                            'price', 'package', 'priority', 'tax_no', 'description', 'facebook', 'twitter', 'instagram', 'link'),
                        array($token, $post['discount'],1, isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                            $post['school_name'], $post['school_email'], $post['contact_email'], $post['phone'], $post['address'],
                            $post['city'], $post['town'],  $post['subtown'], $post['service'],  $post['counselor'],
                            $post['start_age'].' - '.$post['end_age'],  $post['quota'], $post['price'], '', $post['priority'],
                            $post['tax_no'], $content, $post['facebook'], $post['twitter'], $post['instagram'], $sefLink));
                    // Last added school id
                    $addedSchoolId = $this->lastInsertId();


                    $this->sendConfirmationEmail($post['school_email'], $token, $sefLink);

                    // Adding school owner
                    $this->save('school_owner',
                        array('school_id', 'user_id'),
                        array($addedSchoolId,
                            isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                : $_SESSION['user_data']['user_id']));

                    // Adding school hours
                    $this->save('school_hours',
                        array('school_id', 'monday_start', 'monday_end', 'tuesday_start', 'tuesday_end',
                            'wednesday_start', 'wednesday_end', 'thursday_start', 'thursday_end', 'friday_start', 'friday_end'),
                        array($addedSchoolId, $post['monday_start'], $post['monday_end'], $post['tuesday_start'], $post['tuesday_end'],
                            $post['wednesday_start'], $post['wednesday_end'], $post['thursday_start'], $post['thursday_end'],
                            $post['friday_start'], $post['friday_end']));

                    // Adding school facilities
                    $facs = $post['facs'];
                    foreach($facs as $facility) {
                        $this->save('school_facility',
                            array('school_id', 'facility_id'),
                            array($addedSchoolId, +$facility));
                    }

                    // Adding school tranportation points
                    $servc = $post['servc'];
                    foreach($servc as $tpoint) {
                        $this->save('transportation_point',
                            array('school_id', 'ilce_key'),
                            array($addedSchoolId, +$tpoint));
                    }

                    // Adding school gallery
                    $this->save('school_gallery',
                        array('school_id', 'gallery_id'),
                        array($addedSchoolId, $post['gallery']));



                    $this->databaseHandler->commit();
                    Message::setMessage('Anaokulu Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/kindergarten";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Anaokulu Mevcut Olabilir!'.$e->getMessage(), 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'schools/kindergarten";</script>';
        }
        return;
    }

    public function deleteKindergarten($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    // Delete School Gallery
                    $this->deleteByColumn('school_gallery', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Transportation Points
                    $this->deleteByColumn('transportation_point', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Facilities
                    $this->deleteByColumn('school_facility', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Hours
                    $this->deleteByColumn('school_hours', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Owner
                    $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Hours
                    $this->deleteByColumn('school', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Anaokulu Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/kindergarten";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'schools/kindergarten";</script>';
        }
        return;
    }


    public function editMiddle($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();

                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    if($currentSchool['state'] == 1) {
                        $this->sendConfirmationEmail($post['school_email'], $currentSchool['token'], $link);
                    }

                    $content = htmlspecialchars($_POST['content']);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    // Update School Info
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('school', array(
                        'type' => $post['school_type'],
                        'state' => isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                        'name' => $post['school_name'],
                        'school_email' => $post['school_email'],
                        'contact_email' => $post['contact_email'],
                        'phone' => $post['phone'],
                        'address' => $post['address'],
                        'sehir_key' => $post['city'],
                        'ilce_key' => $post['town'],
                        'mahalle_key' => $post['subtown'],
                        'transportation' => $post['service'],
                        'discount' => $post['discount'],
                        'counselor' => $post['counselor'],
                        'class_quota' => $post['quota'],
                        'price' => $post['price'],
                        'priority' => $post['priority'],
                        'tax_no' => $post['tax_no'],
                        'description' => $content,
                        'facebook' => $post['facebook'],
                        'twitter' => $post['twitter'],
                        'instagram' => $post['instagram'],
                        'link' => $sefLink
                    ), $link);

                    //Update School Owner
                    $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_owner',
                        array('school_id', 'user_id'),
                        array($currentSchoolId,
                            isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                : $_SESSION['user_data']['user_id']));

                    // Update school hours
                    $this->deleteByColumn('school_hours', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_hours',
                        array('school_id', 'monday_start', 'monday_end', 'tuesday_start', 'tuesday_end',
                            'wednesday_start', 'wednesday_end', 'thursday_start', 'thursday_end', 'friday_start', 'friday_end'),
                        array($currentSchoolId, $post['monday_start'], $post['monday_end'], $post['tuesday_start'], $post['tuesday_end'],
                            $post['wednesday_start'], $post['wednesday_end'], $post['thursday_start'], $post['thursday_end'],
                            $post['friday_start'], $post['friday_end']));

                    // Update school facilities
                    $this->deleteByColumn('school_facility', 'school_id', $currentSchoolId);
                    $this->execute();
                    $facs = $post['facs'];
                    foreach($facs as $facility) {
                        $this->save('school_facility',
                            array('school_id', 'facility_id'),
                            array($currentSchoolId, +$facility));
                    }

                    // Update school tranportation points
                    $this->deleteByColumn('transportation_point', 'school_id', $currentSchoolId);
                    $this->execute();
                    $servc = $post['servc'];
                    foreach($servc as $tpoint) {
                        $this->save('transportation_point',
                            array('school_id', 'ilce_key'),
                            array($currentSchoolId, +$tpoint));
                    }

                    // Adding school gallery
                    $this->deleteByColumn('school_gallery', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_gallery',
                        array('school_id', 'gallery_id'),
                        array($currentSchoolId, $post['gallery']));

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Okul Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/middle";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Okul Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
        }
        return;
    }

    public function addMiddle() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    //$spot = str_replace("&#39;","''",$post['spot']);
                    $content = htmlspecialchars($_POST['content']);
                    $content = str_replace("'", "''", $content);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    $token = $this->createToken($post['school_email']);
                    // Adding a school
                    $this->save('school',
                        array('token','discount', 'type', 'state', 'name', 'school_email', 'contact_email', 'phone', 'address',
                            'sehir_key', 'ilce_key', 'mahalle_key', 'transportation', 'counselor', 'class_quota',
                            'price', 'package', 'priority', 'tax_no', 'description', 'facebook', 'twitter', 'instagram', 'link'),
                        array($token, $post['discount'], $post['school_type'], isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                            $post['school_name'], $post['school_email'], $post['contact_email'], $post['phone'], $post['address'],
                            $post['city'], $post['town'],  $post['subtown'], $post['service'],  $post['counselor'],
                            $post['quota'], $post['price'], '', $post['priority'], $post['tax_no'], $content,
                            $post['facebook'], $post['twitter'], $post['instagram'], $sefLink));
                    // Last added school id
                    $addedSchoolId = $this->lastInsertId();

                    $this->sendConfirmationEmail($post['school_email'], $token, $sefLink);

                    // Adding school owner
                    $this->save('school_owner',
                        array('school_id', 'user_id'),
                        array($addedSchoolId,
                            isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                : $_SESSION['user_data']['user_id']));

                    // Adding school hours
                    $this->save('school_hours',
                        array('school_id', 'monday_start', 'monday_end', 'tuesday_start', 'tuesday_end',
                            'wednesday_start', 'wednesday_end', 'thursday_start', 'thursday_end', 'friday_start', 'friday_end'),
                        array($addedSchoolId, $post['monday_start'], $post['monday_end'], $post['tuesday_start'], $post['tuesday_end'],
                            $post['wednesday_start'], $post['wednesday_end'], $post['thursday_start'], $post['thursday_end'],
                            $post['friday_start'], $post['friday_end']));

                    // Adding school facilities
                    $facs = $post['facs'];
                    foreach($facs as $facility) {
                        $this->save('school_facility',
                            array('school_id', 'facility_id'),
                            array($addedSchoolId, +$facility));
                    }

                    // Adding school tranportation points
                    $servc = $post['servc'];
                    foreach($servc as $tpoint) {
                        $this->save('transportation_point',
                            array('school_id', 'ilce_key'),
                            array($addedSchoolId, +$tpoint));
                    }

                    // Adding school gallery
                    $this->save('school_gallery',
                        array('school_id', 'gallery_id'),
                        array($addedSchoolId, $post['gallery']));

                    $this->databaseHandler->commit();
                    Message::setMessage('Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/middle";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Okul Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'schools/middle";</script>';
        }
        return;
    }

    public function deleteMiddle($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    // Delete School Gallery
                    $this->deleteByColumn('school_gallery', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Transportation Points
                    $this->deleteByColumn('transportation_point', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Facilities
                    $this->deleteByColumn('school_facility', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Hours
                    $this->deleteByColumn('school_hours', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Owner
                    $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Hours
                    $this->deleteByColumn('school', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/middle";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'schools/middle";</script>';
        }
        return;
    }

    public function editHigh($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();

                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    if($currentSchool['state'] == 1) {
                        $this->sendConfirmationEmail($post['school_email'], $currentSchool['token'], $link);
                    }

                    $content = htmlspecialchars($_POST['content']);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    // Update School Info
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('school', array(
                        'state' => isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                        'name' => $post['school_name'],
                        'school_email' => $post['school_email'],
                        'contact_email' => $post['contact_email'],
                        'phone' => $post['phone'],
                        'address' => $post['address'],
                        'sehir_key' => $post['city'],
                        'ilce_key' => $post['town'],
                        'mahalle_key' => $post['subtown'],
                        'transportation' => $post['service'],
                        'discount' => $post['discount'],
                        'counselor' => $post['counselor'],
                        'class_quota' => $post['quota'],
                        'price' => $post['price'],
                        'priority' => $post['priority'],
                        'tax_no' => $post['tax_no'],
                        'description' => $content,
                        'facebook' => $post['facebook'],
                        'twitter' => $post['twitter'],
                        'instagram' => $post['instagram'],
                        'link' => $sefLink
                    ), $link);

                    //Update School Owner
                    $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_owner',
                        array('school_id', 'user_id'),
                        array($currentSchoolId,
                            isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                : $_SESSION['user_data']['user_id']));

                    // Update school hours
                    $this->deleteByColumn('school_hours', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_hours',
                        array('school_id', 'monday_start', 'monday_end', 'tuesday_start', 'tuesday_end',
                            'wednesday_start', 'wednesday_end', 'thursday_start', 'thursday_end', 'friday_start', 'friday_end'),
                        array($currentSchoolId, $post['monday_start'], $post['monday_end'], $post['tuesday_start'], $post['tuesday_end'],
                            $post['wednesday_start'], $post['wednesday_end'], $post['thursday_start'], $post['thursday_end'],
                            $post['friday_start'], $post['friday_end']));

                    // Update school facilities
                    $this->deleteByColumn('school_facility', 'school_id', $currentSchoolId);
                    $this->execute();
                    $facs = $post['facs'];
                    foreach($facs as $facility) {
                        $this->save('school_facility',
                            array('school_id', 'facility_id'),
                            array($currentSchoolId, +$facility));
                    }

                    // Update school tranportation points
                    $this->deleteByColumn('transportation_point', 'school_id', $currentSchoolId);
                    $this->execute();
                    $servc = $post['servc'];
                    foreach($servc as $tpoint) {
                        $this->save('transportation_point',
                            array('school_id', 'ilce_key'),
                            array($currentSchoolId, +$tpoint));
                    }

                    // Adding school gallery
                    $this->deleteByColumn('school_gallery', 'school_id', $currentSchoolId);
                    $this->execute();
                    $this->save('school_gallery',
                        array('school_id', 'gallery_id'),
                        array($currentSchoolId, $post['gallery']));

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Lise Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/high";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Lise Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
        }
        return;
    }

    private function createToken($inputValue) {
        $returnValue = sha1(URLHelper::seflinkGenerator($inputValue).uniqid());
        return $returnValue;
    }

    public function addHigh() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    //$spot = str_replace("&#39;","''",$post['spot']);
                    $content = htmlspecialchars($_POST['content']);
                    $content = str_replace("'", "''", $content);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    $token = $this->createToken($post['school_email']);
                    // Adding a school
                    $this->save('school',
                        array('token','discount', 'type', 'state', 'name', 'school_email', 'contact_email', 'phone', 'address',
                            'sehir_key', 'ilce_key', 'mahalle_key', 'transportation', 'counselor', 'class_quota',
                            'price', 'package', 'priority', 'tax_no', 'description', 'facebook', 'twitter', 'instagram', 'link'),
                        array($token, $post['discount'], 4, isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                            $post['school_name'], $post['school_email'], $post['contact_email'], $post['phone'], $post['address'],
                            $post['city'], $post['town'],  $post['subtown'], $post['service'],  $post['counselor'],
                            $post['quota'], $post['price'], '', $post['priority'], $post['tax_no'], $content,
                            $post['facebook'], $post['twitter'], $post['instagram'], $sefLink));
                    // Last added school id
                    $addedSchoolId = $this->lastInsertId();


                    $this->sendConfirmationEmail($post['school_email'], $token, $sefLink);

                    // Adding school owner
                    $this->save('school_owner',
                        array('school_id', 'user_id'),
                        array($addedSchoolId,
                            isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                : $_SESSION['user_data']['user_id']));

                    // Adding school hours
                    $this->save('school_hours',
                        array('school_id', 'monday_start', 'monday_end', 'tuesday_start', 'tuesday_end',
                            'wednesday_start', 'wednesday_end', 'thursday_start', 'thursday_end', 'friday_start', 'friday_end'),
                        array($addedSchoolId, $post['monday_start'], $post['monday_end'], $post['tuesday_start'], $post['tuesday_end'],
                            $post['wednesday_start'], $post['wednesday_end'], $post['thursday_start'], $post['thursday_end'],
                            $post['friday_start'], $post['friday_end']));

                    // Adding school facilities
                    $facs = $post['facs'];
                    foreach($facs as $facility) {
                        $this->save('school_facility',
                            array('school_id', 'facility_id'),
                            array($addedSchoolId, +$facility));
                    }

                    // Adding school tranportation points
                    $servc = $post['servc'];
                    foreach($servc as $tpoint) {
                        $this->save('transportation_point',
                            array('school_id', 'ilce_key'),
                            array($addedSchoolId, +$tpoint));
                    }

                    // Adding school gallery
                    $this->save('school_gallery',
                        array('school_id', 'gallery_id'),
                        array($addedSchoolId, $post['gallery']));


                    $this->databaseHandler->commit();
                    Message::setMessage('Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/high";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Lise Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'schools/high";</script>';
        }
        return;
    }

    public function deleteHigh($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    // Delete School Gallery
                    $this->deleteByColumn('school_gallery', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Transportation Points
                    $this->deleteByColumn('transportation_point', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Facilities
                    $this->deleteByColumn('school_facility', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Hours
                    $this->deleteByColumn('school_hours', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Owner
                    $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                    $this->execute();

                    // Delete School Hours
                    $this->deleteByColumn('school', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Lise Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'schools/high";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'schools/high";</script>';
        }
        return;
    }

}

