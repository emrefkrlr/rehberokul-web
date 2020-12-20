<?php
class LoginModel extends DBOperation {
    public function index() {
       
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if($post['ownerLoginArea'] == "Kurum"){
            $this->findByColumn('user', 'email', $post['email']);
            $user = $this->single();
            $this->findByColumn('role', 'role_id', $user['role_id']);
            $role = $this->single();
            
            date_default_timezone_set(TIME_ZONE);
            $date = new DateTime('now');
            if($user && $user['is_active'] && $user['password'] == hash("sha384", $post['password'])) {
                if ($user['role_id'] == 2) {
                    $_SESSION['is_logged_in'] = true; 
                
                    $_SESSION['user_data'] = 
                            [
                                'full_name'=>$user['first_name'].' '.$user['last_name'],
                                'email'=>$user['email'],
                                'user_id'=>$user['id'],
                                'role' => $role['role_name'],
                                'super' => $user['super_admin'],
                                'link' => $user['link']
                            ];
                    $this->setWhereConditionForUpdate('email', $user['email']);
                    $this->updateByColumn('user', array(
                            'is_online' => true,
                            'ip_address' => URLHelper::get_client_ip(),
                            'last_login_date' => $date->format('Y-m-d H:i:s'),
                            'user_agent' => $_SERVER['HTTP_USER_AGENT']
                        ), $user['email']);
                    echo $post['redirectUrl'];
                } else {
                    echo "login-kurum-error";
                }
                
            } else {
                echo "login-error";
            }
            exit();
        }

        if($post['redirectUrl']){
            $this->findByColumn('user', 'email', $post['email']);
            $user = $this->single();
            $this->findByColumn('role', 'role_id', $user['role_id']);
            $role = $this->single();
            
            date_default_timezone_set(TIME_ZONE);
            $date = new DateTime('now');
            if($user && $user['is_active'] && $user['password'] == hash("sha384", $post['password'])) {
                $_SESSION['is_logged_in'] = true; 
                
                $_SESSION['user_data'] = 
                        [
                            'full_name'=>$user['first_name'].' '.$user['last_name'],
                            'email'=>$user['email'],
                            'user_id'=>$user['id'],
                            'role' => $role['role_name'],
                            'super' => $user['super_admin'],
                            'link' => $user['link']
                        ];
                $this->setWhereConditionForUpdate('email', $user['email']);
                $this->updateByColumn('user', array(
                        'is_online' => true,
                        'ip_address' => URLHelper::get_client_ip(),
                        'last_login_date' => $date->format('Y-m-d H:i:s'),
                        'user_agent' => $_SERVER['HTTP_USER_AGENT']
                    ), $user['email']);
                echo "login-success";
            } else {
                echo "login-error";
            }
            exit();
        }

        if($post['submit']){
            $this->findByColumn('user', 'email', $post['email']);
            $user = $this->single();
            $this->findByColumn('role', 'role_id', $user['role_id']);
            $role = $this->single();
            
            date_default_timezone_set(TIME_ZONE);
            $date = new DateTime('now');
            if($user && $user['is_active'] && $user['password'] == hash("sha384", $post['password'])) {
                $_SESSION['is_logged_in'] = true; 
                
                $_SESSION['user_data'] = 
                        [
                            'full_name'=>$user['first_name'].' '.$user['last_name'],
                            'email'=>$user['email'],
                            'user_id'=>$user['id'],
                            'role' => $role['role_name'],
                            'super' => $user['super_admin'],
                            'link' => $user['link']
                        ];
                $this->setWhereConditionForUpdate('email', $user['email']);
                $this->updateByColumn('user', array(
                        'is_online' => true,
                        'ip_address' => URLHelper::get_client_ip(),
                        'last_login_date' => $date->format('Y-m-d H:i:s'),
                        'user_agent' => $_SERVER['HTTP_USER_AGENT']
                    ), $user['email']);
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            } else {
                Message::setMessage('Giriş Başarısız!', 'error');
            } 
        }
        return;
    }
}