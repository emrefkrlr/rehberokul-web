<?php
class Notification extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 22;
    }
    protected function index() {
        self::$title = 'Bildirimler';
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function viewEdit() {
        self::$title = 'Bildirimi Tekrar Gönder';
        $link = $this->request['id'];
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function viewAdd() {
        self::$title = 'Bildirim Gönder';
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }

    protected function viewDelete() {
        self::$title = 'Bildirim Sil';
        $link = $this->request['id'];
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'Bildirim Görüntüle';
        $link = $this->request['id'];
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }

    protected function add() {
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new NotificationModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

