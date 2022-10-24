<?php

namespace Application\Entities;

class BlogEntry {
  private int $likes = 0;
  private array $likedBy = [];

  public function __construct(private int $blogId, private string $blogSubject, private string $blogContent, private string $datetime) {
  }

  public function setLikes(int $likes) {
    $this->likes = $likes;
  }

  public function setLikedBy(array $likedBy) {
    $this->likedBy = $likedBy;
  }

  public function getBlogId(): int {
    return $this->blogId;
  }

  public function getBlogSubject(): string {
    return $this->blogSubject;
  }

  public function getBlogContent(): string{
    return $this->blogContent;
  }

  public function getBlogEntryDate(): string {
    return $this->datetime;
  }

  public function getLikes(): int {
    return $this->likes;
  }

  public function getLikedByAsString(): string {
    $result = '';

    for ($i = 0; $i < sizeof($this->likedBy); $i++) {
      if ($i != 0) {
        $result = $result . ', ';
      }
      $result = $result . $this->likedBy[$i]->getNickName();
    }

    return $result;
  }
}