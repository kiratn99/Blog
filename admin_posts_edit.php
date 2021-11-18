<?php

include 'app/connect.php';


if( array_key_exists('title', $_POST) ) {


  $query = $pdo->prepare(
  '
      UPDATE
          Post
      SET
          Title = :title,
          Contents = :contents,
          Category_Id = :category,
          Author_Id = :author,
          CreationTimestamp = NOW()
      WHERE
          Id = :id
  ');

  $query->execute( array(
    'title'     => $_POST['title'],
    'contents'  => $_POST['contents'],
    'category'  => intval($_POST['category']),
    'author'    => intval($_POST['author']),
    'id'        => intval($_POST['id'])
  ));

  header('Location: admin_posts_index.php');
  exit();
}

if( !array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']) ) {
  header('Location: admin_posts_index.php');
  exit();
}


$query = $pdo->prepare(
'
    SELECT
        Post.Id,
        Title,
        Contents,
        Category_Id,
        Author_Id
    FROM
        Post
    WHERE
        Post.Id = ?
');
$query ->execute( array($_GET['id']) );
$post = $query->fetch();
$query->closeCursor();

if( empty($post) ) {
  header('Location: admin_posts_index.php');
  exit();
}

$query = $pdo->query
(
  'SELECT
        Id,
        Name
    FROM
        Category'
);

$categories = $query->fetchAll();
$query->closeCursor();

$query = $pdo->query
(
  'SELECT
        Id,
        FirstName,
        LastName
    FROM
        Author'
);

$authors = $query->fetchAll();
$query->closeCursor();

$title = 'Modifier un article';
$template = 'admin_posts_edit';
include 'layout.phtml';
