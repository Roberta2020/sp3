<?php
    require_once "../sp3/bootstrap.php";
    use Models\Page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>CMS</title>
</head>

<body>
    <div class="container" style="padding:30px">
        <h1 style="text-align: center;">Content Management System</h1>
        <header>
            <nav class="navbar table-primary">
                    <?php
                    $pages = $entityManager->getRepository("Models\Page")->findAll();
                    foreach ($pages as $page) {
                        print('<a href="?id=' . $page->getId() . '" style="color:black; font-size: 20px;">' . $page->getName() . '</a>');
                    }
                    ?>
            </nav>
        </header>
<main>
<?php
    if (!($_GET['id'])) {
        $page = $entityManager->find('Models\Page', 1);
        print('<div>' . $page->getName() . '</div>
               <div>' . $page->getContent() . '</div>');
    } else {
        $page = $entityManager->find('Models\Page', $_GET['id']);
        print('<div>' . $page->getName() . '</div>
               <div>' . $page->getContent() . '</div>');
    }
?>
</main>
</div>
<footer class="table-primary" style="text-align:center">
    <div>Content Management System 2021 </div>
</footer>
</body>

</html>