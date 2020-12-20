<?php
class Comment extends Controller {

    public function __construct($action, $request) {
        parent::__construct($action, $request);
        self::$active_id = 18;
    }
    protected function index() {
        self::$title = 'Yorumlar';
        $viewModel = new CommentModel();
        $this->returnView($viewModel->index(), true); //call indeks method of user model
    }

    protected function viewEdit() {
        self::$title = 'Yorum Düzenle';
        $link = $this->request['id'];
        $viewModel = new CommentModel();
        $this->returnView($viewModel->viewEdit($link), true); //call indeks method of user model
    }

    protected function viewDelete() {
        self::$title = 'Yorum Sil';
        $link = $this->request['id'];
        $viewModel = new CommentModel();
        $this->returnView($viewModel->viewDelete($link), true); //call indeks method of user model
    }

    protected function detail() {
        self::$title = 'Yorum Görüntüle';
        $link = $this->request['id'];
        $viewModel = new CommentModel();
        $this->returnView($viewModel->detail($link), true); //call indeks method of user model
    }

    protected function edit() {
        $link = $this->request['id'];
        $viewModel = new CommentModel();
        $this->returnView($viewModel->edit($link), true); //call indeks method of user model
    }

    protected function delete() {
        $link = $this->request['id'];
        $viewModel = new CommentModel();
        $this->returnView($viewModel->delete($link), true); //call indeks method of user model
    }

    public function __destruct() {
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
    }

}

