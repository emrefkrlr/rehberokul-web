<?php
class Payment extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 12;
    }
    protected function index() {
        self::$title = 'Ödemeler';
        $viewModel = new PaymentModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function viewApprove() {
        self::$title = 'Onay Ver';
        $link = $this->request['id'];
        $viewModel = new PaymentModel();
        $this->returnView($viewModel->viewApprove($link), true); //call indeks method of user model
    }

    protected function viewCancel() {
        self::$title = 'İptal Et';
        $link = $this->request['id'];
        $viewModel = new PaymentModel();
        $this->returnView($viewModel->viewCancel($link), true); //call indeks method of user model
    }

    protected function approve() {
        $link = $this->request['id'];
        $viewModel = new PaymentModel();
        $this->returnView($viewModel->approve($link), true); //call indeks method of user model
    }

    protected function cancel() {
        $link = $this->request['id'];
        $viewModel = new PaymentModel();
        $this->returnView($viewModel->cancel($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

