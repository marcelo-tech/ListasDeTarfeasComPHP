<?php
//app/Application.php

declare(strict_types=1);

namespace App;

use App\controller\ListController;
use App\controller\UserController;
use App\repository\ListRepository;

class Application
{
    function init()
    {
        $action = filter_input(INPUT_GET, 'action');
        $listController = new ListController();
        $userController = new UserController();
        $listRepository = new ListRepository();

        switch ($action) {
            case 'all-lists':
                $listController->displayAllListPage();
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

            case 'login':
                $userController->displayLoginPage();
                break;

            case 'process-login':
                $userController->processNewLoginData();
                break;

            case 'account':
                $userController->displayNewAccountPage();
                break;

            case 'process-account':
                $userController->processNewAccountData();
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
