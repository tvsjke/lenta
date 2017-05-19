<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

//удалить пост
if (isset($_POST['id'])) {
    $post_id = intval($_POST['id']);
    $user->deletePost($post_id);
    echo 1;
}
else {
    $error = [];
    $title = '';
    $text = '';
    $action_name = 'Добавить';
    $action_type = 'add';
    //редактировать пост
    if (isset($_GET['id'])) {
        $action_name = 'Редактировать';
        $action_type = 'edit';
        $post_id = (int)$_GET['id'];
        if (isset($_POST['action']) && $_POST['action'] === 'edit') {
            $title = trim($_POST['title']);
            $text = trim($_POST['text']);

            if (empty($title) && mb_strlen($title) < 3) {
                $error[] = 'Введите корректное название';
            }
            if (empty($text) && mb_strlen($text) < 10) {
                $error[] = 'Длина поста должна быть не менее 10 символов!';
            }
            if (!$error) {
                $user->editPost($post_id, $title, $text);
                $user->redirect('/');
            }
        }
        $post = $user->getPost($post_id);
        $title = $post['title'];
        $text = $post['text'];
    }
    //добавить пост
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $title = trim($_POST['title']);
        $text = trim($_POST['text']);

        if (empty($title) && mb_strlen($title) < 3) {
            $error[] = 'Введите корректное название';
        }
        if (empty($text) && mb_strlen($text) < 10) {
            $error[] = 'Длина поста должна быть не менее 10 символов!';
        }
        if (!$error) {
            $user->addPost($title, $text);
            $user->redirect('/');
        }
    }
    $v = new View('post.html');
    $v->render(['action_name' => $action_name, 'action_type' => $action_type, 'error' => $error, 'title' => $title, 'text' => $text]);
}
