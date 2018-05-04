SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `phpproject`.`ip_users` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status_id` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

ALTER TABLE `phpproject`.`ip_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip_address` (`ip_address`);

ALTER TABLE `phpproject`.`ip_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

INSERT INTO `phpproject`.`ip_users` (`id`, `ip_address`, `status_id`, `created`, `updated`) VALUES
(20, '172.17.0.1', 1, '2018-05-03 09:11:57', '2018-05-03 09:11:57');

CREATE TABLE `phpproject`.`todos` (
  `todo_id` int(11) NOT NULL,
  `list_id` int(11) DEFAULT NULL,
  `ip_user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `content` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

ALTER TABLE `phpproject`.`todos`
  ADD PRIMARY KEY (`todo_id`);

ALTER TABLE `phpproject`.`todos`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

INSERT INTO `phpproject`.`todos` (`todo_id`, `list_id`, `ip_user_id`, `status_id`, `content`, `completed`, `date_created`, `date_modified`) VALUES
(1, NULL, 20, -1, 'todo item A', 0, '2018-05-01 00:00:00', '2018-05-03 22:12:02'),
(2, NULL, 20, -1, 'todo item B', 0, '2018-05-02 00:00:00', '2018-05-03 23:36:55'),
(3, NULL, 20, -1, 'todo item C', 0, '2018-05-04 00:00:00', '2018-05-03 22:13:56'),
(4, NULL, 20, -1, 'todo item D', 0, '2018-05-05 00:00:00', '2018-05-03 22:14:00'),
(5, NULL, 20, -1, 'asdfasdf', 0, '2018-05-03 22:39:26', '2018-05-03 23:36:56'),
(6, NULL, 20, -1, 'bbb', 0, '2018-05-03 22:39:31', '2018-05-03 23:36:57'),
(7, NULL, 20, -1, 'asdfasdfasd lkajsdf;lakjsd ', 1, '2018-05-03 22:39:38', '2018-05-03 22:41:16'),
(8, NULL, 20, -1, 'asdfasdf', 0, '2018-05-03 22:40:50', '2018-05-03 23:36:58'),
(9, NULL, 20, 1, 'Email friend from school', 1, '2018-05-03 23:38:13', '2018-05-03 23:41:30'),
(10, NULL, 20, 1, 'Write a blog post on a new technology', 0, '2018-05-03 23:39:40', '2018-05-03 23:39:40'),
(11, NULL, 20, 1, 'Call coworker about a project question.', 1, '2018-05-03 23:40:00', '2018-05-03 23:41:27'),
(12, NULL, 20, 1, 'Edit existing blog posts.', 0, '2018-05-03 23:40:18', '2018-05-03 23:40:18'),
(13, NULL, 20, 1, 'Refactor code to ensure no conflicts in PHP 7.x', 0, '2018-05-03 23:40:40', '2018-05-03 23:41:29'),
(14, NULL, 20, 1, 'Learn Angular and apply to frontend.', 0, '2018-05-03 23:40:54', '2018-05-03 23:40:54'),
(15, NULL, 20, 1, 'Add a user login function to this app.', 0, '2018-05-03 23:41:05', '2018-05-03 23:41:05');
