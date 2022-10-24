<?php $render('partial/header', $data); ?>

    <h1>Create new Blog Post</h1>

<?php $beginForm('BlogEntries', 'Create', method: 'post'); ?>
    <div class="mb-3">
        <label for="blogSubject" class="form-label">Blog Subject</label>
        <input class="form-control" id="blogSubject" name="bs" autocomplete="off">
    </div>
    <div class="mb-3">
        <label for="blogContent" class="form-label">Blog Content</label>
        <textarea class="form-control" id="ct" name="bc" rows="3" autocomplete="off"></textarea>
    </div>
    <button class="btn btn-primary">Create</button>
<?php $endForm(); ?>