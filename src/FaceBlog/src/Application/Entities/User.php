<?php

namespace Application\Entities;

class User{
    public function __construct(private int $userId, private string $username, private string $nickName, private string $passwordHash) {
    }

    public function getId(): int {
        return $this->userId;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getNickName(): string {
      return $this->nickName;
    }

    public function getPasswordHash(): string {
        return $this->passwordHash;
    }
}