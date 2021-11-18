<?php

if( !array_key_exists('id', $_GET) OR !ctype_digit($_GET['id']) ) {
  header('Location: admin.php');
  exit();
}

include 'app/connect.php';

$query = $pdo->prepare(
  '
    DELETE from Post
    WHERE Id = ?
  '
);

$query->execute( array($_GET['id']) );

header('Location: admin_posts_index.php');
exit();
