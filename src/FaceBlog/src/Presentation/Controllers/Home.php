<?php

namespace Presentation\Controllers;

use Presentation\MVC\ActionResult;
use Presentation\MVC\Controller;

class Home extends Controller{

    public function __construct(
      private \Application\StatisticalDataQuery $statisticalDataQuery,
      private \Application\SignedInUserQuery $signedInUserQuery
    ) {
    }

    public function GET_Index() : ActionResult
    {
      $statisticalData = $this->statisticalDataQuery->execute();
      return $this->view('home', [
        'user' => $this->signedInUserQuery->execute(),
        'usersCount' => $statisticalData['usersCount'],
        'blogEntryCount' => $statisticalData['blogEntryCount'],
        'blogEntryCountLastHours' => $statisticalData['blogEntryCountLastHours'],
        'dateOfLastPost' => $statisticalData['dateOfLastPost']
      ]);
    }
}