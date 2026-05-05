<?php
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
            
            <ul id="primary-menu" class="navbar__menu">
                <li><a href="/recomandare.php">Caută cadou</a></li>
                <li><a href="/">Comenzile mele</a></li>
                <li><a href="/login.php">Logare</a></li>
                <li><a href="/register.php">Înregistrare</a></li>
            </ul>
    </nav>
    </header>

    <main>