<?php $render('partial/header', $data); ?>

<?php if ($data['user'] !== null) { ?>
    <h1>Blog of <?php $htmlOut($data['user']->getNickName()) ?></h1>
  <?php $link('Create new Blog Post', 'BlogEntries', 'Create', cssClass: 'btn btn-outline-primary') ?>
    <hr style="color: white;">
  <?php if (($data['blogEntries'] === null) || sizeof($data['blogEntries']) === 0) {
    ?>
        <p>You have not posted anything yet.</p> <?php
  } else {
    $render('partial/myBlogs', $data);
  } ?>
<?php } ?>
<?php $render('partial/footer', $data); ?>