<?php

namespace Application;

class UserData
{
    public function __construct(
        private int $id,
        private string $userName,
        private string $nickName,
        private string $memberSince
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getNickName(): string {
      return $this->nickName;
    }

    public function getMemberSince(): string {
      return $this->memberSince;
    }
}
