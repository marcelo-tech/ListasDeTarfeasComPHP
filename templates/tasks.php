<?php
$taskList = $taskList ?? [];
$listName = $listName ?? 'Unknown';

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php'; ?>

<body>
    <?php require_once 'header.php'; ?>
    <main class="container bg-light">
        <h2 class="text-center title"><?= $listName ?></h2>
        <hr class="mb-5"/>

        <form action="/?action=process-new-task&listName=<?= $listName ?>" method="post" id="newTaskForm">
            <div class="row align-items-center">
                <div class="col-3 fs-4 fw-bold d-flex justify-content-end">
                    <label id="taskNameLabel" class="form-label" for="taskName">Insira tarefa</label>
                </div>
                <div class="col-5">
                    <input name="taskName" id="taskName" class="form-control form-control-lg" required minlength="3" placeholder="Entre uma tarefa..." />
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-dark btn-lg" id="submitButton">Add</button>
                </div>
            </div>
        </form>

        <section id="taskListSection">
            <ul class="list-group text-secondary fw-bold fs-3" id="tasksList">
                <?php foreach ($taskList as $task): ?>
                    <li class="row align-items-center mb-1">
                        <div class="col-2 row justify-content-center">
                            <a href="/?action=remove-task&id=<?= $task['id'] ?>&listName=<?= $listName ?>" class="col-4 text-danger" title="Excluir tarefa">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg>
                            </a>
                            <a href="/?action=task-done&id=<?= $task['id'] ?>&listName=<?= $listName ?>" class="text-success col-4" title="Marcar tarefa como concluida">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                                </svg>
                            </a>
                        </div>
                        <p class="col-10 m-0 <?= $task['done'] == '1' ? 'task-done' : '' ?>">
                            <?= $task['name'] ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>

</html>