<?php
class Announcement extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 21;
    }
    protected function index() {
        self::$title = 'Duyurular ve Etkinlikler';
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function viewEdit() {
        self::$title = 'Duyuru/Etkinlik Düzenle';
        $link = $this->request['id'];
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function viewAdd() {
        self::$title = 'Duyuru/Etkinlik Ekle';
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }

    protected function viewDelete() {
        self::$title = 'Duyuru/Etkinlik Sil';
        $link = $this->request['id'];
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'Duyuru/Etkinlik Görüntüle';
        $link = $this->request['id'];
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }

    protected function add() {
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new AnnouncementModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

