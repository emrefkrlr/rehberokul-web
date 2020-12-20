<?php
class Demand extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 11;
    }
    protected function index() {
        self::$title = 'Genel Talepler';
        self::$child_active_id = 25;
        $viewModel = new DemandModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function spesific() {
        self::$title = 'Kuruma Özel Talepler';
        self::$child_active_id = 26;
        $viewModel = new DemandModel();
        $this->returnView($viewModel->spesific(), true); //call indeks method of user model
    }

    protected function parent() {
        self::$title = 'Taleplerim';
        self::$active_id = 36;
        $viewModel = new DemandModel();
        $this->returnView($viewModel->parent(), true); //call indeks method of user model
    }
    protected function viewAddParentDemand() {
        self::$active_id = 36;
        self::$title = 'Genel Talep Ekle';
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewAddParentDemand(), true); //call indeks method of user model
    }

    protected function addParentDemand() {
        self::$active_id = 36;
        $viewModel = new DemandModel();
        $this->returnView($viewModel->addParentDemand(), true); //call indeks method of user model
    }

    protected function doneParentDemand() {
        self::$active_id = 36;
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->doneParentDemand($link), true); //call indeks method of user model
    }

    protected function detailParentDemand() {
        self::$active_id = 36;
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->detailParentDemand($link), true); //call indeks method of user model
    }

    protected function detailParentDemandSpesific() {
        self::$active_id = 36;
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->detailParentDemandSpesific($link), true); //call indeks method of user model
    }

    protected function viewEditParentDemand() {
        self::$active_id = 36;
        self::$title = 'Talep Düzenle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewEditParentDemand($link), true); //call indeks method of user model
    }

    protected function editParentDemand() {
        self::$active_id = 36;
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->editParentDemand($link), true); //call indeks method of user model
    }

    protected function viewDeleteParentDemand() {
        self::$active_id = 36;
        self::$title = 'Talebi Pasife Çek';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewDeleteParentDemand($link), true); //call indeks method of user model
    }

    protected function viewDeleteParentDemandSpesific() {
        self::$active_id = 36;
        self::$title = 'Talebi Pasife Çek';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewDeleteParentDemandSpesific($link), true); //call indeks method of user model
    }

    protected function deleteParentDemand() {
        self::$active_id = 36;
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->deleteParentDemand($link), true); //call indeks method of user model
    }


    protected function viewEdit() {
        self::$title = 'Talep Düzenle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function viewEditSpesific() {
        self::$title = 'Talep Düzenle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewEditSpesific($link), true); //call indeks method of user model
    }

    protected function viewAdd() {
        self::$title = 'Genel Talep Ekle';
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }

    protected function viewAddDemand() {
        self::$title = 'Genel Taleplere Ekle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewAddDemand($link), true); //call indeks method of user model
    }


    protected function viewDelete() {
        self::$title = 'Talebi Pasife Çek';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }

    protected function viewDeleteSpesific() {
        self::$title = 'Talebi Pasife Çek';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->viewDeleteSpesific($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function detailSpesific() {
        self::$title = 'Talep Görüntüle';
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->detailSpesific($link), true); //call indeks method of user model
    }

    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }

    protected function editSpesific() {
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->editSpesific($link), true); //call indeks method of user model
    }

    protected function addDemand() {
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->addDemand($link), true); //call indeks method of user model
    }

    protected function add() {
        $viewModel = new DemandModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    protected function done() {
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->done($link), true); //call indeks method of user model
    }

    protected function approve() {
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->approve($link), true); //call indeks method of user model
    }

    protected function deleteSpesific() {
        $link = $this->request['id'];
        $viewModel = new DemandModel();
        $this->returnView($viewModel->deleteSpesific($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

