<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body > main:first-of-type {
            min-height: 95vh;
            padding-bottom: 2rem;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }

        .task-done {
            text-decoration: line-through;
            color: green;
        }

        .title {
            text-transform: capitalize;
            color: darkorchid; 
            padding-block: 1rem;
        }

        .hover:hover {
            opacity: 0.7;
        }

        #newTaskForm {
            padding-block: 1.5rem;
            margin-bottom: 1.2rem;
        }
    </style>
</head>