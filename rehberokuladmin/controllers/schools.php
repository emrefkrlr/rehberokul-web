<?php
class Schools extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 19;
    }
    protected function kindergarten() {
        self::$title = 'Anaokulları ve Kreşler';
        self::$child_active_id = 27;
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->kindergarten(), true); //call indeks method of user model
    }

    protected function executive() {
        self::$title = 'Okulum';
        self::$active_id = 39;
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->executive(), true); //call indeks method of user model
    }

    protected function middle() {
        self::$title = 'İlk ve Ortaokullar';
        self::$child_active_id = 28;
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->middle(), true); //call indeks method of user model
    }

    protected function high() {
        self::$title = 'Liseler';
        self::$child_active_id = 29;
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->high(), true); //call indeks method of user model
    }

    protected function viewEditExecutive() {
        self::$active_id = 39;
        self::$title = 'Okul Düzenle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewEditExecutive($link), true); //call indeks method of user model
    }


    protected function viewEditKindergarten() {
        self::$title = 'Anaokulu Düzenle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewEditKindergarten($link), true); //call indeks method of user model
    }

    protected function viewAddKindergarten() {
        self::$title = 'Anaokulu Ekle';
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewAddKindergarten(), true); //call indeks method of user model
    }

    protected function viewDeleteKindergarten() {
        self::$title = 'Anaokulu Sil';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewDeleteKindergarten($link), true); //call indeks method of user model
    }

    protected function detailKindergarten() {
        self::$title = 'Anaokulu Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->detailKindergarten($link), true); //call indeks method of user model
    }

    protected function detailExecutive() {
        self::$active_id = 39;
        self::$title = 'Okul Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->detailExecutive($link), true); //call indeks method of user model
    }

    protected function viewEditMiddle() {
        self::$title = 'İlk ve Ortaokul Düzenle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewEditMiddle($link), true); //call indeks method of user model
    }

    protected function viewAddMiddle() {
        self::$title = 'İlk ve Ortaokul Ekle';
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewAddMiddle(), true); //call indeks method of user model
    }

    protected function viewDeleteMiddle() {
        self::$title = 'İlk ve Ortaokul Sil';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewDeleteMiddle($link), true); //call indeks method of user model
    }

    protected function detailMiddle() {
        self::$title = 'İlk ve Ortaokul Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->detailMiddle($link), true); //call indeks method of user model
    }

    protected function viewEditHigh() {
        self::$title = 'Lise Düzenle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewEditHigh($link), true); //call indeks method of user model
    }

    protected function viewAddHigh() {
        self::$title = 'Lise Ekle';
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewAddHigh(), true); //call indeks method of user model
    }

    protected function viewDeleteHigh() {
        self::$title = 'Lise Sil';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->viewDeleteHigh($link), true); //call indeks method of user model
    }

    protected function detailHigh() {
        self::$title = 'Lise Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->detailHigh($link), true); //call indeks method of user model
    }

    protected function editKindergarten() {
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->editKindergarten($link), true); //call indeks method of user model
    }

    protected function editExecutive() {
        self::$active_id = 39;
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->editExecutive($link), true); //call indeks method of user model
    }

    protected function addKindergarten() {
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->addKindergarten(), true); //call indeks method of user model
    }

    protected function deleteKindergarten() {
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->deleteKindergarten($link), true); //call indeks method of user model
    }

    protected function editMiddle() {
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->editMiddle($link), true); //call indeks method of user model
    }

    protected function addMiddle() {
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->addMiddle(), true); //call indeks method of user model
    }

    protected function deleteMiddle() {
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->deleteMiddle($link), true); //call indeks method of user model
    }

    protected function editHigh() {
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->editHigh($link), true); //call indeks method of user model
    }

    protected function addHigh() {
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->addHigh(), true); //call indeks method of user model
    }

    protected function deleteHigh() {
        $link = $this->request['id'];
        $viewModel = new SchoolsModel();
        $this->returnView($viewModel->deleteHigh($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

