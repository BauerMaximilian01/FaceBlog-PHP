<div>
  <?php foreach ($data['blogEntries'] as $blogEntry) : ?>
      <label>Subject: <?php $htmlOut($blogEntry->getBlogSubject()) ?></label>
      <div style="width: fit-content; padding: 5px 10px 5px 10px;
                  border-color: #1A1A1A; border-style: solid; border-width: thin; border-radius: 5px;">
        <?php $htmlOut($blogEntry->getBlogContent()) ?></div>
      <div>
          <label>Posted on: <?php $htmlOut($blogEntry->getBlogEntryDate()) ?></label> <br/>
          <label>Liked by: <?php $htmlOut($blogEntry->getLikes()) ?>
              | <?php $htmlOut($blogEntry->getLikedByAsString()) ?></label>
      </div>
      <div style="display: flex; margin-top: 10px;">
          <div style="margin-right: 10px;">
            <?php $beginForm('Likes', 'LikeToggle', ["bid" => $blogEntry->getBlogId()], method: 'post'); ?>
            <?php if (str_contains($blogEntry->getLikedByAsString(), $data['user']->getNickName())) { ?>
                <button class="btn btn-sm btn-outline-success">Unlike</button>
            <?php } else { ?>
                <button class="btn btn-sm btn-outline-success">Like</button>
            <?php } ?>
            <?php $endForm(); ?>
          </div>
          <div>
            <?php $beginForm('BlogEntries', 'Remove', ["bid" => $blogEntry->getBlogId()], method: 'post'); ?>
              <button class="btn btn-sm btn-outline-danger">Remove Blog Post</button>
            <?php $endForm(); ?>
          </div>
      </div>
      <hr style="text-align:left;margin-left:0"/>
  <?php endforeach; ?>
</div>