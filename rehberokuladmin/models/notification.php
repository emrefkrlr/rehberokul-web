<?php
class NotificationModel extends DBOperation {
    public static $roles;
    public static $users;
    public static $private_notifications;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function setUsers() {
        $this->findByColumn('user', 'role_id', 1, 'NOT');
        $users = $this->resultSet();
        self::$users = $users;
    }

    public function setPrivateNotifications($notification_id) {
        $this->findByColumn('sent_notifications', 'notification_id', $notification_id);
        $users = $this->resultSet();
        self::$private_notifications = $users;
    }


    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('notification', 'state', 1);
            $this->orderBy('publish_date', 'desc');
            $notifications = $this->resultSet();
            return $notifications;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('notification', 'link', $link);
            $notification = $this->single();
            $this->setUsers();
            $this->setPrivateNotifications($notification['id']);
            if($notification) {
                return $notification;
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
            $this->setUsers();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('notification', 'link', $link);
            $notification = $this->single();
            $this->setUsers();
            $this->setPrivateNotifications($notification['id']);
            if($notification) {
                return $notification;
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
            $this->findByColumn('notification', 'link', $link);
            $notification = $this->single();
            $this->setUsers();
            $this->setPrivateNotifications($notification['id']);
            if($notification) {
                return $notification;
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

                    $date = new DateTime('now');

                    // Adding a notification
                    $this->save('notification',
                        array('title', 'content', 'send_type', 'send_to', 'link'),
                        array($post['title'], $post['content'], $post['send_type'], +$post['send_to_multi'],
                            URLHelper::seflinkGenerator($post['title'] . '-' . $date->format('Y-m-d H:i:s'))));
                    // Last added notification id
                    $addedNotificationId = $this->lastInsertId();

                    // Adding sent notifications
                    if ($post['send_type'] == '1') { // Massive Sending
                        if($post['send_to_multi'] == '1') { // Parents
                            $this->findByColumn('user', 'role_id', 3);
                            $parents = $this->resultSet();
                            foreach ($parents as $parentSingle) {
                                $this->save('sent_notifications',
                                    array('notification_id', 'sent_user_id'),
                                    array($addedNotificationId, +$parentSingle['id']));
                            }
                        } else { // Owners
                            $this->findByColumn('user', 'role_id', 2);
                            $owners = $this->resultSet();
                            foreach ($owners as $owner) {
                                $this->save('sent_notifications',
                                    array('notification_id', 'sent_user_id'),
                                    array($addedNotificationId, +$owner['id']));
                            }
                        }
                    } else { // Private Sending
                        $notifications = $post['send_to'];
                        foreach ($notifications as $notification) {
                            $this->save('sent_notifications',
                                array('notification_id', 'sent_user_id'),
                                array($addedNotificationId, +$notification['id']));
                        }
                    }

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Bildirim Tekrar Gönderildi!', 'success');
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
            Message::setMessage('Gönderim Başarısız! <br />Bildirim Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'notification";</script>';
        }
        return;
    }

    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                if (isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $date = new DateTime('now');

                    // Adding a notification
                    $this->save('notification',
                        array('title', 'content', 'send_type', 'send_to', 'link'),
                        array($post['title'], $post['content'], $post['send_type'], +$post['send_to_multi'],
                            URLHelper::seflinkGenerator($post['title'] . '-' . $date->format('Y-m-d H:i:s'))));
                    // Last added notification id
                    $addedNotificationId = $this->lastInsertId();



                    // Adding sent notifications
                    if ($post['send_type'] == '1') { // Massive Sending
                        if($post['send_to_multi'] == '1') { // Parents
                            $this->findByColumn('user', 'role_id', 3);
                            $parents = $this->resultSet();
                            foreach ($parents as $parentSingle) {
                                $this->save('sent_notifications',
                                    array('notification_id', 'sent_user_id'),
                                    array($addedNotificationId, +$parentSingle['id']));

                                // Adding a notification, Admin Bildirim Gönderdiğinde Topluca Velilere, All notificationsa notification kaydı düş
                                $this->save('all_user_notifications',
                                    array('user_id', 'school_type', 'interested_user', 'type', 'title', 'content', 'link'),
                                    array(+$parentSingle['id'], '999', '1', 'notification', $post['title'], $post['content'],
                                        URLHelper::seflinkGenerator($post['title'] . '-' . $date->format('Y-m-d H:i:s'))));
                            }
                        } else { // Owners
                            $this->findByColumn('user', 'role_id', 2);
                            $owners = $this->resultSet();
                            foreach ($owners as $owner) {
                                $this->save('sent_notifications',
                                    array('notification_id', 'sent_user_id'),
                                    array($addedNotificationId, +$owner['id']));

                                // Adding a notification, Admin Bildirim Gönderdiğinde Topluca Kurum Sahiplerine, All notificationsa notification kaydı düş
                                $this->save('all_user_notifications',
                                    array('user_id', 'school_type', 'interested_user', 'type', 'title', 'content', 'link'),
                                    array(+$owner['id'], '999', '1', 'notification', $post['title'], $post['content'],
                                        URLHelper::seflinkGenerator($post['title'] . '-' . $date->format('Y-m-d H:i:s'))));
                            }
                        }
                    } else { // Private Sending
                        $notifications = $post['send_to'];
                        foreach ($notifications as $notification) {
                            $this->save('sent_notifications',
                                array('notification_id', 'sent_user_id'),
                                array($addedNotificationId, +$notification['id']));

                            // Adding a notification, Admin Bildirim Gönderdiğinde Özel Olarak, All notificationsa notification kaydı düş
                            $this->save('all_user_notifications',
                                array('user_id', 'school_type', 'interested_user', 'type', 'title', 'content', 'link'),
                                array(+$notification['id'], '999', '1', 'notification', $post['title'], $post['content'],
                                    URLHelper::seflinkGenerator($post['title'] . '-' . $date->format('Y-m-d H:i:s'))));

                        }
                    }
                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Bildirim Başarıyla Gönderildi!', 'success');
                    echo '<script>window.location.href ="' . ROOT_URL . 'notification";</script>';
                } else {
                    echo '<script>window.location.href ="' . ROOT_URL . '";</script>';
                    return;
                }
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Gönderme Başarısız! <br />Bildirim Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'notification";</script>';
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

