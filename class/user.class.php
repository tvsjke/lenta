<?php

class USER
{
    private $model;

    function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getPosts() {
        return $this->model->getPosts();
    }

    public function getPost($id) {
        return $this->model->getPost($id);
    }

    public function addPost($title, $text) {
        $this->model->addPost($title, $text);
    }

    public function editPost($id, $title, $text) {
        $this->model->editPost($id, $title, $text);
    }

    public function deletePost($id) {
        $this->model->deletePost($id);
    }

    public function addComment($id, $name, $email, $comment) {
        $this->model->addComment($id, $name, $email, $comment);
    }

    public function getPostComments($id) {
        return $this->model->getPostComments($id);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}
?>