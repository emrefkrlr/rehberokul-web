<?php
class User extends Controller {
    
    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 2;
    }
    protected function all_users() {
        self::$title = 'Tüm Kullanıcılar';
        self::$child_active_id = 3;
        $viewModel = new UserModel();
        $this->returnView($viewModel->all_users(), true); //call indeks method of user model
    }

    protected function owners() {
        self::$title = 'Kurum Sahipleri';
        self::$child_active_id = 4;
        $viewModel = new UserModel();
        $this->returnView($viewModel->owners(), true); //call indeks method of user model
    }

    protected function executives() {
        self::$title = 'Okul Yetkilileri';
        self::$child_active_id = 5;
        $viewModel = new UserModel();
        $this->returnView($viewModel->executives(), true); //call indeks method of user model
    }

    protected function executive() {
        self::$title = 'Okul Yetkilileri';
        self::$active_id = 38;
        $viewModel = new UserModel();
        $this->returnView($viewModel->executive(), true); //call indeks method of user model
    }

    protected function detailExecutive() {
        self::$title = 'Yetkili Görüntüle';
        self::$active_id = 38;
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->detailExecutive($link), true); //call indeks method of user model
    }

    protected function parents() {
        self::$title = 'Veliler';
        self::$child_active_id = 6;
        $viewModel = new UserModel();
        $this->returnView($viewModel->parents(), true); //call indeks method of user model
    }
    
    protected function viewEdit() {
        self::$title = 'Kullanıcı Düzenle';
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function viewEditExecutive() {
        self::$title = 'Yetkili Düzenle';
        self::$active_id = 38;
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->viewEditExecutive($link), true); //call indeks method of user model
    }
    
    protected function viewAdd() {
        self::$title = 'Kullanıcı Ekle';
        $viewModel = new UserModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }

    protected function viewAddExecutive() {
        self::$title = 'Yetkili Ekle';
        self::$active_id = 38;
        $viewModel = new UserModel();
        $this->returnView($viewModel->viewAddExecutive(), true); //call indeks method of user model
    }
    
    protected function viewDelete() {
        self::$title = 'Kullanıcı Sil';
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }
    protected function viewDeleteExecutive() {
        self::$title = 'Yetkili Sil';
        self::$active_id = 38;
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->viewDeleteExecutive($link), true); //call indeks method of user model
    }

    
    protected function detail() {
        self::$title = 'Kullanıcı Görüntüle';
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }
    
    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }
    
    protected function add() {
        $viewModel = new UserModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }
    
     protected function delete() {
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    protected function editExecutive() {
        self::$active_id = 38;
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->editExecutive($link), true); //call indeks method of user model
    }

    protected function addExecutive() {
        self::$active_id = 38;
        $viewModel = new UserModel();
        $this->returnView($viewModel->addExecutive(), true); //call indeks method of user model
    }

    protected function deleteExecutive() {
        self::$active_id = 38;
        $link = $this->request['id'];
        $viewModel = new UserModel();
        $this->returnView($viewModel->deleteExecutive($link), true); //call indeks method of user model
    }
    
    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }
    
}

