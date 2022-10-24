<?php

namespace Infrastructure;

class Repository
  implements
  \Application\Interfaces\BlogEntryRepository,
  \Application\Interfaces\UserRepository,
  \Application\Interfaces\LikeRepository {
  private $server;
  private $userName;
  private $password;
  private $database;

  public function __construct(string $server, string $userName, string $password, string $database) {
    $this->server = $server;
    $this->userName = $userName;
    $this->password = $password;
    $this->database = $database;
  }

  // === private helper methods ===

  private function getConnection() {
    $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
    if (!$con) {
      die('Unable to connect to database. Error: ' . mysqli_connect_error());
    }
    return $con;
  }

  private function executeQuery($connection, $query) {
    $result = $connection->query($query);
    if (!$result) {
      die("Error in query '$query': " . $connection->error);
    }
    return $result;
  }

  private function executeStatement($connection, $query, $bindFunc) {
    $statement = $connection->prepare($query);
    if (!$statement) {
      die("Error in prepared statement '$query': " . $connection->error);
    }
    $bindFunc($statement);
    if (!$statement->execute()) {
      die("Error executing prepared statement '$query': " . $statement->error);
    }
    return $statement;
  }

  // === public methods ===

  public function getUser(int $id): ?\Application\Entities\User {
    $user = null;
    $con = $this->getConnection();
    $stat = $this->executeStatement(
      $con,
      'SELECT id, userName, nickName, passwordHash FROM users WHERE id = ?',
      function ($s) use ($id) {
        $s->bind_param('i', $id);
      }
    );
    $stat->bind_result($id, $userName, $nickName, $passwordHash);
    if ($stat->fetch()) {
      $user = new \Application\Entities\User($id, $userName, $nickName, $passwordHash);
    }
    $stat->close();
    $con->close();
    return $user;
  }

  public function getUserForUserName(string $userName): ?\Application\Entities\User {
    $user = null;
    $con = $this->getConnection();
    $stat = $this->executeStatement(
      $con,
      'SELECT id, userName, nickName, passwordHash FROM users WHERE userName = ?',
      function ($s) use ($userName) {
        $s->bind_param('s', $userName);
      }
    );
    $stat->bind_result($id, $userName, $nickName, $passwordHash);
    if ($stat->fetch()) {
      $user = new \Application\Entities\User($id, $userName, $nickName, $passwordHash);
    }
    $stat->close();
    $con->close();
    return $user;
  }

  public function getUserForNickName(string $filter, int $exceptId): array {
    $filter = "%$filter%";
    $users = [];

    $con = $this->getConnection();
    $stat = $this->executeStatement(
      $con,
      'SELECT id, userName, nickName, DATEDIFF(NOW(), registeredOn) as datediff FROM users WHERE nickName LIKE ? && id != ?',
      function ($s) use ($filter, $exceptId) {
        $s->bind_param('si', $filter, $exceptId);
      });

    $stat->bind_result($id, $userName, $nickName, $datediff);
    while ($stat->fetch()) {
      $users[] = new \Application\UserData($id, $userName, $nickName, $datediff);
    }

    $stat->close();
    $con->close();

    return $users;
  }

  public function getAllUsers(int $exceptId): array {
    $users = [];

    $con = $this->getConnection();
    $stat = $this->executeStatement(
      $con,
      'SELECT id, userName, nickName, DATEDIFF(NOW(), registeredOn) as datediff FROM users WHERE id != ?',
      function ($s) use ($exceptId) {
        $s->bind_param('i', $exceptId);
      });

    $stat->bind_result($id, $userName, $nickName, $datediff);
    while ($stat->fetch()) {
      $users[] = new \Application\UserData($id, $userName, $nickName, $datediff);
    }

    $stat->close();
    $con->close();

    return $users;
  }

  public function getBlogEntryCount(): int {
    $id = 'id';

    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT COUNT(?) as counted FROM blogentries',
      function ($s) use ($id) {
        $s->bind_param('s', $id);
      });

    $count = 0;
    $stat->bind_result($count);
    if ($stat->fetch()) {
      return $count;
    }

    $stat->close();
    $con->close();

    return 0;
  }

  public function getBlogEntryCountForHours(): int {
    $id = 'id';

    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT COUNT(?) as counted FROM blogentries WHERE createdOn >= NOW() - INTERVAL 1 DAY', function ($s) use ($id) {
        $s->bind_param('s', $id);
      });

    $count = 0;
    $stat->bind_result($count);
    if ($stat->fetch()) {
      return $count;
    }

    $stat->close();
    $con->close();

    return 0;
  }

  public function getLastBlogEntryDate(): string {
    $what = 'createdOn';

    $con = $this->getConnection();
    $stat = $this->executeQuery($con,
      'SELECT MAX(createdOn) as latestPost FROM blogentries');

    $result = '';

    while ($entryDate = $stat->fetch_object()) {
      $result = $entryDate->latestPost;
    }

    return $result;
  }

  public function getBlogEntriesForUserId(int $userId): array {
    $result = [];

    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT id, subject, content, createdOn FROM blogentries WHERE userid = ? ORDER BY createdOn DESC', function ($s) use ($userId) {
        $s->bind_param('i', $userId);
      });

    $stat->bind_result($id, $subject, $content, $createdOn);
    while ($stat->fetch()) {
      $result[] = new \Application\Entities\BlogEntry($id, $subject, $content, $createdOn);
    }

    $stat->close();
    $con->close();

    return $result;
  }

  public function checkIfBlogEntryExists(int $id): int {
    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT COUNT(id) FROM blogentries WHERE id = ?',
      function ($s) use ($id) {
        $s->bind_param('i', $id);
      });

    $count = 0;
    $stat->bind_result($count);
    if ($stat->fetch())
      return $count;

    $stat->close();
    $con->close();

    return $count;
  }

  public function removeBlogEntry(int $blogId) {
    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'DELETE FROM blogentries WHERE id = ?',
      function ($s) use ($blogId) {
        $s->bind_param('i', $blogId);
      });

    $stat->close();

    $stat = $this->executeStatement($con,
      'DELETE FROM likes WHERE blogid = ?',
      function ($s) use ($blogId) {
        $s->bind_param('i', $blogId);
      });

    $stat->close();
    $con->close();
  }

  public function createBlogPost(int $userId, string $subject, string $content): ?int {
    $con = $this->getConnection();
    $statement = $this->executeStatement($con,
      'INSERT INTO blogentries (subject, content, createdOn, userid) VALUES (?, ?, NOW(), ?)',
      function ($s) use ($subject, $content, $userId) {
        $s->bind_param('ssi', $subject, $content, $userId);
      });

    $blogId = $statement->insert_id;
    $statement->close();
    $con->close();

    return $blogId;
  }

  public function getUserCount(): ?int {
    $id = 'id';

    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT COUNT(?) as counted FROM users',
      function ($s) use ($id) {
        $s->bind_param('s', $id);
      });

    $count = 0;
    $stat->bind_result($count);
    if ($stat->fetch()) {
      return $count;
    }

    $stat->close();
    $con->close();

    return 0;
    return 0;
  }

  public function createUser(string $userName, string $nickname, string $password): int {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $con = $this->getConnection();

    $stat = $this->executeStatement(
      $con,
      'INSERT INTO users (userName, nickName, passwordHash, registeredOn) VALUES (?, ?, ?, NOW())',
      function ($s) use ($userName, $nickname, $password) {
        $s->bind_param('sss', $userName, $nickname, $password);
      }
    );

    $userId = $stat->insert_id;
    $stat->close();
    $con->close();
    return $userId;
  }

  public function checkIfAlreadyLiked(int $userId, int $blogId): int {
    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT COUNT(userid) FROM likes WHERE userid = ? && blogid = ?',
      function ($s) use ($userId, $blogId) {
        $s->bind_param('ii', $userId, $blogId);
      });

    $count = 0;
    $stat->bind_result($count);
    if ($stat->fetch())
      return $count;

    $stat->close();
    $con->close();

    return $count;
  }

  public function likeBlogPost(int $userId, int $blogId) {
    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'INSERT INTO likes (userid, blogid, likedOn) VALUES (?, ?, NOW())',
      function ($s) use ($userId, $blogId) {
        $s->bind_param('ii', $userId, $blogId);
      });

    $stat->close();
    $con->close();
  }

  public function removeLikeOfBlog(int $userId, int $blogId) {
    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'DELETE FROM likes WHERE userid = ? && blogid = ?',
      function ($s) use ($userId, $blogId) {
        $s->bind_param('ii', $userId, $blogId);
      });

    $stat->close();
    $con->close();
  }

  public function getLikesOfBlogPost(int $blogId): int {
    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT COUNT(userid) FROM likes WHERE blogid = ?',
      function ($s) use ($blogId) {
        $s->bind_param('i', $blogId);
      });

    $count = 0;
    $stat->bind_result($count);
    if ($stat->fetch())
      return $count;

    $stat->close();
    $con->close();

    return 0;
  }

  public function getLikedByOfBlogPost(int $blogId): array {
    $con = $this->getConnection();
    $stat = $this->executeStatement($con,
      'SELECT likes.userid, userName, nickName, DATEDIFF(NOW(), registeredOn) as datediff FROM likes INNER JOIN users ON likes.userid = users.id 
            INNER JOIN blogentries ON likes.blogid = blogentries.id WHERE likes.blogid = ?',
      function ($s) use ($blogId) {
        $s->bind_param('i', $blogId);
      });

    $blogLikedBy = [];
    $stat->bind_result($id, $username, $nickname, $datediff);
    while ($stat->fetch()) {
      $blogLikedBy[] = new \Application\UserData($id, $username, $nickname, $datediff);
    }

    $stat->close();
    $con->close();

    return $blogLikedBy;
  }
}
