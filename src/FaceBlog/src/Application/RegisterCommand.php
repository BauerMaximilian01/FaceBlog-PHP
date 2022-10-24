<?php

namespace Application;

class RegisterCommand
{

  const Error_UsernameAlreadyExists = 0x01; // 1
  const Error_PasswordDifferent = 0x02; // 2
  const Error_InvalidUsername = 0x04; // 4
  const Error_InvalidPassword = 0x08; // 8
  const Error_CreateUserFailed = 0x10; // 16

  public function __construct(
    private \Application\Interfaces\UserRepository $userRepository
  ) { }

  public function execute(string $username, string $nickname, string $password, string $passwordConfirmation): int {
    $errors = 0;
    $username = trim($username);

    if($this->userRepository->getUserForUserName($username) !== null) {
      $errors |= self::Error_UsernameAlreadyExists;
    } else {

      if($password !== $passwordConfirmation) {
        $errors |= self::Error_PasswordDifferent;
      }

      if(strlen($username) == 0) {
        $errors |= self::Error_InvalidUsername;
      }

      if(strlen($password) < 4) {
        $errors |= self::Error_InvalidPassword;
      }

      if(!$errors) {
        $this->userRepository->createUser($username, $nickname, $password);
      }
    }

    return $errors;
  }
}
