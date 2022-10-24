<?php if ($data['user'] == null) { ?>
    <div class="alert alert-info" role="alert">
        Please Login first.
    </div>
<?php } else { ?>
  <?php if ($data['people'] == null) { ?>
        <div class="alert alert-info" role="alert">
            No People found.
        </div>
  <?php } else { ?>
    <?php if (sizeof($data['people']) > 0) { ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Nickname</th>
                        <th>Member since</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data['people'] as $person) { ?>
                        <tr>
                            <td>
                              <?php $link($person->getNickName(), 'BlogEntries', 'OtherPeopleBlog', ['otherUid' => $person->getId()], cssClass: 'link-primary'); ?>
                            </td>
                            <td>
                              <?php if ($person->getMemberSince() == 1) {
                                $htmlOut($person->getMemberSince()) ?> Day
                              <?php } else if ($person->getMemberSince() == 0) {
                                ?> Today
                              <?php } else {
                                $htmlOut($person->getMemberSince()) ?> Days
                              <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
    <?php } ?>
  <?php } ?>
<?php } ?>
