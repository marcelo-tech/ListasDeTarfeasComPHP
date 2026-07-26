<?php

declare(strict_types=1);

function createDatabase() {
    $sql = "CREATE DATABASE IF NOT EXISTS todolists";

    try {
        $pdo = new PDO(dsn:"mysql:host=0.0.0.0", username:"user", password: "password");
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }catch(PDOException $e) {
        print_r($e);
        exit(1);
    }
}


function createTableLists() {
    $sql = "CREATE TABLE IF NOT EXISTS lists(id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(150))";

    try {
        $pdo = new PDO(dsn: "mysql:dbname=todolists;host=0.0.0.0", username: "user", password:"password");
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }catch(PDOException $e) {
        print_r($e);
        exit(1);
    }
}

function createTableTasks() {
    $sql = "CREATE TABLE IF NOT EXISTS tasks(
            id INT AUTO_INCREMENT PRIMARY KEY, 
            name VARCHAR(255), list_id INT,
            FOREIGN KEY (list_id) REFERENCES lists(id) ON DELETE CASCADE
            )";

    try {
        $pdo = new PDO("mysql:dbname=todolists;host=0.0.0.0", "user", "password");
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }catch(PDOException $e) {
        print_r($e);
        exit(1);
    }
}

createDatabase();
createTableLists();
createTableTasks();