<?php
    // Database configuration
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbName = 'twitter-12';

    // Connect to MySQL
    $conn = new mysqli($host, $user, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database if it does not exist
    $sql = "CREATE DATABASE IF NOT EXISTS `{$dbName}`";
    if ($conn->query($sql)) {
        echo "twitter-12 created successfully<br>";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    // Select the database
    $conn->select_db($dbName);

    // Create users table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
      `id` int NOT NULL AUTO_INCREMENT,
      `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
      `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`(100))
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'users' created successfully<br>";
    } else {
        echo "Error creating table 'users': " . $conn->error;
    }

    // Create followers table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS `followers` (
      `id` int NOT NULL AUTO_INCREMENT,
      `follower` int NOT NULL,
      `is_following` int NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `followers_relation_users` (`follower`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'followers' created successfully<br>";
    } else {
        echo "Error creating table 'followers': " . $conn->error;
    }

    // Create tweets table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS `tweets` (
      `id` int NOT NULL AUTO_INCREMENT,
      `user_id` int NOT NULL,
      `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `tweets_relation_users` (`user_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'tweets' created successfully";
    } else {
        echo "Error creating table 'tweets': " . $conn->error;
    }

    // Close the connection
    $conn->close();

    // Redirect to the homepage after 5 seconds
    header("refresh:5;url=index.php");
