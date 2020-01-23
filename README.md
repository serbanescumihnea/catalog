# catalogCNEC
Database Create Query:
1. Database name = credentials
                CREATE TABLE IF NOT EXISTS `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) NOT NULL,
                `password` varchar(255) NOT NULL,
                `class` varchar(5) NOT NULL,
                `created_at` datetime DEFAULT current_timestamp(),
                `clearText_pass` varchar(255) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `name` (`name`)
                ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
