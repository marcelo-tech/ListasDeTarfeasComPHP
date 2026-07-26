<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\repository\ListRepository;

class ListRepositoryTest extends TestCase
{
    #[Test]
    function shouldReturnPageWithNewTaskWhenSubmitted(): void
    {
        $listRepository = new ListRepository();
        $listRepository->cleanUpTables();

        $listName = "Lista de compras";
        $taskNames = ['comprar leite', 'comprar ovos', 'comprar açucar'];
        $listRepository->createList($listName);
        $list_id = (int)$listRepository->findListByName($listName)['id'];

        foreach ($taskNames as $taskName) {
            $listRepository->createTask($taskName, $list_id);
        }

        $tasks = $listRepository->getTasks($list_id);
        $this->assertEquals(3, count($tasks));
        $this->assertEquals('1', $tasks[0]['id']);
        $this->assertEquals('2', $tasks[1]['id']);
        $this->assertEquals('3', $tasks[2]['id']);
        $this->assertEquals('comprar leite', $tasks[0]['name']);
    }
}
