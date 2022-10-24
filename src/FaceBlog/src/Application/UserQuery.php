<?php

namespace Application;

class UserQuery {
  public function __construct(
    private \Application\Interfaces\UserRepository $userRepository,
    private \Application\Services\UserService $userService
  ) {

  }

  public function execute(?string $filter, ?int $userId): array {
    if ($userId !== null) {
      $singleUser = [];
      $singleUser[] = $this->userRepository->getUser($userId);
      return $singleUser;
    } else {
      return $filter == null || $filter == "" ? $this->userRepository->getAllUsers($this->userService->getUserId()) : $this->userRepository->getUserForNickName($filter, $this->userService->getUserId());
    }
  }
}