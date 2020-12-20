<?php
class School extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 7;
    }
    protected function kindergarten() {
        self::$title = 'Anaokulları ve Kreşler';
        self::$child_active_id = 8;
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->kindergarten(), true); //call indeks method of user model
    }

    protected function middle() {
        self::$title = 'İlk ve Ortaokullar';
        self::$child_active_id = 9;
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->middle(), true); //call indeks method of user model
    }

    protected function high() {
        self::$title = 'Liseler';
        self::$child_active_id = 10;
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->high(), true); //call indeks method of user model
    }

    protected function favorite() {
        self::$title = 'Favori Okullarım';
        self::$active_id = 37;
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->favorite(), true); //call indeks method of user model
    }

    protected function detailFavorite() {
        self::$active_id = 37;
        self::$title = 'Okul Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->detailFavorite($link), true); //call indeks method of user model
    }

    protected function viewDeleteFavorite() {
        self::$active_id = 37;
        self::$title = 'Okulu Favorilerden Sil';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewDeleteFavorite($link), true); //call indeks method of user model
    }

    protected function deleteFavorite() {
        self::$active_id = 37;
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->deleteFavorite($link), true); //call indeks method of user model
    }


    protected function viewEditKindergarten() {
        self::$title = 'Anaokulu Düzenle';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewEditKindergarten($link), true); //call indeks method of user model
    }

    protected function viewAddKindergarten() {
        self::$title = 'Anaokulu Ekle';
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewAddKindergarten(), true); //call indeks method of user model
    }

    protected function viewDeleteKindergarten() {
        self::$title = 'Anaokulu Sil';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewDeleteKindergarten($link), true); //call indeks method of user model
    }

    protected function detailKindergarten() {
        self::$title = 'Anaokulu Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->detailKindergarten($link), true); //call indeks method of user model
    }

    protected function viewEditMiddle() {
        self::$title = 'İlk ve Ortaokul Düzenle';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewEditMiddle($link), true); //call indeks method of user model
    }

    protected function viewAddMiddle() {
        self::$title = 'İlk ve Ortaokul Ekle';
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewAddMiddle(), true); //call indeks method of user model
    }

    protected function viewDeleteMiddle() {
        self::$title = 'İlk ve Ortaokul Sil';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewDeleteMiddle($link), true); //call indeks method of user model
    }

    protected function detailMiddle() {
        self::$title = 'İlk ve Ortaokul Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->detailMiddle($link), true); //call indeks method of user model
    }

    protected function viewEditHigh() {
        self::$title = 'Lise Düzenle';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewEditHigh($link), true); //call indeks method of user model
    }

    protected function viewAddHigh() {
        self::$title = 'Lise Ekle';
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewAddHigh(), true); //call indeks method of user model
    }

    protected function viewDeleteHigh() {
        self::$title = 'Lise Sil';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->viewDeleteHigh($link), true); //call indeks method of user model
    }

    protected function detailHigh() {
        self::$title = 'Lise Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->detailHigh($link), true); //call indeks method of user model
    }

    protected function editKindergarten() {
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->editKindergarten($link), true); //call indeks method of user model
    }

    protected function addKindergarten() {
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->addKindergarten(), true); //call indeks method of user model
    }

    protected function deleteKindergarten() {
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->deleteKindergarten($link), true); //call indeks method of user model
    }

    protected function editMiddle() {
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->editMiddle($link), true); //call indeks method of user model
    }

    protected function addMiddle() {
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->addMiddle(), true); //call indeks method of user model
    }

    protected function deleteMiddle() {
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->deleteMiddle($link), true); //call indeks method of user model
    }

    protected function editHigh() {
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->editHigh($link), true); //call indeks method of user model
    }

    protected function addHigh() {
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->addHigh(), true); //call indeks method of user model
    }

    protected function deleteHigh() {
        $link = $this->request['id'];
        $viewModel = new SchoolModel();
        $this->returnView($viewModel->deleteHigh($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

