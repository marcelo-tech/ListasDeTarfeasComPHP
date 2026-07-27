<?php
//app/controller/ListController.php

declare(strict_types=1);

namespace App\controller;

use App\repository\ListRepository;

class ListController
{
    private string $templates = __DIR__ . "/../../templates";
    private ListRepository $listRepository;


    function __construct()
    {
        $this->listRepository = new ListRepository();
    }

    function displayNewListPage()
    {
        $template = 'list.php';
        $path = $this->templates . '/' . $template;
        require_once $path;
    }

    function processNewListData()
    {
        $listName = $_POST['listName'] ?? '';

        if (!empty($listName) && strlen($listName)) {
            $this->listRepository->createList($listName);
            header("Location: /?action=todo&listName=$listName");
            return;
        }

        // error
        header("Location: /");

        return;
    }

    private function loadTasksPage(array $taskList, string $listName) {
        $template = 'tasks.php';
        $path = $this->templates . '/' . $template;
        require_once $path; 
    }

    function displayNewTasksPage()
    {
        $taskList = [];
        $listName = $_GET['listName'] ?? '';

        if (!empty($listName)) {
            $listData = $this->listRepository->findListByName($listName);
            if (!empty($listData)) {
                $id = (int)$listData['id'];
                $taskList = $this->listRepository->getTasks($id);
            } else {
                // Create list first
                header("Location: /");
                return;
            }
        }

        $this->loadTasksPage($taskList, $listName);
    }

    function processNewTaskData()
    {
        $taskList = [];
        $taskName = $_POST['taskName'] ?? '';
        $listName = $_GET['listName'];

        // lista deve existir
        if (empty($listName)) {
            header("Location: /");
            return;
        }

        $listData = $this->listRepository->findListByName($listName);

        // lista deve existir no banco de dados.
        if (empty($listData)) {
            header("Location: /");
            return;
        }

        $id = (int)$listData['id'];

        if (!empty($taskName)) {
            $this->listRepository->createTask($taskName, $id);
        }

        $taskList = $this->listRepository->getTasks($id);

        $this->loadTasksPage($taskList, $listName);
    }


    function processRemoveTask() {
        $taskList = [];
        $listName = $_GET['listName'] ?? '';
        $id = $_GET['id'];

        if(gettype($listName) === 'array') {
            $listName = $listName[0];
        }
        if(gettype($id) === 'array') {
            $id = $id[0];
        }

        if(empty($listName) || empty($id)) {
            header("Location: /?action=todo&listName=$listName&id=$id");
            return;
        }

        $listData = $this->listRepository->findListByName($listName);
        if(empty($listData)) {
            header("Location: /");
            return;
        }

        $list_id = (int)$listData['id'];
        $task_id = (int)$id;
        $this->listRepository->deleteTask($task_id, $list_id);

        $taskList = $this->listRepository->getTasks($list_id);
        
        $this->loadTasksPage($taskList, $listName);
    }

    function processMarkTaskAsDone() {

    }
}
