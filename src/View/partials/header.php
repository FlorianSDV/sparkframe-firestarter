<?php

declare(strict_types=1);

namespace App\View\partials;

/** @var string $title */
/** @var string $activeNav */
/** @var array<string> $headImports */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <?php $headImports = $headImports ?? []; ?>
    <?php foreach ($headImports as $headImport): ?>
        <?= $headImport; ?>
    <?php endforeach; ?>
</head>
<body>
<header class="container">
    <nav>
        <ul>
            <li><strong>Sparkframe Firestarter</strong></li>
        </ul>
        <ul>
            <li>
                <a href="/"<?= $activeNav === 'home' ? ' aria-current="page"' : ''; ?>>Home</a>
            </li>
            <li>
                <a href="/notes"<?= $activeNav === 'notes' ? ' aria-current="page"' : ''; ?>>Notes</a>
            </li>
            <li>
                <a href="/documentation"<?= $activeNav === 'documentation' ? ' aria-current="page"' : ''; ?>>Documentation</a>
            </li>
        </ul>
    </nav>
</header>
<main class="container">
