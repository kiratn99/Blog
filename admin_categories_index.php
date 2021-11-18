<?php
include 'app/connect.php';

  $query = $pdo -> prepare
  (
  '
    SELECT
      Category.Id AS Id,
      Name,
      COUNT(Category_Id) AS Total
    FROM
      Category
    LEFT JOIN
      Post ON Category.Id = Category_Id
    GROUP BY Category.Id
  '
  );

  $query->execute();
  $categories = $query->fetchAll();

$title = 'Gestion des catégories';
$template = 'admin_categories_index';
include 'layout.phtml';
