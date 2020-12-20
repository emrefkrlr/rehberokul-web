<?php
class Notifications extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
    }
    protected function parent() {
        self::$active_id = 34;
        self::$title = 'Bildirimler';
        $viewModel = new NotificationsModel();
        $this->returnView($viewModel->parent(), true); //call indeks method of user model
    }

    protected function owner() {
        self::$active_id = 33;
        self::$title = 'Bildirimler';
        $viewModel = new NotificationsModel();
        $this->returnView($viewModel->owner(), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new NotificationsModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

