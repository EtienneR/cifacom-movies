/* CREATE DATABASE IF NOT EXISTS api; */

CREATE TABLE IF NOT EXISTS `movies` (
  `id_movie` int(11) NOT NULL AUTO_INCREMENT,
  `name_movie` varchar(255) NOT NULL,
  `author_movie` varchar(255) NOT NULL,
  `date_movie` date NOT NULL,
  PRIMARY KEY (`id_movie`)
);

INSERT INTO `movies` (`id_movie`, `name_movie`, `author_movie`, `date_movie`) VALUES
(1, 'Yves Saint Laurent', 'Jalil Lespert', '2014-01-08'),
(2, 'Philomena', 'Stephen Frears', '2014-01-08'),
(3, 'Homefront', 'Gary Fleder', '2014-01-08'),
(4, 'Le Loup de Wall Street', 'Martin Scorsese', '2013-12-25');


CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email_user` varchar(255) NOT NULL,
  `pass_user` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
);

INSERT INTO `users` (`id_user`, `email_user`, `pass_user`) VALUES
(1, 'admin@admin.com', 'pass');


CREATE TABLE IF NOT EXISTS `likes`(
	`id_like` int(11) NOT NULL AUTO_INCREMENT,
	`id_user` int(11) NOT NULL,
	`id_movie` int(11) NOT NULL,
	`like_like` int(11) NOT NULL,
	`seen_like` int(11) NOT NULL,
	`would_see_like` int(11) NOT NULL,
	PRIMARY KEY (`id_like`),
	KEY (`id_user`),
	KEY (`id_movie`)
);

ALTER TABLE `likes`
  ADD CONSTRAINT `fk_movie_id` FOREIGN KEY (`id_movie`) REFERENCES `movies` (`id_movie`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)