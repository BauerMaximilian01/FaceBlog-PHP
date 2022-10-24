<?php

namespace Application\Interfaces;

interface UserRepository{
    public function getUserForUsername(string $username) : ?\Application\Entities\User;
    public function getUserForNickName(string $filter, int $exceptId): array;
    public function getUser(int $userId) : ?\Application\Entities\User;
    public function getAllUsers(int $exceptId) : array;
    public function getUserCount(): ?int;
    public function createUser(string $userName, string $nickname, string $password) : int;
}