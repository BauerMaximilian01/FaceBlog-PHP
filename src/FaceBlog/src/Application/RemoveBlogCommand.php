<?php

namespace Application;

class RemoveBlogCommand {
  public function __construct(private \Application\Interfaces\BlogEntryRepository $blogEntryRepository) {
  }

  const ERROR_NOTLOGGEDIN = 0x01;
  const ERROR_BLOGNOTEXISTING = 0x02;

  public function execute(int $blogId, int $userId): int {
    $errors = 0;

    if ($userId == null)
      $errors |= self::ERROR_NOTLOGGEDIN;

    if ($this->blogEntryRepository->checkIfBlogEntryExists($blogId) == 0)
      $errors |= self::ERROR_BLOGNOTEXISTING;

    if (!$errors)
      $this->blogEntryRepository->removeBlogEntry($blogId);

    return $errors;
  }
}