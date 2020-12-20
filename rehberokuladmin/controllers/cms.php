<?php
class CMS extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 43;
    }
    protected function schooltype() {
        self::$title = 'Okul Tipi İçerikleri';
        $viewModel = new CMSModel();
        $this->returnView($viewModel->schooltype(), true); //call indeks method of user model
    }

    protected function schooltypeViewEdit() {
        self::$title = 'İçerik Düzenle';
        $link = $this->request['id'];
        $viewModel = new CMSModel();
        $this->returnView($viewModel->schooltypeViewEdit($link), true); //call indeks method of user model
    }

    protected function schooltypeDetail() {
        self::$title = 'İçerik Görüntüle';
        $link = $this->request['id'];
        $viewModel = new CMSModel();
        $this->returnView($viewModel->schooltypeDetail($link), true); //call indeks method of user model
    }

    protected function schooltypeEdit() {
        $link = $this->request['id'];
        $viewModel = new CMSModel();
        $this->returnView($viewModel->schooltypeEdit($link), true); //call indeks method of user model
    }

    protected function landings() {
        self::$title = 'Bölge İçerikleri';
        $viewModel = new LandingsModel();
        $this->returnView($viewModel->landings(), true); //call indeks method of user model
    }
    protected function landingViewEdit() {
        self::$title = 'İçerik Düzenle';
        $id = $this->request['id'];
        $viewModel = new LandingsModel();
        $this->returnView($viewModel->landingViewEdit($id), true); //call indeks method of user model
    }

    protected function landingEdit() {
        $id = $this->request['id'];
        $viewModel = new LandingsModel();
        $this->returnView($viewModel->landingEdit($id), true); //call indeks method of user model
    }



    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

