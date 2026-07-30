<?php
//app/Application.php

declare(strict_types=1);

namespace App;

use App\controller\ListController;
use App\repository\ListRepository;

class Application
{
    function init()
    {
        $action = filter_input(INPUT_GET, 'action');
        $listController = new ListController();
        $listRepository = new ListRepository();

        switch ($action) {
            case 'lists':
                $listController->displayListsPage();
                break;

            case 'todo':
                $listController->displayNewTasksPage();
                break;

            case 'process-new-list':
                $listController->processNewListData();
                break;

            case 'process-new-task':
                $listController->processNewTaskData();
                break;

            case 'remove-task':
                $listController->processRemoveTask();
                break;

            case 'remove-list':
                $listController->processRemoveList();
                break;

            case 'task-done':
                $listController->processMarkTaskAsDone();
                break;

            case 'test-cleanup-tables':
                $listRepository->cleanUpTables();
                break;

            default:
                $listController->displayNewListPage();
                break;
        }
    }
}
