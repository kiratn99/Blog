<?php

include 'app/connect.php';


$titlePost     = '';
$contentPost   = '';
$categoryPost  = '';
$authorPost    = '';


if( array_key_exists('title', $_POST) ) {

  $error          = array();
  $titlePost      = $_POST['title'];
  $contentPost    = $_POST['content'];
  $categoryPost   = $_POST['category'];
  $authorPost     = $_POST['author'];

  if( empty( $_POST['title'] ) ) {
    $error['title'] = 'Le titre de l\'article est obligatoire';
  }

  if( empty( $_POST['content'] ) ) {
    $error['content'] = 'Rédiger votre article !';
  }
  else if( mb_strlen( $_POST['content'] ) > 10000 OR mb_strlen( $_POST['content'] ) < 10  ) {
    $error['content'] = "L'article doit contenir un minimum de 10 caractères et un maximum de 10000";
  }

  if( !intval( $_POST['author'] ) ) {
    $error['author'] = 'Choisir un auteur';
  }

  if( !intval( $_POST['category'] ) ) {
    $error['category'] = 'Choisir une catégorie';
  }

  if( empty($error) ) {

    $query = $pdo->prepare(
    '
      INSERT INTO
          Post
          (Title, Contents, Author_Id, Category_Id, CreationTimestamp)
      VALUES
          (?, ?, ?, ?, NOW())
    ');

    $query->execute( array(
      $_POST['title'],
      $_POST['content'],
      $_POST['author'],
      $_POST['category'])
    );

  
    $new_id = $pdo->lastInsertId();

    header('Location: show_post.php?id=' . $new_id );
    exit();
  }
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
$query -> closeCursor();

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
$query -> closeCursor();

$title = 'Créer un article';
$template = 'admin_posts_new';
include 'layout.phtml';
