DROP TABLE IF EXISTS `ken`;
CREATE TABLE `ken` (
  `id` smallint(6) NOT NULL,
  `ken` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ken` (`id`, `ken`) VALUES
(1,	'北海道'),
(2,	'青森県'),
(3,	'岩手県'),
(4,	'宮城県'),
(5,	'秋田県'),
(6,	'山形県'),
(7,	'福島県'),
(8,	'茨城県'),
(9,	'栃木県'),
(10,	'群馬県'),
(11,	'埼玉県'),
(12,	'千葉県'),
(13,	'東京都'),
(14,	'神奈川県'),
(15,	'新潟県'),
(16,	'富山県'),
(17,	'石川県'),
(18,	'福井県'),
(19,	'山梨県'),
(20,	'長野県'),
(21,	'岐阜県'),
(22,	'静岡県'),
(23,	'愛知県'),
(24,	'三重県'),
(25,	'滋賀県'),
(26,	'京都府'),
(27,	'大阪府'),
(28,	'兵庫県'),
(29,	'奈良県'),
(30,	'和歌山県'),
(31,	'鳥取県'),
(32,	'島根県'),
(33,	'岡山県'),
(34,	'広島県'),
(35,	'山口県'),
(36,	'徳島県'),
(37,	'香川県'),
(38,	'愛媛県'),
(39,	'高知県'),
(40,	'福岡県'),
(41,	'佐賀県'),
(42,	'長崎県'),
(43,	'熊本県'),
(44,	'大分県'),
(45,	'宮崎県'),
(46,	'鹿児島県'),
(47,	'沖縄県');

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `profile_image` varchar(128) DEFAULT NULL,
  `pref` varchar(50) DEFAULT NULL,
  `seimei` varchar(50) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `member` (`user_id`, `user_name`, `profile_image`, `pref`, `seimei`, `phone`, `email`, `user_password`) VALUES
(3,	'ginzo',	'michaeljacson.jpg',	NULL,	'tanaka',	'09012341234',	'satojiro13@gmail.com',	'$2y$10$0t4YUapK9e8nHOc.x6qe3.343QLMte1ZPLGZuDlYOeDFnWYY0Dnsm');

DROP TABLE IF EXISTS `premember`;
CREATE TABLE `premember` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `birthday` char(8) DEFAULT NULL,
  `ken` smallint(6) DEFAULT NULL,
  `link_pass` varchar(128) DEFAULT NULL,
  `reg_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `premember` (`id`, `username`, `password`, `last_name`, `first_name`, `birthday`, `ken`, `link_pass`, `reg_date`) VALUES
(2,	'satojiro13@gmail.com',	'$2y$10$ynsGvp2jy2uEhjAY4x6LeeWnmuxT9vMLhad2O7a/MI3S7VijvFJju',	'中田',	'六郎',	'20190806',	11,	'fcce9a210c09cae6f57f699ee35570149f98088bebbfc8355db805a8914b5d3c',	'2019-08-06 17:45:36');

