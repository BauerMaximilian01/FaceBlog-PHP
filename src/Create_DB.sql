SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS faceblog;

CREATE DATABASE IF NOT EXISTS faceblog DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE faceblog;

-- table creation
CREATE TABLE users (
                         id int(11) NOT NULL,
                         userName varchar(255) NOT NULL,
                         nickName varchar(255) NOT NULL,
                         passwordHash char(60) NOT NULL,
                         registeredOn TIMESTAMP NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE blogentries (
                            id int(11) NOT NULL,
                            subject varchar(255) NOT NULL,
                            content LONGTEXT NOT NULL,
                            createdOn TIMESTAMP NOT NULL,
                            userid int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE likes (
                           userid int(11) NOT NULL,
                           blogid int (11) NOT NULL,
                           likedOn TIMESTAMP NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- primary keys
ALTER TABLE users
    ADD PRIMARY KEY (id);

ALTER TABLE blogentries
    ADD PRIMARY KEY (id);

ALTER TABLE likes
    ADD PRIMARY KEY (userid, blogid);

-- auto incrementing ids
ALTER TABLE users
    MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE blogentries
    MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE blogentries
    ADD CONSTRAINT blogentries_userid_fk FOREIGN KEY (userid) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE likes
    ADD CONSTRAINT likes_userid_fk FOREIGN KEY (userid) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT likes_blogid_fk FOREIGN KEY (blogid) REFERENCES blogentries (id) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;