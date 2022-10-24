<?php

namespace Application;

class StatisticalDataQuery {
  public function __construct(private Interfaces\UserRepository $userRepository,
                              private Interfaces\BlogEntryRepository $blogEntryRepository){
  }

  public function execute(): array {
    return array(
      'usersCount' => $this->userRepository->getUserCount(),
      'blogEntryCount' => $this->blogEntryRepository->getBlogEntryCount(),
      'blogEntryCountLastHours' => $this->blogEntryRepository->getBlogEntryCountForHours(),
      'dateOfLastPost' => $this->blogEntryRepository->getLastBlogEntryDate()
    );
  }
}