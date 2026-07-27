<?php
$lists = $lists ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php'; ?>

<body>
    <?php require_once 'header.php'; ?>
    <main class="container bg-light">
        <h2 class="title">Listas</h2>
        <hr class="mb-4" />

        <section>
            <ul id="lists" class="list-group mx-5">
                <?php foreach ($lists as $list): ?>
                    <li class="list-group-item text-secondary py-2">
                        <a href="/?action=todo&listName=<?= $list['name'] ?>" class="nav-link">
                            <h3 class="hover"><?= $list['name'] ?></h3>
                        </a>
                        <p class="fs-5"><b>Tarefas No: </b><?= $list['numberOfTasks'] ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
</body>

</html>