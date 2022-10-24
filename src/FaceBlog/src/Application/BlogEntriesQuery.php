<?php

namespace Application;

class BlogEntriesQuery {
  public function __construct(private Interfaces\BlogEntryRepository $blockEntryRepository, private \Application\SignedInUserQuery $signedInUserQuery) {
  }

  public function execute(int $userId): array {
    return $this->blockEntryRepository->getBlogEntriesForUserId($userId);
  }
}