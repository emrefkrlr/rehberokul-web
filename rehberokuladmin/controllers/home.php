<?php
class Home extends Controller {
    
    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 1;
    }
    protected function index() {
        if(isset($_SESSION['is_logged_in'])) {
            self::$title = 'Anasayfa';
            $viewModel = new HomeModel();
            $this->returnView($viewModel->index(), true);
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
        }
    }
    
    protected function logout() {
        if(isset($_SESSION['is_logged_in'])) {
            $viewModel = new HomeModel();
            $this->returnView($viewModel->logout(), true);
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
        }
    } 
    
    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }
    
}

