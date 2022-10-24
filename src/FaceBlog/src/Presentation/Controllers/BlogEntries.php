<?php

namespace Presentation\Controllers;

class BlogEntries extends \Presentation\MVC\Controller
{
  public function __construct(private \Application\BlogEntriesQuery  $blogEntriesQuery, private \Application\SignedInUserQuery $signedInUserQuery,
                              private \Application\AddBlogCommand    $addBlogCommand, private \Application\UserQuery $userQuery,
                              private \Application\RemoveBlogCommand $removeBlogCommand, private \Application\LikeQuery $likeQuery) {
  }

  public function GET_Index(): \Presentation\MVC\ActionResult {
    $user = $this->signedInUserQuery->execute();
    $blogs = [];
    $errors = [];

    if ($user != null) {
      $blogs = $this->blogEntriesQuery->execute($user->getId());

      foreach ($blogs as $b) {
        $likes = $this->likeQuery->execute($b->getBlogId());
        $b->setLikes($likes['likes']);
        $b->setLikedBy($likes['likedBy']);
      }
    } else {
      $errors[] = "Please Login first.";
    }

    if (sizeof($errors) > 0) {
      return $this->view("blogList", [
        'blogEntries' => $blogs,
        'user' => $user,
        'errors' => $errors
      ]);
    }

    return $this->view('blogList', [
      'blogEntries' => $blogs,
      'user' => $user
    ]);
  }

  public function GET_OtherPeopleBlog(): \Presentation\MVC\ActionResult {
    $user = $this->signedInUserQuery->execute();
    $errors = [];
    $blogs = null;
    if (!$this->tryGetParam('otherUid', $userId)) {
      $errors[] = "Person does not exist.";
    } else if ($user == null) {
      $errors[] = "Please Login first.";

      if ($this->signedInUserQuery->execute() == null) {
        return $this->view('blogList', [
          'user' => null,
          'errors' => $errors
        ]);
      }
    } else {
      $blogs = $this->blogEntriesQuery->execute($userId);

      foreach ($blogs as $b) {
        $likes = $this->likeQuery->execute($b->getBlogId());
        $b->setLikes($likes['likes']);
        $b->setLikedBy($likes['likedBy']);
      }

      if ($blogs === null) {
        $errors[] = "Person has no Blogs posted yet.";
      }
    }

    if (sizeof($errors) > 0) {
      return $this->view('otherPeopleBlogList', [
        'blogEntries' => $blogs,
        'otherUser' => $this->userQuery->execute(null, $userId)[0],
        'user' => $this->signedInUserQuery->execute(),
        'errors' => $errors
      ]);
    }

    return $this->view('otherPeopleBlogList', [
      'blogEntries' => $blogs,
      'otherUser' => $this->userQuery->execute(null, $userId)[0],
      'user' => $this->signedInUserQuery->execute()
    ]);
  }


  public function GET_Create(): \Presentation\MVC\ActionResult {
    $user = $this->signedInUserQuery->execute();
    $errors = [];

    if ($user == null) {
      $errors[] = "Please Login first.";

      if ($this->signedInUserQuery->execute() == null) {
        return $this->view('blogList', [
          'user' => null,
          'errors' => $errors
        ]);
      }
    }

    return $this->view('createPostForm', [
      'user' => $this->signedInUserQuery->execute()
    ]);
  }

  public function POST_Create(): \Presentation\MVC\ActionResult {
    $blogSubject = $this->getParam('bs');
    $blogContent = $this->getParam('bc');

    $result = $this->addBlogCommand->execute($blogSubject, $blogContent);
    if ($result) {
      $errors = [];

      if ($result & \Application\AddBlogCommand::ERROR_NOT_AUTHENTICATED)
        $errors[] = "You are not Logged in.";

      if ($result & \Application\AddBlogCommand::ERROR_SUBJECTEMPTY)
        $errors[] = "Subject of Post must not be empty.";

      if ($result & \Application\AddBlogCommand::ERROR_SUBJECTTOOLONG)
        $errors[] = "Subject of Post is too long. Maximum Length is 255 characters.";

      if ($result & \Application\AddBlogCommand::ERROR_CONTENTEMPTY)
        $errors[] = "Content of Post must not be empty.";

      if ($result & \Application\AddBlogCommand::ERROR_CREATEPOSTFAILED)
        $errors[] = "Something went wrong.";

      return $this->view('createPostForm', [
        'blogId' => 0,
        'subject' => $blogSubject,
        'content' => $blogContent,
        'errors' => $errors,
        'user' => null
      ]);
    }

    return $this->redirect('BlogEntries', 'Index', []);
  }

  public function POST_Remove(): \Presentation\MVC\ActionResult {
    $blogId = $this->getParam('bid');
    $user = $this->signedInUserQuery->execute();

    if ($user === null) {
      $result = $this->removeBlogCommand->execute($blogId, null);
    } else {
      $result = $this->removeBlogCommand->execute($blogId, $user->getId());
    }

    if ($result != 0) {
      $errors = [];

      if ($result & \Application\RemoveBlogCommand::ERROR_NOTLOGGEDIN)
        $errors[] = "Please Login first.";

      if ($result & \Application\RemoveBlogCommand::ERROR_BLOGNOTEXISTING)
        $errors[] = "The blog you are trying to delete doesn't exist.";

      return $this->view('blogList', [
        "user" => $user,
        "blogEntries" => $this->blogEntriesQuery->execute($user->getId()),
        "errors" => $errors
      ]);
    }

    return $this->redirect("BlogEntries", 'Index', []);
  }
}