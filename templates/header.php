<header class="container-fluid bg-dark text-white-50">
    <div class="row p-1">
        <div id="logo" class="col-2 p-0 m-0 ms-4 text-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-list-check" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0m0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
            </svg>  
        </div>
        <div class="d-flex justify-content-end fw-bold col-4 ">
            <h1 class="fw-bold title mb-0">Todo</h1>
        </div>
    </div>
    <nav class="navbar navbar-expand-sm m-0 p-0 fw-bold">
        <ul class="nav">
            <li class="nav-item">
                <a href="/" class="nav-link <?= $newListLink ?? '' ?>">
                    Nova Lista
                </a>
            </li>
            <?php if (!empty($listName)): ?>
                <li class="nav-item">
                    <a href="/?action=todo" class="nav-link text-info">
                        Tarefas
                    </a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="/?action=lists" class="nav-link <?= $listsLink ?? '' ?>">
                    Listas
                </a>
            </li>
        </ul>
    </nav>
</header>