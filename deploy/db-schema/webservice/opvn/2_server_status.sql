CREATE TABLE `opvn_server_status` (
      `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `region` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
      `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
      `total_users` smallint(6) DEFAULT NULL,
      `download` float DEFAULT NULL,
      `upload` float DEFAULT NULL,
      `download_avail` float DEFAULT NULL,
      `upload_avail` float DEFAULT NULL,
      `cpu` float NOT NULL,
      `mem` float NOT NULL,
      `eth` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
      `info` text COLLATE utf8_unicode_ci,
      `modified` datetime DEFAULT NULL,
      PRIMARY KEY (`host`),
      KEY `server` (`host`),
      KEY `region` (`region`),
      KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

insert into opvn_server_status (host,region,city,total_users,download,upload,download_avail,upload_avail,cpu,mem,eth,info,modified) values ('ca1', 'Canada', 'Montreal',NULL,0,0,100000,100000,0,0,'ens32',NULL,'2016-03-03 13:47:10');
insert into opvn_server_status (host,region,city,total_users,download,upload,download_avail,upload_avail,cpu,mem,eth,info,modified) values ('jp1', 'Japan', 'Tokyo',NULL,0,0,100000,100000,0,0,'ens32',NULL,'2016-03-03 13:47:10');
