<?php

namespace Application;

class AddBlogCommand {
  public function __construct(private Services\UserService $userService, private \Application\Interfaces\BlogEntryRepository $blogEntryRepository) {
  }

  const ERROR_NOT_AUTHENTICATED = 0x01;
  const ERROR_SUBJECTEMPTY = 0x02;
  const ERROR_SUBJECTTOOLONG = 0x04;
  const ERROR_CONTENTEMPTY = 0x08;
  const ERROR_CREATEPOSTFAILED = 0x10;

  public function execute(string $subject, string $content) {
    $userId = $this->userService->getUserId();
    if ($userId === null)
      return self::ERROR_NOT_AUTHENTICATED;

    $errors = 0;

    if(strlen($subject) == 0) {
      $errors |= self::ERROR_SUBJECTEMPTY;
    }

    if (strlen($subject) > 255) {
      $errors |= self::ERROR_SUBJECTTOOLONG;
    }

    if (strlen($content) == 0) {
      $errors |= self::ERROR_CONTENTEMPTY;
    }

    if ($errors) {
      return $errors;
    }

    if ($this->blogEntryRepository->createBlogPost($userId, $subject, $content) === null) {
      return self::ERROR_CREATEPOSTFAILED;
    }

    return 0;
  }
}