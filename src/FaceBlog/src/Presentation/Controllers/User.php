<?php

namespace Presentation\Controllers;

class User extends \Presentation\MVC\Controller{

  public function __construct(private \Application\SignInCommand     $signInCommand, private \Application\SignOutCommand $signOutCommand,
                              private \Application\SignedInUserQuery $signedInUserQuery, private \Application\RegisterCommand $registerCommand,
                              private \Application\UserQuery $userQuery) {
    }

    public function GET_LogIn() : \Presentation\MVC\ActionResult
    {
        return $this->view('logIn', [
            'userName' => '',
            'user' => $this->signedInUserQuery->execute()
        ]);
    }

    public function POST_LogIn() : \Presentation\MVC\ActionResult {
        if(!$this->signInCommand->execute($this->getParam('un'), $this->getParam('pwd'))){
            return $this->view('logIn', [
                'userName' => $this->getParam('un'),
                'errors' => ['Invalid username or password.'],
                'user' => $this->signedInUserQuery->execute()
            ]);
        }

        return $this->redirect('Home', 'Index');
    }

    public function POST_LogOut(): \Presentation\MVC\ActionResult
    {
        $this->signOutCommand->execute();
        return $this->redirect('User', 'LogIn');
    }

  public function GET_Register() : \Presentation\MVC\ActionResult {
    // only show register view when there is no authenticated user
    $user = $this->signedInUserQuery->execute();
    if($user != null) {
      return $this->redirect("Home", "Index");
    }
    return $this->view("register", [
      "userName" => "",
      "nickName" => "",
      "password" => "",
      "passwordConfirmation" => "",
      "user" => null
    ]);
  }

  public function POST_Register(): \Presentation\MVC\ActionResult {
    $userName = $this->getParam("un");
    $nickName = $this->getParam('ni');
    $password = $this->getParam("pwd");
    $passwordConfirmation = $this->getParam("pwdConf");
    $result = $this->registerCommand->execute(
      $userName,
      $nickName,
      $password,
      $passwordConfirmation
    );

    // Check for errors
    if($result != 0) {
      $errors = [];
      if($result & \Application\RegisterCommand::Error_UsernameAlreadyExists) {
        $errors[] = "User with username already exists.";
      }
      if($result & \Application\RegisterCommand::Error_CreateUserFailed) {
        $errors[] = "User creation failed.";
      }
      if($result & \Application\RegisterCommand::Error_InvalidUsername) {
        $errors[] = "Username is required.";
      }
      if($result & \Application\RegisterCommand::Error_InvalidPassword) {
        $errors[] = "Password is required and needs a minimum length of 4.";
      }

      if($result & \Application\RegisterCommand::Error_PasswordDifferent) {
        $errors[] = "Password does not match with confirmation.";
      }

      if(sizeof($errors) == 0) {
        $errors[] = "Something went wrong.";
      }

      return $this->view("register", [
        "userName" => $userName,
        "nickName" => $nickName,
        "password" => $password,
        "passwordConfirmation" => $passwordConfirmation,
        "user" => null,
        "errors" => $errors
      ]);
    }

    //sign in if successful
    $ok = $this->signInCommand->execute($userName, $password);

    if(!$ok) {
      return $this->view("register", [
        "userName" => $userName,
        "nickName" => $nickName,
        "password" => $password,
        "passwordConfirmation" => $passwordConfirmation,
        "user" => null,
        "errors" => ["Sign in after registration was unsuccessful!"]
      ]);
    }

    return $this->redirect("Home", "Index");
  }

  public function GET_Index(): \Presentation\MVC\ActionResult {
    $filter = $this->tryGetParam('filter', $filter) ? trim($filter) : null;
    $errors = [];

    if ($this->signedInUserQuery->execute() === null) {
      $errors[] = "Please Login first.";

      return $this->view("peopleList", [
        'user' => null,
        'people' => null,
        'filter' => $filter,
        'errors' => $errors
      ]);
    }

    return $this->view("peopleList", [
      'user' => $this->signedInUserQuery->execute(),
      'people' => $this->userQuery->execute($filter, null),
      'filter' => $filter
    ]);
  }
}