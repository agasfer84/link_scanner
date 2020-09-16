create table link_projects (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NULL,
`status` tinyint(3) NOT NULL DEFAULT 0,
`charset` varchar(20) NULL,
PRIMARY KEY (`id`));