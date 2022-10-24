<?php

namespace Presentation\Controllers;

class Likes extends \Presentation\MVC\Controller {
  public function __construct(private \Application\SignedInUserQuery $signedInUserQuery, private \Application\CreateRemoveLikeCommand $createRemoveLikeCommand) {
  }

  public function POST_LikeToggle(): \Presentation\MVC\ActionResult {
    $user = $this->signedInUserQuery->execute();
    $blogId = $this->getParam('bid');

    $result = $this->createRemoveLikeCommand->execute($user->getId(), $blogId);
    if ($result) {
      $errors = [];
      if ($result & \Application\CreateRemoveLikeCommand::ERROR_NOTLOGGEDIN)
        $errors[] = "Please Login first.";

      if ($result & \Application\CreateRemoveLikeCommand::ERROR_BLOGNOTEXISTING)
        $errors[] = "The Blog you are trying to Like does not exist.";

      return $this->view('blogList', [
        'blogEntries' => null,
        'otherUser' => null,
        'user' => null,
        'errors' => $errors
      ]);
    }

    if ($this->tryGetParam('otherUid', $value)) {
      return $this->redirect('BlogEntries', 'OtherPeopleBlog', ['otherUid' => $value]);
    } else {
      return $this->redirect('BlogEntries', 'Index', []);
    }
  }

  public function POST_LikeToggleOtherPeople(): \Presentation\MVC\ActionResult {
    $user = $this->signedInUserQuery->execute();
    $blogId = $this->getParam('bid');

    $result = $this->createRemoveLikeCommand->execute($user->getId(), $blogId);
    if ($result) {
      $errors = [];
      if ($result & \Application\CreateRemoveLikeCommand::ERROR_NOTLOGGEDIN)
        $errors[] = "Please Login first.";

      if ($result & \Application\CreateRemoveLikeCommand::ERROR_BLOGNOTEXISTING)
        $errors[] = "The Blog you are trying to Like does not exist.";

      return $this->view('blogList', [
        'blogEntries' => null,
        'otherUser' => null,
        'user' => null,
        'errors' => $errors
      ]);
    }

    return $this->redirect('BlogEntries', 'OtherPeopleBlog', ['otherUid' => $otherUser->getId()]);
  }
}