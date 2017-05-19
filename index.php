<?php

if (file_exists('startup.php')) {
    require_once('startup.php');
}

$posts = $user->getPosts();

foreach ($posts as $key => $item) {
    if(mb_strlen(strip_tags($posts[$key]['text'])) > 300) {
        $posts[$key]['trimmed'] = true;
        $posts[$key]['text'] = Helper::html_cut($posts[$key]['text']);
    }
    else {
        $posts[$key]['trimmed'] = false;
    }

}

$v = new View('index.html');
$v->render(['posts' => $posts]);