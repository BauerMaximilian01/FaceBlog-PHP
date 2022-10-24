SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

INSERT INTO users (userName, nickName, passwordHash, registeredOn)
    VALUES("Franzi Huber", "franZL123", "$2y$10$uNZSlrTp4EDZj1VuwVcj/.rLFXw9v2KsjXJOjucne5egRTwZYeclS", NOW());
INSERT INTO users (userName, nickName, passwordHash, registeredOn)
    VALUES("Susanne Mair", "suslsBlog69", "$2y$10$W2nOIoEeXGOy.gJc/ka4CeKtuagsH4S8U3ZPEMFMQ16A.az1i.7VO", NOW());
INSERT INTO users (userName, nickName, passwordHash, registeredOn)
    VALUES("MaxBauer", "WhosTheKing", "$2y$10$NTdM2nAV92RhSOWcKUqpN.F142qrbDQufTJ6SJo9bUrzZK.kNc//y", NOW());

INSERT INTO blogentries(subject, content, createdOn, userid)
    VALUES("My first Blog post", "Hey there this is my first blogPost. I am an old handsome Farmer in North Carolina with many many many Cows. So if you are interested feel free to Contact me!", NOW(), 1);
INSERT INTO blogentries(subject, content, createdOn, userid)
    VALUES("My second Blog post", "Hey there this is my second blogPost. Today I fed my cows at 5am and it was really relaxing and nice. Yours franz", NOW(), 1);

INSERT INTO blogentries(subject, content, createdOn, userid)
    VALUES("Susi looking for you", "First of all I want to introduce myself. I am Susi, 69 years old and I am looking for a handsome, gentle and cowboy-like man to enjoy the evenings and the beautiful sunsets together on my terrace at my beach house in Hawaii. Let the hunt begin:).", NOW(), 2);
INSERT INTO blogentries(subject, content, createdOn, userid)
    VALUES("Hi franz", "Dear franz I saw your first Blog Post and currently I am trying to reach out to you. I really wanna get to know you, since you are the type of man I desire. Please don't hesitate to contact me if you read this. \nYours Susi xoxo", NOW(), 2);
INSERT INTO blogentries(subject, content, createdOn, userid)
    VALUES("Franz it's me again!", "My dearest Franz. \nIt's been a while since I heard from. I just wanted to tell you how much I like your Blog Posts, also if the subject isn't very creative. Please start writing again and I hope you do fine. \nYour admirer Susi <3", NOW(), 2);

INSERT INTO blogentries(subject, content, createdOn, userid)
    VALUES("This is a test with an lorem ipsum text to see if this website works properly", "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet", NOW(), 3);

INSERT INTO likes(userid, blogid, likedOn)
    VALUES(2, 1, NOW());
INSERT INTO likes(userid, blogid, likedOn)
    VALUES(2, 2, NOW());

INSERT INTO likes(userid, blogid, likedOn)
    VALUES(1, 3, NOW());

INSERT INTO likes(userid, blogid, likedOn)
    VALUES(3, 3, NOW());
INSERT INTO likes(userid, blogid, likedOn)
    VALUES(3, 4, NOW());
INSERT INTO likes(userid, blogid, likedOn)
    VALUES(3, 5, NOW());

INSERT INTO likes(userid, blogid, likedOn)
    VALUES(1, 6, NOW());
INSERT INTO likes(userid, blogid, likedOn)
    VALUES(2, 6, NOW());
COMMIT;
