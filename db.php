<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogs";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("connection failed: " . $connection->connect_error);
}
// echo "connected successfully<br>";

// SQL Queries
$sql = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
$connection->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) UNIQUE NOT NULL,
    category_description TEXT NOT NULL
);";
$connection->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS articles (
    article_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(255), 
    category_id INT,
    author_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE
);";
$connection->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    user_id INT,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(article_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);";
$connection->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS article_likes (
    like_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    article_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (article_id) REFERENCES articles(article_id) ON DELETE CASCADE
);";
$connection->query($sql);
?>
