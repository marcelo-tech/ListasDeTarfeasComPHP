<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php' ?>
<body>
    <?php require_once 'header.php'; ?>
    <main class="container bg-light">
        <h1 class="fw-bold text-black">Listas de tarefas</h1>
        <hr class="mb-5" />
        <form action="/?action=process-new-list" id="newListForm" method="post">
            <div class="row align-items-center">
                <div class="col-3 d-flex justify-content-end">
                    <label id="listNameLabel" for="listName" class="form-label fw-bold">Nome da lista</label>
                </div>
                <div class="col-6">
                    <input name="listName" id="listName" class="form-control" required placeholder="Entre nome da lista..." />
                </div>
                <div class="col-2">
                    <button type="submit" id="submitButton" class="btn btn-dark col">Criar</button>
                </div>
            </div>
        </form>
    </main>
    <?php require_once 'footer.php'; ?>
</body>

</html>