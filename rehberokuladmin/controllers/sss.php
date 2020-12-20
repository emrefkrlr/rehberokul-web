<?php
class Sss extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 16;
    }
    protected function index() {
        self::$title = 'Sıkça Sorulan Sorular';
        $viewModel = new SssModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function viewEdit() {
        self::$title = 'Soru Düzenle';
        $link = $this->request['id'];
        $viewModel = new SssModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function preview() {
        self::$title = 'Soru Önizle';
        $link = $this->request['id'];
        $viewModel = new SssModel();
        $this->returnView($viewModel->preview($link), true); //call indeks method of user model
    }

    protected function viewAdd() {
        self::$title = 'Soru Ekle';
        $viewModel = new SssModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }

    protected function viewDelete() {
        self::$title = 'Soru Sil';
        $link = $this->request['id'];
        $viewModel = new SssModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'Soru Görüntüle';
        $link = $this->request['id'];
        $viewModel = new SssModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new SssModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }

    protected function add() {
        $viewModel = new SssModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new SssModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

