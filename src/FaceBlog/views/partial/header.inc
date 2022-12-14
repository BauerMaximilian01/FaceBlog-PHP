<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>FaceBlog</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <?php $link('FaceBlog', 'Home', 'Index', cssClass: 'navbar-brand'); ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <nav class="navbar-nav me-auto">
              <?php
              $link('My Blog', 'BlogEntries', 'Index', cssClass: 'nav-link');
              $link('People', 'User', 'Index', cssClass: 'nav-link'); ?>
            </nav>
          <?php $render('partial/user', $data['user']); ?>
        </div>
    </div>
</nav>
<div class="container mt-3">
<?php if (isset($data['errors'])) {
  $render('partial/errors', $data['errors']);
} ?>