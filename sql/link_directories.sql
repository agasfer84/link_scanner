create table link_directories (
`id` int(11) NOT NULL AUTO_INCREMENT,
`project_id` int(11) NULL,
`path` varchar(1000) NULL,
`status` tinyint(3) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`));