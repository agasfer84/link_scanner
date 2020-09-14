create table link_files (
`id` int(11) NOT NULL AUTO_INCREMENT,
`directory_id` int(11) NULL,
`path` varchar(1000) NULL,
`status` tinyint(3) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`));