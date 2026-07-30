<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php' ?>

<body>
    <?php require_once 'header.php'; ?>
    <main class="container bg-light">
        <h2 class="title">Listas de tarefas</h2>
        <hr class="mb-5" />
        <p class="fs-4 text-secondary">
            <i>
                &OpenCurlyQuote;
                Crie listas com nome significativos para ajudar a lembrar seu propósito.
                &OpenCurlyQuote;
            </i>
        </p>
        <form action="/?action=process-new-list" id="newListForm" method="post">
            <div class="row align-items-center fs-4">
                <div class="col-3 d-flex justify-content-end">
                    <label id="listNameLabel" for="listName" class="form-label fw-bold text-secondary">Nome da lista</label>
                </div>
                <div class="col-6">
                    <input name="listName" id="listName" class="form-control form-control-lg" required placeholder="Entre nome da lista..."  minlength="2"/>

                </div>

                <div class="col-2">
                    <button type="submit" id="submitButton" class="btn btn-dark btn-lg col">Criar</button>
                </div>
            </div>

            <?php if (isset($errors['listName'])): ?>
                <div class="row align-items-center">
                    <div class="col-3"></div>
                    <small class="col text-danger"><?= $errors['listName'] ?></small>
                </div>
            <?php endif; ?>
        </form>
    </main>
    <?php require_once 'footer.php'; ?>
</body>

</html>