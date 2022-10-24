<?php

namespace Application;

class SignInCommand{
    public function __construct(private Services\UserService $userService, private Interfaces\UserRepository $userRepository) {
    }

    public function execute(string $username, string $password) : bool {
        $user = $this->userRepository->getUserForUsername(trim($username));

        if($user != null && password_verify($password, $user->getPasswordHash())) {
            $this->userService->signIn($user->getId());
            return true;
        }
        return false;           
    }
}