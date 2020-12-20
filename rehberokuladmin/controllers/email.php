<?php
class Email extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 17;
    }
    protected function index() {
        self::$child_active_id = 41;
        self::$title = 'E-mailler';
        $viewModel = new EmailModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function setting() {
        self::$child_active_id = 42;
        self::$title = 'Ayarlar';
        $viewModel = new EmailModel();
        $this->returnView($viewModel->setting(), true); //call indeks method of user model
    }

    protected function viewEdit() {
        self::$title = 'E-mail Düzenle';
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function preview() {
        self::$title = 'Test E-mail Gönder';
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->preview($link), true); //call indeks method of user model
    }

    protected function viewAdd() {
        self::$title = 'E-mail Ekle';
        $viewModel = new EmailModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }

    protected function viewDelete() {
        self::$title = 'E-mail Sil';
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }

    protected function viewSend() {
        self::$title = 'Toplu E-mail Gönder';
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->viewSend($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'E-mail Görüntüle';
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }

    protected function setSetting() {
        $name = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->setSetting($name), true); //call indeks method of user model
    }

    protected function add() {
        $viewModel = new EmailModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }

    protected function sendTest() {
        $viewModel = new EmailModel();
        $this->returnView($viewModel->sendTest(), true); //call indeks method of user model
    }

    protected function sendAll() {
        $viewModel = new EmailModel();
        $this->returnView($viewModel->sendAll(), true); //call indeks method of user model
    }

    protected function copy() {
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->copy($link), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new EmailModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

