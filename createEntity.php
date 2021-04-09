<?php
use Models\Page;

require_once "./bootstrap.php";

$newPageName = $argv[1];
$newPageContent = "<h1>Welcome to the CMS!</h1>";

$page = new Page();
$page->setName($newPageName);
$page->setContent($newPageContent);

$entityManager->persist($page);
$entityManager->flush();

echo "Created Page with ID " . $page->getId() . "\n";