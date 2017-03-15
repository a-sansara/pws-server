CREATE TABLE `users` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `roles` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6E736E72F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- user dev : foo
INSERT INTO `users` (`id`, `name`, `username`, `password`, `key`, `roles`) VALUES ('', 'Meta-Tech', 'dev', 'EZJ4em8bQ409UiPU+LpfJ5IWpiTkT2lSzMkVEl3IP5A0TDRV+RZS1Q==', 'ed830045da9861d29c46f36b4f4b1a4d4b223408667c52428370e51b615e8769', 'ROLE_ADMIN');
