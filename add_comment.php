<?php
include 'app/connect.php';

$query =
'
    INSERT INTO
        Comment
        (NickName, Contents, Post_Id, CreationTimestamp)
    VALUES
        (?, ?, ?, NOW())
';
$resultSet = $pdo->prepare($query);
$resultSet->execute( array(
  $_POST['pseudo'],
  $_POST['comment'],
  $_POST['postId']
));


header('Location: show_post.php?id='.$_POST['postId']);
exit();
