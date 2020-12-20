<?php
class HomeModel extends DBOperation {
    public function index() {
        return;
    }

    public function getTodaysPurchase() {
        $count = 0;
        $this->findByColumn('payment', 'state', 0, 'NOT');
        $payments = $this->resultSet();
        foreach ($payments as $payment) {
            if(date('Ymd') == date('Ymd', strtotime($payment['payment_time']))) {
                $count = $count + 1;
            }
        }
        return $count;

    }

    public function getOwnerSchools() {
        $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
        $schools = $this->resultSet();
        return $schools;
    }

    public function getExecutiveSchools() {
        $this->findByColumn('school_executive', 'user_id', $_SESSION['user_data']['user_id']);
        $schools = $this->resultSet();
        return $schools;
    }

    public function getSchoolName($school_id) {
        $this->findByColumn('school', 'id', $school_id);
        $school = $this->single();
        return $school['name'];
    }

    public function getSchoolClickCount($school_id) {
        $this->findByColumn('school', 'id', $school_id);
        $school = $this->single();
        return $school['click_count'];
    }

    public function getSchoolDemandCount($school_id) {
        $this->count('demand');
        $this->where('school_id', $school_id);
        $demandCount = $this->single();
        return $demandCount['total'];
    }

    public function getSchoolCommentCount($school_id) {
        $this->count('comment');
        $this->where('school_id', $school_id);
        $commentCount = $this->single();
        return $commentCount['total'];
    }

    public function getSchoolPoints($school_id) {
        $this->findByColumn('school_points', 'school_id', $school_id);
        $schoolPoints = $this->resultSet();
        $this->findByColumn('school', 'id', $school_id);
        $beginningPoint = $this->single();
        $sum = $beginningPoint['points'];
        foreach ($schoolPoints as $schoolPoint) {
            $sum = $sum + $schoolPoint['point'];
        }
        $this->count('school_points');
        $this->where('school_id', $school_id);
        $totalCount = $this->single();
        $totalCount = $totalCount['total'] + 1;
        $average = $sum / $totalCount;
        return $average;
    }

    public function getSchoolsNotApproved() {
        $this->count('school');
        $this->where('state', 1);
        $count = $this->single();
        return $count['total'];
    }

    public function getDemandsNotApproved() {
        $this->count('demand');
        $this->where('state', 0);
        $count = $this->single();
        return $count['total'];
    }
    
    public function logout() {
        $this->findByColumn('user', 'email', $_SESSION['user_data']['email']);
        $user = $this->single();
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_data']);
        session_destroy();
        $this->setWhereConditionForUpdate('email', $user['email']);
        $this->updateByColumn('user', array(
            'is_online' => false,
        ), $user['email']);

        echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
    }
}

