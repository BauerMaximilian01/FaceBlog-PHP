<?php $render('partial/header', $data); ?>
    <h1>Welcome</h1>
    <p>Welcome to FaceBlog!</p>

    <h3>Some information about FaceBlog</h3>
    <hr style="text-align:left;margin-left:0"/>
    <h4>Number of registered users</h4>
    <p>There are currently <?php if ($data['usersCount'] != null) echo $data['usersCount'] ?> registered users on
        FaceBlog.</p>

    <h4>Number of Blog Entries</h4>
    <p>There are currently <?php if ($data['blogEntryCount'] != null) echo $data['blogEntryCount'] ?> Blog Entries on
        FaceBlog.</p>

    <h4>Number of Blog Entries in the last 24 hours</h4>
    <p>There were <?php if ($data['blogEntryCountLastHours'] != null) echo $data['blogEntryCountLastHours'] ?> Blog
        Entries in the last 24 hours.</p>

    <h4>Date of Last Blog Post</h4>
    <p>The last Blog was posted on <?php if ($data['dateOfLastPost'] != null) echo $data['dateOfLastPost'] ?></p>
<?php $render('partial/footer', $data); ?>