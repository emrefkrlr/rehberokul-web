<?php
class Buy extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 35;
    }
    protected function index() {
        self::$title = 'Paket Satın Al';
        $viewModel = new BuyModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function add() {
        $type = $this->request['id'];
        $viewModel = new BuyModel();
        $this->returnView($viewModel->add($type), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

