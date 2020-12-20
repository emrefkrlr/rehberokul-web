<?php
class Login extends Controller {
    protected function index() {
        if(!isset($_SESSION['is_logged_in'])) {
            self::$title = 'Giriş';
            $viewModel = new LoginModel();
            $this->returnView($viewModel->index(), true);
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
        }
    }
    
    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }
    
    
}