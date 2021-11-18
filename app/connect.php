<?php

$pdo = new PDO(
  'mysql:host=localhost;dbname=3wa_blog;charset=UTF8',
  'root',
  '',
  array(
    PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
  )
);

$pdo -> query("SET lc_time_names = 'fr_FR';");
