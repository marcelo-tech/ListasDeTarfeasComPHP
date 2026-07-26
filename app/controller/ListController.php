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

    function displayNewTasksPage()
    {
        $taskList = [];
        $listName = $_GET['listName'] ?? '';

        if (!empty($listName)) {
            $listData = $this->listRepository->findListByName($listName);
            if (!empty($listData)) {
                $id = (int)$listData['id'];
                $allTasksRecords = $this->listRepository->getTasks($id);
                foreach($allTasksRecords as $taskData) {
                    $taskList[] = $taskData;
                }
            } else {
                // Create list first
                header("Location: /");
                return;
            }
        }

        $template = 'tasks.php';
        $path = $this->templates . '/' . $template;

        require_once $path;
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

        $allTasksRecords = $this->listRepository->getTasks($id);
        foreach($allTasksRecords as $taskData) {
            $taskList[] = $taskData;
        }

        $template = 'tasks.php';
        $path = $this->templates . '/' . $template;
        require_once $path;
    }
}
