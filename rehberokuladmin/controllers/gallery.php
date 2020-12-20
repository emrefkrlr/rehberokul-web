<?php
class Gallery extends Controller {
    
    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 24;
    }
    protected function index() {
        self::$title = 'Fotoğraflar / Klasörler';
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }
    
    protected function viewEdit() {
        self::$title = 'Fotoğraf / Klasör Düzenle';
        $link = $this->request['id'];
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }
    
    protected function viewAdd() {
        self::$title = 'Fotoğraf / Klasör Ekle';
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }
    
    protected function viewDelete() {
        self::$title = 'Fotoğraf / Klasör Sil';
        $link = $this->request['id'];
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }
    
    protected function detail() {
        self::$title = 'Fotoğraf / Klasör Görüntüle';
        $link = $this->request['id'];
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }
    
    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }
    
    protected function add() {
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }
    
     protected function delete() {
        $link = $this->request['id'];
        $viewModel = new GalleryModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }
    
    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }
    
}

