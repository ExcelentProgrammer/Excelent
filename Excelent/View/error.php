<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xato yuz berdi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <pre>
</pre>
    <div class="container-xl h-auto">
        <pre>
        <div class="container bg-warning mb-3 pb-5 pt-5"><?= $Error->message ?></div><div class="contatine"><? $i = 1;
                                                                                                            foreach ($Error->trace as $error) { ?>
                <div class="d-flex justify-content-center bg-danger">
                <h2 class=""><?= $i ?></h2></div><div class="bg-info"><h6>File: <?= $error['file'] ?></h6><h6>Class: <?= $error['class'] ?></h6><h6>function: <?= $error['function'] ?></h6></div><? $i++;
                                                                                                                                                                                                } ?></div>
            </pre>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>