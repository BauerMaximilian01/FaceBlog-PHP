<?php

namespace Application;

class CreateRemoveLikeCommand {
  public function __construct(private \Application\Interfaces\LikeRepository $likeRepository, private \Application\Interfaces\BlogEntryRepository $blogEntryRepository) {
  }

  const ERROR_NOTLOGGEDIN = 0x01;
  const ERROR_BLOGNOTEXISTING = 0x02;

  public function execute(int $userId, int $blogId): int {
    $errors = 0;

    if ($userId == null)
      $errors |= self::ERROR_NOTLOGGEDIN;

    if (!$this->blogEntryRepository->checkIfBlogEntryExists($blogId) == 1)
      $errors |= self::ERROR_BLOGNOTEXISTING;

    if (!$errors) {
      if ($this->likeRepository->checkIfAlreadyLiked($userId, $blogId) == 0) {
        $this->likeRepository->likeBlogPost($userId, $blogId);
      } else {
        $this->likeRepository->removeLikeOfBlog($userId, $blogId);
      }
    }

    return $errors;
  }
}