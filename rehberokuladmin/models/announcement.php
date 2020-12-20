<?php
class AnnouncementModel extends DBOperation {
    public static $roles;
    public static $ownerSchools;
    public static $announcementSchools;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }


    public function getUserSchools() {
        $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
        $schoolIds = $this->resultSet();
        $schools = array();
        foreach ($schoolIds as $schoolId) {
            $this->findByColumn('school', 'id', $schoolId['school_id']);
            $this->addAndClause('state', 2);
            $school = $this->single();
            $schools[] = $school;
        }
        self::$ownerSchools = $schools;
    }

    public function setAnnouncementSchools($announcement_id) {
        $this->findByColumn('announcement_school', 'announcement_id', $announcement_id);
        self::$announcementSchools = $this->resultSet();
    }


    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('announcement', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('create_date', 'DESC');
            $announcements = $this->resultSet();
            return $announcements;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('announcement', 'link', $link);
            $announcement = $this->single();
            $this->getUserSchools();
            $this->setAnnouncementSchools($announcement['id']);
            if($announcement) {
                return $announcement;
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
            $this->getUserSchools();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('announcement', 'link', $link);
            $announcement = $this->single();
            $this->getUserSchools();
            $this->setAnnouncementSchools($announcement['id']);
            if($announcement) {
                return $announcement;
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
            $this->findByColumn('announcement', 'link', $link);
            $announcement = $this->single();
            $this->getUserSchools();
            $this->setAnnouncementSchools($announcement['id']);
            if($announcement) {
                return $announcement;
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
                    $this->findByColumn('announcement', 'link', $link);
                    $currentAnnouncement = $this->single();
                    $currentAnnouncementId = $currentAnnouncement['id'];
                    $date = new DateTime('now');
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('announcement', array(
                        'state' => $post['state'],
                        'title' => $post['title'],
                        'content' => $post['content'],
                        'end_date' => $post['end_date'],
                        'link' => URLHelper::seflinkGenerator($post['title'].'-'.$date->format('Y-m-d H:i:s'))
                    ), $link);

                    $this->deleteByColumn('announcement_school', 'announcement_id', $currentAnnouncementId);
                    $this->execute();
                    $schools = $post['school'];
                    foreach($schools as $school) {

                        $this->findByColumn('parents_fav_school', 'school_id', $school);
                        $schoolObj = $this->single();
                        $this->findByColumn('all_user_notifications', 'type', 'announcement');
                        $this->addAndClause('school_id', $school);
                        $this->addAndClause('user_id', +$schoolObj['user_id']);
                        $notificationExist = $this->single();
                        // Eğer duyuruya dair herhangi bir şey değişirse gönder, farklı okul kaydı varsa gönder, aynı okul ve duyuruda değişiklik yoksa gönderme
                        if($currentAnnouncement['title'] != $post['title'] || $currentAnnouncement['content'] != $post['content'] ||
                            $currentAnnouncement['end_date'] != $post['end_date'] || ($schoolObj && $post['state'] == 1 && !$notificationExist)) {
                            $this->save('all_user_notifications',
                                array('school_id', 'user_id', 'school_type', 'interested_user', 'end_date', 'type', 'title', 'content', 'link'),
                                array($school, +$schoolObj['user_id'],'999', '1',$post['end_date'], 'announcement', $post['title'],
                                    $post['content'], URLHelper::seflinkGenerator($post['title'].'-'.$date->format('Y-m-d H:i:s'))));
                        }

                        $this->save('announcement_school',
                            array('school_id', 'announcement_id'),
                            array($school, $currentAnnouncementId));
                    }

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Duyuru/Etkinlik Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'announcement";</script>';
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
            echo '<script>window.location.href ="'.ROOT_URL.'announcement";</script>';
        }
        return;
    }

    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $date = new DateTime('now');
                    // Adding an announcement
                    $this->save('announcement',
                        array('title', 'content', 'user_id', 'end_date', 'state', 'link'),
                        array($post['title'], $post['content'], $_SESSION['user_data']['user_id'], $post['end_date'], $post['state'], URLHelper::seflinkGenerator($post['title'].'-'.$date->format('Y-m-d H:i:s'))));
                    // Added announcement id
                    $announcementId = $this->lastInsertId();

                    $schools = $post['school'];
                    foreach($schools as $school) {
                        $this->findByColumn('parents_fav_school', 'school_id', $school);
                        $schoolObj = $this->single();
                        if($schoolObj) {
                            $this->save('all_user_notifications',
                                array('school_id', 'user_id', 'school_type', 'interested_user', 'end_date', 'type', 'title', 'content', 'link'),
                                array($school, +$schoolObj['user_id'],'999', '1',$post['end_date'], 'announcement', $post['title'],
                                    $post['content'], URLHelper::seflinkGenerator($post['title'].'-'.$date->format('Y-m-d H:i:s'))));
                        }


                        $this->save('announcement_school',
                            array('school_id', 'announcement_id'),
                            array($school, $announcementId));
                    }



                    $this->databaseHandler->commit();
                    Message::setMessage('Duyuru/Etkinlik Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'announcement";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Soru Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'announcement";</script>';
        }
        return;
    }

    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->findByColumn('announcement', 'link', $link);
                    $currentAnnouncement = $this->single();
                    $currentAnnouncementId = $currentAnnouncement['id'];
                    $this->deleteByColumn('announcement_school', 'announcement_id', $currentAnnouncementId);
                    $this->execute();

                    $this->deleteByColumn('announcement', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Duyuru/Etkinlik Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'announcement";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'announcement";</script>';
        }
        return;
    }

}

