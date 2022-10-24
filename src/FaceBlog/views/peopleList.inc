<?php $render("partial/header", $data); ?>

<?php if ($data['user'] !== null) { ?>

    <h1 class="mb-4">People</h1>

  <?php $beginForm("User", "Index"); ?>
    <div class="row justify-content-between">
        <div class="row col-auto mb-3">
            <div class="col-auto">
                <input autocomplete="off" class="form-control" name="filter"
                       value="<?php $htmlOut($data["filter"]); ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-success">Search</button>
            </div>
        </div>
    </div>
  <?php $endForm(); ?>

  <?php $render('partial/peopleTable', $data); ?>

<?php } ?>

<?php $render('partial/footer', $data); ?>
