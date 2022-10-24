<?php $render('partial/header', $data); ?>

<?php if ($data['otherUser'] !== null) { ?>
    <h1>Blog of <?php $htmlOut($data['otherUser']->getNickName()) ?></h1>
    <hr style="color: white;">
  <?php if (($data['blogEntries'] === null) || sizeof($data['blogEntries']) === 0) {
    ?>
        <p>User <?php $htmlOut($data['otherUser']->getNickName()); ?> has not posted anything yet.</p> <?php
  } else {
    $render('partial/otherPeopleBlogs', $data);
  } ?>
<?php } ?>
<?php $render('partial/footer', $data); ?>