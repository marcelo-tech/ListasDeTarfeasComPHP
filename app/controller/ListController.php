<?php
//app/controller/ListController.php

declare(strict_types=1);

namespace App\controller;

use App\repository\ListRepository;

class ListController
{
    private string $templates = __DIR__ . "/../../templates";
    private ListRepository $listRepository;


    function __construct(ListRepository | null $listRepository = null)
    {
        if($listRepository !== null) {
            $this->listRepository = $listRepository;
            return;
        }
        
        $this->listRepository = new ListRepository();
    }

    function displayNewListPage(array $errors = [])
    {
        $newListLink = 'text-info';
        $template = 'list.php';
        $path = $this->templates . '/' . $template;
        require_once $path;
    }

    function processNewListData()
    {
        $listName = $_POST['listName'] ?? '';
        $errors = [];

        if (!empty($listName) && strlen($listName) > 3) {
            if (empty($this->listRepository->findListByName($listName))) {
                $this->listRepository->createList($listName);
                header("Location: /?action=todo&listName=$listName");
                return;
            }
            $errors['listName'] = "Uma lista com nome $listName já existe.";
        }

        $this->displayNewListPage($errors);

        return;
    }

    private function loadTasksPage(array $taskList, string $listName, array $errors = [])
    {
        $template = 'tasks.php';
        $path = $this->templates . '/' . $template;
        require_once $path;
    }

    function displayNewTasksPage()
    {
        $taskList = [];
        $listName = $_GET['listName'] ?? '';

        if (!empty($listName) && strlen($listName) > 3) {
            $listData = $this->listRepository->findListByName($listName);
            if (!empty($listData) && strlen($listName) > 2) {
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
        $errors = [];

        // lista deve existir
        if (empty($listName) || strlen($listName) < 3) {
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
            if (empty($this->listRepository->findTaskByName($taskName, $id))) {
                $this->listRepository->createTask($taskName, $id);
            } else {
                $errors['taskName'] = "Uma tarefa com esse nome já existe.";
            }
        }

        $taskList = $this->listRepository->getTasks($id);

        $this->loadTasksPage($taskList, $listName, $errors);
    }


    function processRemoveTask()
    {
        $taskList = [];
        $listName = $_GET['listName'] ?? '';
        $id = $_GET['id'];

        if (empty($listName) || empty($id) || strlen($listName) < 3) {
            header("Location: /?action=todo&listName=$listName&id=$id");
            return;
        }

        $listData = $this->listRepository->findListByName($listName);
        if (empty($listData)) {
            header("Location: /");
            return;
        }

        $list_id = (int)$listData['id'];
        $task_id = (int)$id;
        $this->listRepository->deleteTask($task_id, $list_id);

        $taskList = $this->listRepository->getTasks($list_id);

        $this->loadTasksPage($taskList, $listName);
    }

    function processRemoveList()
    {
        $listName = $_GET['listName'] ?? '';

        if (empty($listName)) {
            header("Location: /?action=lists");
            return;
        }

        $this->listRepository->deleteList($listName);

        header("Location: /?action=lists");
    }

    function processMarkTaskAsDone()
    {
        $taskList = [];
        $id = $_GET['id'] ?? '';
        $listName = $_GET['listName'] ?? '';

        if (empty($listName) || empty($id)) {
            header("Location: /?action=todo&listName=$listName&id=$id");
            return;
        }

        $listData = $this->listRepository->findListByName($listName);

        if (empty($listData)) {
            header('Location: /');
            return;
        }

        $list_id = (int)$listData['id'];
        $task_id = (int)$id;

        $taskData = $this->listRepository->findTaskById($task_id);

        if (empty($taskData) || $taskData['list_id'] !== $list_id) {
            header("Location: /?action=todo&listName=$listName&id=$id");
            return;
        }

        // Mark task as done.
        $taskData['done'] = 1;

        $this->listRepository->updateTask($taskData);

        $taskList = $this->listRepository->getTasks($list_id);

        $this->loadTasksPage($taskList, $listName);
    }

    function displayListsPage()
    {
        $listsLink = 'text-info';
        $lists = [];
        $template = "lists.php";
        $path = $this->templates . '/' . $template;

        $lists = $this->listRepository->getLists();

        foreach ($lists as $key => $list) {
            $numberOfTasks = $this->listRepository->findNumberOfTasksPerList((int)$list['id']);
            $lists[$key]['numberOfTasks'] = $numberOfTasks;
        }

        require_once $path;
    }
}
