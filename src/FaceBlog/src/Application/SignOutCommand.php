<?php

namespace Application;

class SignOutCommand{
    public function __construct(private Services\UserService $userService) {
    }

    public function execute()
    {
        $this->userService->signOut();
    }
}