<?php
class BuyModel extends DBOperation {
    public static $schools;
    public static $cart;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function getSum() {
        $this->sum('cart', 'price');
        $this->where('user_id', $_SESSION['user_data']['user_id']);
        $sum = $this->single();
        return $sum['sum'];
    }

    public function getKDV() {
        $this->sum('cart', 'price');
        $this->where('user_id', $_SESSION['user_data']['user_id']);
        $sum = $this->single();
        return ($sum['sum']*18)/100;
    }

    public function getTotal() {
        $total = $this->getKDV() + $this->getSum();
        if($total > 10000) {
            $total = $total - (($total*20)/100);
        }
        return $total;
    }

    public function getDiscount() {
        $total = $this->getKDV() + $this->getSum();
        return $total-$this->getTotal();
    }

    public function getSchools() {
        $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
        $owner_schools = $this->resultSet();
        $schools = array();
        foreach ($owner_schools as $owner_school) {
            $this->findByColumn('payment', 'school_id', $owner_school['school_id']);
            $this->addAndClause('state', 0, 'NOT');
            $this->orderBy('payment_time', 'DESC');
            $school_payment = $this->single();
            $this->findByColumn('cart', 'school_id', $owner_school['school_id']);
            $cart_school = $this->single();
            if(strtotime($school_payment['end_date']) < time() && !$cart_school && $school_payment['state'] != 1) {
                $this->findByColumn('school', 'id', $owner_school['school_id']);
                $this->addAndClause('state', 2);
                $schools[] = $this->single();
            }
        }
        self::$schools = $schools;
    }

    public function getSchoolName($school_id) {
        $this->findByColumn('school', 'id', $school_id);
        $school = $this->single();
        return $school['name'];
    }

    public function getCart() {
        $this->findByColumn('cart', 'user_id', $_SESSION['user_data']['user_id']);
        self::$cart = $this->resultSet();
    }


    public function index() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->getSchools();
            $this->getCart();
            $this->findByColumn('payment', 'user_id', $_SESSION['user_data']['user_id']);
            $this->orderBy('id', 'DESC'); // En son ödeme
            $payment = $this->resultSet();
            return $payment;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    private function generateRandomString($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function add($type) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {

            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Satın Alma Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'buy";</script>';
        }
        return;
    }

}

