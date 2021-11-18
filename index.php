<?php

include 'app/connect.php';

$query = $pdo -> prepare(
'
    SELECT
        Post.Id,
        Title,
        SUBSTRING(Contents, 1,150) AS Excerpt,
        DATE_FORMAT(`CreationTimestamp`, "%W %e %M %Y" ) AS DateMaj,
        DATE_FORMAT(`CreationTimestamp`, "%Y-%d-%d" ) AS DateIso,
        FirstName,
        LastName,
        Name AS CategoryName
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
    ORDER BY
        CreationTimestamp DESC
    LIMIT 10
');

$query->execute();
$posts = $query->fetchAll(); 
$query->closeCursor();

$title = 'Accueil du blog de Tante Ursule';
$template = 'index';
include 'layout.phtml';
