# catalogCNEC
Database Create Query:
1. Database name = credentials
               CREATE TABLE IF NOT EXISTS `note` (
                 `nume` varchar(50) NOT NULL,
                 `materie` varchar(30) NOT NULL,
                 `nota` int(5) NOT NULL DEFAULT 0,
                 `teza` bit(1) NOT NULL DEFAULT b'0',
                 `clasa` varchar(5) NOT NULL
               ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
2.              CREATE TABLE IF NOT EXISTS `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `password` varchar(255) NOT NULL,
                `class` varchar(5) NOT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `clearText_pass` varchar(255) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`)
                ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
3.              CREATE TABLE IF NOT EXISTS `absente` (
                `nume` varchar(50) DEFAULT NULL,
                `materie` varchar(50) DEFAULT NULL,
                `data` varchar(50) DEFAULT NULL,
                `activa` bit(1) DEFAULT b'1'
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  

