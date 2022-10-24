<?php

namespace Application\Entities;

class Like {
  public function __construct(private array $likesAndLikedBy) {

  }

  public function getLikes(): int {
    return $this->likesAndLikedBy['likes'];
  }

  public function getLikesBy(): array {
    return $this->likesAndLikedBy['likedBy'];
  }

  public function getLikesByAsString(): string {
    $result = '';

    foreach($this->likesAndLikedBy['likedBy'] as $likedFrom) {
      $result = $result . ' ' . $likedFrom;
    }

    $result = str_replace(' ', ', ', $result);

    return $result;
  }
}