<?php
// app/repository/ListRepository.php
declare(strict_types=1);

namespace App\repository;

use PDO;
use PDOException;

class ListRepository {
    private const MYSQL_DATABASE = 'todolists';
    private const MYSQL_USER = 'user';
    private const MYSQL_PASSWORD='password';
    private const MYSQL_PORT=3306;
    private const MYSQL_HOST='0.0.0.0';
    private const LISTS_TABLE = 'lists';
    private const TASKS_TABLE = 'tasks';
    private const LISTS_FIELDS = ['id', 'name'];
    private const TASKS_FIELDS = ['id', 'name', 'list_id'] ;
    private PDO $pdo;

    function __construct()
    {
        $dsn = "mysql:dbname=" . $this::MYSQL_DATABASE . ";host=" . $this::MYSQL_HOST;
        $user = "user";
        $pass = "password";

        try {
            $this->pdo = new PDO(dsn: $dsn,username:$user, password:$pass );
        }catch(PDOException $e) {
            print "Error: " . htmlspecialchars($e->getMessage());
            die;
        }
    }

    private function printErrorMessage(string $message) {
        print "Error: " . htmlspecialchars($message);
    }

    function createList(string $name) {
        $sql = "INSERT INTO " . ListRepository::LISTS_TABLE . "(name) VALUES(:name)";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
        }catch(PDOException $e) {
            $this->printErrorMessage($e->getMessage());
            die;
        }
    }

    function createTask(string $name, int $list_id) {
        $sql = "INSERT INTO " . $this::TASKS_TABLE . "(name, list_id) VALUES(:name, :list_id)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":list_id", $list_id);
            $stmt->execute();
        }catch(PDOException $e) {
            $this->printErrorMessage($e->getMessage());
            die;
        }
    }

    function findListByName(string $name) {
        $sql = "SELECT * FROM " . $this::LISTS_TABLE . " WHERE name = :name";
        $list = null;

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
            $list = $stmt->fetch(pdo::FETCH_ASSOC);
        }catch(PDOException $e) {
            $this->printErrorMessage($e->getMessage());
            die;
        }

        return $list;
    }

    function getTasks(int $list_id) {
        $sql = "SELECT * FROM " . $this::TASKS_TABLE . " WHERE list_id = :list_id";
        $tasks = [];

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":list_id", $list_id);
            $stmt->execute();
            while($task = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tasks[] = $task;
            }
        }catch(PDOException $e){
            $this->printErrorMessage($e->getMessage());
            die;
        }

        return $tasks;
    }

    function cleanUpTables() {
        $sqlDeleteLists = "DELETE FROM " . $this::LISTS_TABLE;
        $rebootTasksIdCounter = "ALTER TABLE " . $this::TASKS_TABLE . " AUTO_INCREMENT=0";
        // CASCADE => $sqlDeleteTasks = "DELETE FROM " . $this::TASKS_TABLE;

        try {
            $stmt = $this->pdo->prepare($sqlDeleteLists);
            $stmt->execute();
            $stmt = $this->pdo->prepare($rebootTasksIdCounter);
            $stmt->execute();
        }catch(PDOException $e) {
            $this->printErrorMessage($e->getMessage());
            die;
        }
    }
}