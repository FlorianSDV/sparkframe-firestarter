<?php

declare(strict_types=1);

/** @var string $currentPage */

$navItems = [
    'overview' => 'Overview',
    'introduction' => 'Introduction',
    'features' => 'Features',
    'application-structure' => 'Application structure',
    'configuration' => 'Configuration',
    'routing' => 'Routing',
    'controllers' => 'Controllers',
    'entities' => 'Entities',
    'models-and-query-builder' => 'Models and query builder',
    'views' => 'Views',
    'requests-and-sessions' => 'Requests and sessions',
];

?>
<aside class="documentation-nav" aria-label="Documentation">
    <h2>Documentation</h2>
    <ul>
        <?php foreach ($navItems as $slug => $label): ?>
            <li>
                <a href="/documentation/<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>"<?= $currentPage === $slug ? ' aria-current="page"' : ''; ?>><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
<script type="module">
    import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.esm.min.mjs';

    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    mermaid.initialize({
        startOnLoad: true,
        theme: isDark ? 'dark' : 'neutral',
        themeVariables: isDark ? {
            background: 'transparent',
            primaryTextColor: '#e0e3e7',
            secondaryTextColor: '#c2c7d0',
            tertiaryTextColor: '#a4acba',
            lineColor: '#a4acba',
            textColor: '#e0e3e7',
            mainBkg: '#2a3140',
            actorBkg: '#2a3140',
            actorBorder: '#5d6b89',
            actorTextColor: '#e0e3e7',
            signalColor: '#c2c7d0',
            signalTextColor: '#e0e3e7',
            labelBoxBkgColor: '#333c4e',
            labelBoxBorderColor: '#5d6b89',
            labelTextColor: '#e0e3e7',
            noteBkgColor: '#333c4e',
            noteTextColor: '#e0e3e7',
            activationBkgColor: '#333c4e',
            activationBorderColor: '#a4acba',
        } : {},
    });
</script>
