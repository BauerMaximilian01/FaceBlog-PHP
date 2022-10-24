<?php

namespace Application\Interfaces;

interface LikeRepository {
  public function checkIfAlreadyLiked(int $userId, int $blogId): int;
  public function likeBlogPost(int $userId, int $blogId);
  public function removeLikeOfBlog(int $userId, int $blogId);
  public function getLikesOfBlogPost(int $blogId): int;
  public function getLikedByOfBlogPost(int $blogId): array;
}