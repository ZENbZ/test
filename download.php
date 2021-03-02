<?php

require_once 'classes/QueryBuilder.php';
require_once 'classes/PostDTO.php';
require_once 'classes/CommentDTO.php';

$db = new QueryBuilder(Connection::make());

$curl = curl_init("https://jsonplaceholder.typicode.com/posts");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$posts = json_decode(curl_exec($curl));
curl_close($curl);

foreach ($posts as $post)
{
    $postDTO = new PostDTO($db);

    $postDTO->id = $post->id;
    $postDTO->userId = $post->userId;
    $postDTO->title = $post->title;
    $postDTO->body = $post->body;

    $postDTO->setPost('posts');
}

$curl = curl_init("https://jsonplaceholder.typicode.com/comments");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$comments = json_decode(curl_exec($curl));
curl_close($curl);

foreach ($comments as $comment)
{
    $commentDTO = new CommentDTO($db);

    $commentDTO->id = $comment->id;
    $commentDTO->postId = $comment->postId;
    $commentDTO->name = $comment->name;
    $commentDTO->email = $comment->email;
    $commentDTO->body = $comment->body;

    $commentDTO->setPost('comments');
}

echo "Загружено " . PostDTO::getCount() . " записей и " . CommentDTO::getCount() . " комментариев";
