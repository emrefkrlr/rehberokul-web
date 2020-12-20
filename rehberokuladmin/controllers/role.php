<?php
class Role extends Controller {
    
    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 3;
    }
    protected function index() {
        if(isset($_SESSION['is_logged_in'])) {
            self::$title = 'Roller ve Yetkilendirmeler';
            $viewModel = new RoleModel();
            $this->returnView($viewModel->index(), true); //call indeks method of user model
        }
    }
    
    protected function viewEdit() {
        if(isset($_SESSION['is_logged_in'])) {
            self::$title = 'Rol ve Yetkilendirme Düzenle';
            $roleName = $this->request['id'];
            $viewModel = new RoleModel();
            $this->returnView($viewModel->viewEdit($roleName), true); //call indeks method of user model
        }
    }
    
    protected function viewAdd() {
        if(isset($_SESSION['is_logged_in'])) {
            self::$title = 'Rol ve Yetkilendirme Ekle';
            $viewModel = new RoleModel();
            $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
        }
    }
    
     protected function viewDelete() {
        if(isset($_SESSION['is_logged_in'])) {
            self::$title = 'Rol ve Yetkilendirme Sil';
            $roleName = $this->request['id'];
            $viewModel = new RoleModel();
            $this->returnView($viewModel->viewDelete($roleName), true); //call indeks method of user model
        }
    }
    
    protected function detail() {
        self::$title = 'Rol ve Yetkilendirme Görüntüle';
        $link = $this->request['id'];
        $viewModel = new RoleModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function edit() {
        if(isset($_SESSION['is_logged_in'])) {
            $roleName = $this->request['id'];
            $viewModel = new RoleModel();
            $this->returnView($viewModel->edit($roleName), true); //call indeks method of user model
        }
    }
    
    protected function add() {
        if(isset($_SESSION['is_logged_in'])) {
            $viewModel = new RoleModel();
            $this->returnView($viewModel->add(), true); //call indeks method of user model
        }
    }
    
     protected function delete() {
        if(isset($_SESSION['is_logged_in'])) {
            $roleName = $this->request['id'];
            $viewModel = new RoleModel();
            $this->returnView($viewModel->delete($roleName), true); //call indeks method of user model
        }
    }
    
    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
        
    }
    
}

