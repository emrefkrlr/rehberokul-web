<?php
class SchoolModel extends DBOperation {
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
            $this->findByColumn('gallery', 'isdir', 1);
            self::$galleries = $this->resultSet();
        } else {
            $this->findByColumn('gallery', 'user_id',$_SESSION['user_data']['user_id'] );
            $this->addAndClause('isdir', 1);
            self::$galleries = $this->resultSet();
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
            $this->findByColumn('school', 'type', 1);
            $this->orderBy('id', 'desc');
            $schools = $this->resultSet();
            return $schools;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function middle() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school', 'type', 2);
            $this->addOrClause('type', 3);
            $this->orderBy('id', 'desc');
            $schools = $this->resultSet();
            return $schools;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function high() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('school', 'type', 4);
            $this->orderBy('id', 'desc');
            $schools = $this->resultSet();
            return $schools;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function favorite() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('parents_fav_school', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('id', 'DESC');
            $schoolIds = $this->resultSet();
            $schools = array();
            foreach($schoolIds as $schoolId) {
                $this->findByColumn('school', 'id', $schoolId['school_id']);
                $this->addAndClause('state', 2);
                $schools[] = $this->single();
            }
            return $schools;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailFavorite($link) {
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

    public function viewDeleteFavorite($link) {
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

    public function deleteFavorite($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    // Current school
                    $this->findByColumn('school', 'link', $link);
                    $currentSchool = $this->single();
                    $currentSchoolId = $currentSchool['id'];

                    $this->deleteByColumn('parents_fav_school', 'school_id', $currentSchoolId);
                    $this->addAndClause('user_id', $_SESSION['user_data']['user_id']);
                    $this->execute();


                    $this->databaseHandler->commit();
                    Message::setMessage('Okul Favorilerinizden Kaldırıldı!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'school/favorite";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'school/favorite";</script>';
        }
        return;
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

                    $content = htmlspecialchars($_POST['content']);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    // Update School Info
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('school', array(
                        'state' => isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                        'admin_approved' => 1,
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
                    if($post['owner'] != -1) {
                        $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                        $this->execute();
                        $this->save('school_owner',
                            array('school_id', 'user_id'),
                            array($currentSchoolId,
                                isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                    : $_SESSION['user_data']['user_id']));
                    } else {
                        $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                        $this->execute();

                        $token = $this->createToken($post['school_email']);

                        $this->setWhereConditionForUpdate('link', $sefLink);
                        $this->updateByColumn('school', array(
                            'admin_approved' => 0,
                            'token' => $token
                        ), $sefLink);
                    }


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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/kindergarten";</script>';
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
                        array('admin_approved','token','discount', 'type', 'state', 'name', 'school_email', 'contact_email', 'phone', 'address',
                            'sehir_key', 'ilce_key', 'mahalle_key', 'transportation', 'counselor', 'age_interval', 'class_quota',
                            'price', 'package', 'priority', 'tax_no', 'description', 'facebook', 'twitter', 'instagram', 'link'),
                        array(1, $token, $post['discount'],1, isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                            $post['school_name'], $post['school_email'], $post['contact_email'], $post['phone'], $post['address'],
                            $post['city'], $post['town'],  $post['subtown'], $post['service'],  $post['counselor'],
                            $post['start_age'].' - '.$post['end_age'],  $post['quota'], $post['price'], '', $post['priority'],
                            $post['tax_no'], $content, $post['facebook'], $post['twitter'], $post['instagram'], $sefLink));
                    // Last added school id
                    $addedSchoolId = $this->lastInsertId();
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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/kindergarten";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Anaokulu Mevcut Olabilir!'.$e->getMessage(), 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'school/kindergarten";</script>';
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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/kindergarten";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'school/kindergarten";</script>';
        }
        return;
    }

    private function createToken($inputValue) {
        $returnValue = sha1(URLHelper::seflinkGenerator($inputValue).uniqid());
        return $returnValue;
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

                    $content = htmlspecialchars($_POST['content']);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    // Update School Info
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('school', array(
                        'type' => $post['school_type'],
                        'state' => isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                        'admin_approved' => 1,
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
                    if($post['owner'] != -1) {
                        $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                        $this->execute();
                        $this->save('school_owner',
                            array('school_id', 'user_id'),
                            array($currentSchoolId,
                                isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                    : $_SESSION['user_data']['user_id']));
                    } else {
                        $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                        $this->execute();

                        $token = $this->createToken($post['school_email']);

                        $this->setWhereConditionForUpdate('link', $sefLink);
                        $this->updateByColumn('school', array(
                            'admin_approved' => 0,
                            'token' => $token
                        ), $sefLink);
                    }

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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/middle";</script>';
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
                        array('admin_approved','token', 'discount', 'type', 'state', 'name', 'school_email', 'contact_email', 'phone', 'address',
                            'sehir_key', 'ilce_key', 'mahalle_key', 'transportation', 'counselor', 'class_quota',
                            'price', 'package', 'priority', 'tax_no', 'description', 'facebook', 'twitter', 'instagram', 'link'),
                        array(1, $token, $post['discount'], $post['school_type'], isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                            $post['school_name'], $post['school_email'], $post['contact_email'], $post['phone'], $post['address'],
                            $post['city'], $post['town'],  $post['subtown'], $post['service'],  $post['counselor'],
                            $post['quota'], $post['price'], '', $post['priority'], $post['tax_no'], $content,
                            $post['facebook'], $post['twitter'], $post['instagram'], $sefLink));
                    // Last added school id
                    $addedSchoolId = $this->lastInsertId();
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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/middle";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Okul Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'school/middle";</script>';
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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/middle";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'school/middle";</script>';
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

                    $content = htmlspecialchars($_POST['content']);
                    $sefLink = URLHelper::seflinkGenerator($post['school_name'].'-'.$post['city'].'-'.$post['town'].'-'.$post['subtown']);
                    // Update School Info
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('school', array(
                        'state' => isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                        'admin_approved' => 1,
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
                    if($post['owner'] != -1) {
                        $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                        $this->execute();
                        $this->save('school_owner',
                            array('school_id', 'user_id'),
                            array($currentSchoolId,
                                isset($post['owner']) && $post['owner'] != '' ? $post['owner']
                                    : $_SESSION['user_data']['user_id']));
                    } else {
                        $this->deleteByColumn('school_owner', 'school_id', $currentSchoolId);
                        $this->execute();

                        $token = $this->createToken($post['school_email']);

                        $this->setWhereConditionForUpdate('link', $sefLink);
                        $this->updateByColumn('school', array(
                            'admin_approved' => 0,
                            'token' => $token
                        ), $sefLink);
                    }

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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/high";</script>';
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
                        array('admin_approved', 'token', 'discount', 'type', 'state', 'name', 'school_email', 'contact_email', 'phone', 'address',
                            'sehir_key', 'ilce_key', 'mahalle_key', 'transportation', 'counselor', 'class_quota',
                            'price', 'package', 'priority', 'tax_no', 'description', 'facebook', 'twitter', 'instagram', 'link'),
                        array(1, $token, $post['discount'], 4, isset($post['approve']) && $post['approve'] != '' ? $post['approve'] : 1,
                            $post['school_name'], $post['school_email'], $post['contact_email'], $post['phone'], $post['address'],
                            $post['city'], $post['town'],  $post['subtown'], $post['service'],  $post['counselor'],
                            $post['quota'], $post['price'], '', $post['priority'], $post['tax_no'], $content,
                            $post['facebook'], $post['twitter'], $post['instagram'], $sefLink));
                    // Last added school id
                    $addedSchoolId = $this->lastInsertId();
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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/high";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Lise Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'school/high";</script>';
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
                    echo '<script>window.location.href ="'.ROOT_URL.'school/high";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'school/high";</script>';
        }
        return;
    }

}

