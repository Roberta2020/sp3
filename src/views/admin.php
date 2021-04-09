<?php
    require_once "../sp3/bootstrap.php";
    use Models\Page;
?>

<?php
// Helper functions
function redirect_to_root(){
    header("Location: " . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}

session_start();
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
        redirect_to_root();
    }

if (isset($_POST['login']) 
    && !empty($_POST['username']) 
    && !empty($_POST['password'])) 
{	
    if ($_POST['username'] == 'Admin' 
        && $_POST['password'] == '1234')
    {
        $_SESSION['logged_in'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = 'Admin';
        redirect_to_root();
    } else {
                $msg = 'Wrong username or password';
            }
}

if ($_SESSION['logged_in'] == true) {

// Delete page
if(isset($_GET['delete'])){
    $page = $entityManager->find('Models\Page', $_GET['delete']);
    $entityManager->remove($page);
    $entityManager->flush();
    redirect_to_root();
}

// Cancel add page
if (isset($_POST['cancel'])) {
    unset($_GET['add_page']);
    redirect_to_root();
  }
  
  // Add page
  if (isset($_POST['add_page'])
        &&!empty($_POST['page_name'])
        &&!empty($_POST['page_content'])) {
      $page = new Page();
      $page->setName($_POST['page_name']);
      $page->setContent($_POST['page_content']);
      $entityManager->persist($page);
      $entityManager->flush();
      redirect_to_root();
    }
// Update page
if (isset($_POST['update_page'])) {
    if (empty($_POST['update_name'])) {
      $errorMsg = '<div style="color: red; margin-top: 20px;">Page name can not be empty!</div>';
    } else {
      $page = $entityManager->find('Models\Page', $_POST['update_page']);
      $page->setName($_POST['update_name']);
      $page->setContent($_POST['update_content']);
      $entityManager->flush();
      redirect_to_root();
    }
}
  
// Cancel update page
if (isset($_POST['cancel'])) {
    unset($_GET['update_page']);
    redirect_to_root();
}
  
$pages = $entityManager->getRepository('Models\Page')->findAll();
print("<div class=\"container\" style=\"padding: 30px\">
        <div class=\"row justify-content-center\">
            <table class=\"col-md-6 table\">
            <thead>
            <tr class=\"table-primary\">
            <th scope=\"col\">Title</th>
            <th scope=\"col\">Actions</th>
            </tr>
            </thead>");
foreach($pages as $p) 
        print("<tbody>
                <tr>" 
                . "<td>" . $p->getName() . "</td>" 
                . "<td><a href=\"?delete={$p->getId()}\">DELETE</a>
                        <a href=\"?updatable={$p->getId()}\">UPDATE</a>
                    </td>" 
            . "</tr>");
    print("</tbody>
            </table>
        </div>
        </div>"); 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <title>Admin page</title>
</head>
<body>
<?php
if (!$_SESSION['logged_in']) {
    print ('<div class="container" style="padding: 30px">
            <div class="row justify-content-center">
            <div class="card" style="width: 20rem; height: 20rem; border-color: #b8daff; border-width: 15px">
        <form class = "card-body" action="" method="post">
            <h3 style="text-align: center; padding: 10px" >Log in</h3>
             <h4><?php echo $msg; ?></h4>
             <div class="row d-flex justify-content-center">
            <input class = "username" type="text" style="margin:20px 0" name="username" placeholder="username = Admin" required autofocus></br>
            <input class = "password" type="password" style="margin:20px 0" name="password" placeholder="password = 1234" required>
            </div>
            <div class="row d-flex justify-content-center">
            <button class = "btn btn-primary" style="margin:20px 0" type="submit" name="login">Login</button>
            </div>
            </form>
        </div>
        </div>
    </div>');
}
?>
<?php
if ($_SESSION['logged_in'] == true) {
    print ('<form class="row justify-content-center" action="" method="POST">
        <button class="btn btn-outline-primary" type="submit" name="preaddpage">Add page</button>
    </form>');


    if (isset($_POST['preaddpage'])) {
print ('
            <div class="container" style="padding: 30px">
                <div class="row justify-content-center">
        <form class="col-md-6" action="" method="POST">
        <h3>Add new page</h3>
        <label for="add-name">Page name:</label><br>
        <input type="text" id="add-name" name="page_name" placeholder="page name"><br>
        <label for="add-content">Page content:</label><br>
        <textarea cols="80" rows="15" id="add-content" name="page_content" placeholder="page content"></textarea><br>
        <button type="submit" class="btn btn-primary" name="add_page">Add page</button>
        <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
        </form>
            </div>
        </div>
        </div>');
    }

    if(isset($_GET['updatable'])){
        $page = $entityManager->find('Models\page', $_GET['updatable']);
        print('<div class="container" style="padding: 30px">
                <div class="row justify-content-center">
                <form class="col-md-6" action="" method="POST">
                    <h3>Update page: </h3>
                    <label for="update_name">Page name:</label><br>
                    <input type="text" id="update_name" name="update_name" value="' . $page->getName() . '"><br>
                    <label for="update_content">Page content:</label><br>
                    <textarea cols="80" rows="15" id="update_content" name="update_content" value="' . $page->getContent() . '" placeholder="Edit page content">' . $page->getContent() . '></textarea><br>
                    <button type="submit" class="btn btn-primary" name="update_page" value="' . $page->getId() . '">Update</button>
                    <button type="submit" class="btn btn-primary" name="cancel">Cancel</button>
                </form>
            </div>
            </div>
            </div>');
    }
print('<div class="row justify-content-center">Click here to <a href = "admin.php?action=logout">&nbsp logout.</div>');
}
?>
</body>
</html>