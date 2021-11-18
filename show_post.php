<?php

if( !array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']) ) {
  header('Location: index.php');
  exit();
}

include 'app/connect.php';

$query = $pdo->prepare(
'
    SELECT
        Post.Id,
        Title,
        Contents,
        DATE_FORMAT(`CreationTimestamp`, "%W %e %M %Y" ) AS DateMaj,
        DATE_FORMAT(`CreationTimestamp`, "%Y-%d-%d" ) AS DateIso,
        FirstName,
        LastName,
        Name
    FROM
        Post
    INNER JOIN
        Author
    ON
        Post.Author_Id = Author.Id
    INNER JOIN
        Category
    ON
        Post.Category_Id = Category.Id
    WHERE
        Post.Id = ?
');
$query->execute( array($_GET['id']) );
$post = $query->fetch();
$query->closeCursor();

if( empty($post) ) {
  header('Location: index.php');
  exit();
}


$query = $pdo->prepare(
'
    SELECT
        NickName,
        Contents,
        CreationTimestamp
    FROM
        Comment
    WHERE
        Post_Id = ?
');
$query -> execute(array( $post['Id'] ));
$comments = $query->fetchAll();
$query -> closeCursor();


$title = $post['Title'];
$template = 'show_post';
include 'layout.phtml';
