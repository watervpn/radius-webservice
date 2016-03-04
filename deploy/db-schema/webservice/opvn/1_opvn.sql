CREATE TABLE `opvn_client_key` (
      `account_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `crt` text COLLATE utf8_unicode_ci NOT NULL,
      `key` text COLLATE utf8_unicode_ci NOT NULL,
      `csr` text COLLATE utf8_unicode_ci NOT NULL,
      `modified` datetime NOT NULL,
      PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `opvn_client_param` (
      `account_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `params` text COLLATE utf8_unicode_ci NOT NULL,
      `modified` date NOT NULL,
      `dirty` tinyint(1) NOT NULL,
      PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `opvn_client_config` (
      `account_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `config` text COLLATE utf8_unicode_ci,
      `modified` datetime NOT NULL,
      PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
