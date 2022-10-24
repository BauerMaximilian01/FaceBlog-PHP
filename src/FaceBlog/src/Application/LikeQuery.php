<?php

namespace Application;

class LikeQuery {
  public function __construct(private \Application\Interfaces\LikeRepository $likeRepository) {
  }

  public function execute(int $blogId): array {
    $likes = $this->likeRepository->getLikesOfBlogPost($blogId);
    $likedBy = $this->likeRepository->getLikedByOfBlogPost($blogId);

    return [
      'likes' => $likes,
      'likedBy' => $likedBy
    ];
  }
}