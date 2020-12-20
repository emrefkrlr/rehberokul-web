<?php
class Blog extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 13;
    }
    protected function post() {
        self::$title = 'Yazılar';
        self::$child_active_id = 15;
        $viewModel = new BlogModel();
        $this->returnView($viewModel->post(), true); //call indeks method of user model
    }


    protected function comment() {
        self::$title = 'Yorumlar';
        self::$child_active_id = 40;
        $viewModel = new BlogModel();
        $this->returnView($viewModel->comment(), true); //call indeks method of user model
    }

    protected function tag() {
        self::$title = 'Kategoriler';
        self::$child_active_id = 14;
        $viewModel = new BlogModel();
        $this->returnView($viewModel->tag(), true); //call indeks method of user model
    }

    protected function viewEditComment() {
        self::$title = 'Yorum Düzenle';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewEditComment($link), true); //call indeks method of user model
    }

    protected function viewDeleteComment() {
        self::$title = 'Yorum Sil';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewDeleteComment($link), true); //call indeks method of user model
    }

    protected function detailComment() {
        self::$title = 'Yorum Görüntüle';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->detailComment($link), true); //call indeks method of user model
    }

    protected function viewEdit() {
        self::$title = 'Yazı Düzenle';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function viewAdd() {
        self::$title = 'Yazı Ekle';
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewAdd(), true); //call indeks method of user model
    }

    protected function viewDelete() {
        self::$title = 'Yazı Sil';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'Yazı Görüntüle';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function viewEditTag() {
        self::$title = 'Kategori Düzenle';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewEditTag($link), true); //call indeks method of user model
    }

    protected function viewAddTag() {
        self::$title = 'Kategori Ekle';
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewAddTag(), true); //call indeks method of user model
    }

    protected function viewDeleteTag() {
        self::$title = 'Kategori Sil';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->viewDeleteTag($link), true); //call indeks method of user model
    }

    protected function detailTag() {
        self::$title = 'Kategori Görüntüle';
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->detailTag($link), true); //call indeks method of user model
    }

    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }

    protected function editComment() {
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->editComment($link), true); //call indeks method of user model
    }

    protected function add() {
        $viewModel = new BlogModel();
        $this->returnView($viewModel->add(), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    protected function deleteComment() {
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->deleteComment($link), true); //call indeks method of user model
    }

    protected function editTag() {
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->editTag($link), true); //call indeks method of user model
    }

    protected function addTag() {
        $viewModel = new BlogModel();
        $this->returnView($viewModel->addTag(), true); //call indeks method of user model
    }

    protected function deleteTag() {
        $link = $this->request['id'];
        $viewModel = new BlogModel();
        $this->returnView($viewModel->deleteTag($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

