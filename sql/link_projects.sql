create table link_projects (
`id` int(11) NOT NULL AUTO_INCREMENT,
`path` varchar(1000) NULL,
`status` tinyint(3) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`));