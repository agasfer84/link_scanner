create table link_links (
`id` int(11) NOT NULL AUTO_INCREMENT,
`file_id` int(11) NULL,
`link` varchar(1000) NULL,
`status` tinyint(3) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`));