<?php
    session_start();
    require_once __DIR__ . '/../templates/helper_current_user.php';
    $page_title = $page_title ?? 'Gift Web Manager';
    $page_css = $page_css ?? null;
    $page_js=$page_js ?? null;
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= htmlspecialchars($page_title)?> </title>

    <link rel="stylesheet" href="/css/variables.css">
    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/components.css">
    <?php if($page_css): ?>
        <link rel="stylesheet" href="/css/pages/<?= htmlspecialchars($page_css) ?>.css">
    <?php endif; ?>

</head>
<body>
    <header class="site-header">
        <nav class="navbar" aria-label="Navigație Principală">
        <a href="/home.php" class="navbar__logo">Gift Manager</a>

         <button class="navbar__toggle" 
                    aria-expanded="false" 
                    aria-controls="primary-menu"
                    aria-label="Deschide meniu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <?php
            if($isLoggedIn){
                 ?>
                    <ul id="primary-menu" class="navbar__menu">
                        <?php 
                            if($isAdmin){
                                ?>
                                    <li><a href="/admin.php">Admin</a></li>
                                <?php
                            }
                        ?>
                        <li id="navbar1"><a href="/recomandare.php" id="navbara1">Search gift</a></li>
                        <li id="navbar2"><a href="/comenzileMele.php" id="navbara2">My orders</a></li>
                        <li id="navbar3"><a href="#" id="navbara3">Logout</a></li>
                    </ul>
                 <?php
            }
            else{
                  ?>
                    <ul id="primary-menu" class="navbar__menu">
                        <li id="navbar1"><a href="/recomandare.php" id="navbara1">Search gift</a></li>
                        <li id="navbar2"><a href="/login.php" id="navbara2">Login</a></li>
                        <li id="navbar3"><a href="/register.php" id="navbara3">Register</a></li>
                    </ul>
                 <?php
            }
           

            ?>
          </nav>
    </header>

    <main>