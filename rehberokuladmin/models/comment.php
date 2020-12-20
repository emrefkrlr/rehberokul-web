<?php
class CommentModel extends DBOperation {
    public static $roles;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function getCommentator($user_id) {
        $this->findByColumn('user', 'id', $user_id);
        $commentator = $this->single();
        return $commentator;
    }

    public function getSchoolName($school_id) {
        $this->findByColumn('school', 'id', $school_id);
        $school = $this->single();
        return $school['name'];
    }



    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('comment');
            $this->where('school_id', 0, 'NOT');
            $this->orderBy('publish_date', 'DESC');
            $comments = $this->resultSet();
            return $comments;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('comment', 'link', $link);
            $comment = $this->single();
            if($comment) {
                return $comment;
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
            $this->findByColumn('comment', 'link', $link);
            $comment = $this->single();
            if($comment) {
                return $comment;
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
            $this->findByColumn('comment', 'link', $link);
            $comment = $this->single();
            if($comment) {
                return $comment;
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
                    $this->updateByColumn('comment', array(
                        'state' => $post['state'],
                        'comment' => $post['comment']
                    ), $link);

                    // Adding a notification, Admin yorumu onayladığında, All notificationsa notification kaydı düş
                    if($post['state'] == 1) {
                        $this->findByColumn('comment', 'link', $link);
                        $comment = $this->single();
                        $this->findByColumn('school_owner', 'school_id', $comment['school_id']);
                        $owner_school = $this->single();
                        $this->save('all_user_notifications',
                            array('user_id', 'school_type', 'interested_user', 'type', 'url', 'title', 'content', 'link'),
                            array(+$owner_school['user_id'], '999', '1', 'comment', $comment['comment_url'],
                                'Yeni Bir Yorumunuz Var! ', $post['comment'], $link));
                    }



                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Yorum Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'comment";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Yorum Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'comment";</script>';
        }
        return;
    }


    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->deleteByColumn('comment', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Yorum Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'comment";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'comment";</script>';
        }
        return;
    }

}

