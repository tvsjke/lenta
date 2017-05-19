<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

if (isset($_POST['add_comment'])) {
    $error = [];
    $json = [];
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);

    if (empty($name) || mb_strlen($name) < 3) {
        $error[] = 'Имя не должно быть меньше 3 символов!';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Введите корректную почту!';
    }
    if (empty($comment) || mb_strlen($comment) < 3) {
        $error[] = 'Длина комментария должна быть не менее 3 символов!';
    }
    if (!$error) {
        $user->addComment($id, $name, $email, $comment);
        $json['comment'] = [
            'name' => $name,
            'email' => $email,
            'comment' => $comment
        ];
    } else {
        $json['error'] = $error;
    }
    echo json_encode($json, JSON_UNESCAPED_UNICODE);;
} elseif (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);
    $post = $user->getPost($post_id);
    $comments = $user->getPostComments($post_id);

    $v = new View('single-post.html');
    $v->render(['post' => $post, 'comments'=> $comments]);
}