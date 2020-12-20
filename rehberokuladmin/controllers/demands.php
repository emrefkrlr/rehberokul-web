<?php
class Demands extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 20;
    }
    protected function index() {
        self::$title = 'Genel Talepler';
        self::$child_active_id = 30;
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }
 
    protected function spesific() {
        self::$title = 'Kuruma Özel Talepler';
        self::$child_active_id = 31;
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->spesific(), true); //call indeks method of user model
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

    protected function interested() {
        self::$title = 'İlgilendiğim Talepler';
        self::$child_active_id = 32;
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->interested(), true); //call indeks method of user model
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

    protected function interest() {
        $link = $this->request['id'];
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->interest($link), true); //call indeks method of user model
    }

    protected function interestSpesific() {
        $link = $this->request['id'];
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->interestSpesific($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function detailInterested() {
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->detailInterested($link), true); //call indeks method of user model
    }

    protected function detailSpesific() {
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->detailSpesific($link), true); //call indeks method of user model
    }

    protected function detailSpesificInterested() {
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandsModel();
        $this->returnView($viewModel->detailSpesificInterested($link), true); //call indeks method of user model
    }


    public function __destruct() {


    }

}

