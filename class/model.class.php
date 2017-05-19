<?php

class Model {

    private $db;

    public function __construct(Mysqldb $dbh){
        $this->db = $dbh;
    }

    public function getPost($id) {
        $this->db->query('SELECT * FROM posts WHERE post_id=:id');
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->single();
    }

    public function getPosts() {
        $this->db->query("SELECT * FROM posts ORDER BY post_id DESC");
        $this->db->execute();
        $posts = $this->db->resultset();
        return $posts;
    }

    public function getPostComments($id) {
        $this->db->query("SELECT * FROM comments WHERE post_id=:id ORDER BY comment_id DESC");
        $this->db->bind(':id', $id);
        $this->db->execute();
        $comments = $this->db->resultset();
        return $comments;
    }

    public function addPost($title, $text) {
        $this->db->query("INSERT INTO posts(title, text) VALUES(:title, :text)");
        $this->db->bind(":title", $title);
        $this->db->bind(":text", $text);
        $this->db->execute();
    }

    public function addComment($id, $name, $email, $comment) {
        $this->db->query("INSERT INTO comments(post_id, name, email, text) VALUES(:post_id, :name, :email, :text)");
        $this->db->bind(":post_id", $id);
        $this->db->bind(":name", $name);
        $this->db->bind(":email", $email);
        $this->db->bind(":text", $comment);
        $this->db->execute();
    }

    public function editPost($id, $title, $text) {
        $this->db->query('UPDATE posts SET title = :title, text = :text WHERE post_id = :id');
        $this->db->bind(':title', $title);
        $this->db->bind(':text', $text);
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function deletePost($id) {
        $this->db->query("DELETE FROM posts WHERE post_id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
        $this->deleteComments($id);
    }

    function deleteComments($id) {
        $this->db->query("DELETE FROM comments WHERE post_id = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();
    }
}