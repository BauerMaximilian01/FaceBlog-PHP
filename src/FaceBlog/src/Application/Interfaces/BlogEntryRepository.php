<?php

namespace Application\Interfaces;

interface BlogEntryRepository {
  public function getBlogEntryCount(): int;
  public function getBlogEntryCountForHours(): int;
  public function getLastBlogEntryDate(): string;
  public function getBlogEntriesForUserId(int $userId): array;
  public function checkIfBlogEntryExists(int $blogId): int;
  public function removeBlogEntry(int $blogId);
  public function createBlogPost(int $userId, string $subject, string $content): ?int;
}