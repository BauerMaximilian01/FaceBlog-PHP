<?php
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
// configure service provider
$sp = new ServiceProvider();
//Application
$sp->register(\Application\BlogEntriesQuery::class);
$sp->register(\Application\UserQuery::class);
$sp->register(\Application\LikeQuery::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\StatisticalDataQuery::class);
$sp->register(\Application\AddBlogCommand::class);
$sp->register(\Application\RemoveBlogCommand::class);
$sp->register(\Application\CreateRemoveLikeCommand::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\RegisterCommand::class);
$sp->register(\Application\Services\UserService::class);

//Infrastructure
$sp->register(\Infrastructure\Session::class, isSingleton:true);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);
$sp->register(\Infrastructure\Repository::class, function() {return new \Infrastructure\Repository("localhost", "root", "", "faceblog");});
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\BlogEntryRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\LikeRepository::class, \Infrastructure\Repository::class);


//Presentation
$sp->register(\Presentation\MVC\MVC::class, function() {
    return new \Presentation\MVC\MVC();
}, true);
$sp->register(Presentation\Controllers\Home::class);
$sp->register(Presentation\Controllers\BlogEntries::class);
$sp->register(Presentation\Controllers\Likes::class);
$sp->register(Presentation\Controllers\User::class);

$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);