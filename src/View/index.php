<?php

declare(strict_types=1);

namespace App\View;

use Sparkframe\Tools\MethodRoute;

/** @var array $sorted_routes */
?>
<h1>Sparkframe Firestarter</h1>
<p>
    A simple demo application built with the Sparkframe PHP framework.
    It demonstrates CRUD operations on notes using SQLite or MySQL.
</p>

<section>
    <h2>Pages</h2>
    <ul>
        <li><a href="/">Home</a> — this page</li>
        <li><a href="/notes">Notes</a> — list all notes</li>
        <li><a href="/documentation">Documentation</a> — framework usage guides</li>
    </ul>
</section>

<section>
    <h2>Endpoints</h2>

    <ul>
        <?php
        foreach ($sorted_routes as $method_route_array) {
            /** 
             * @var MethodRoute $method_route 
             */
            $method_route = $method_route_array['method_route'];
            $uri = $method_route->getUriString();
            $controller = $method_route->getController();
            $method = $method_route->getMethodName();
            $request_method = $method_route_array['request_method'];
            $methodClass = strtolower((string) $request_method);
            echo '<li><code><span class="http-method http-method--' . $methodClass . '">' . $request_method . '</span> ' . $uri . '</code> — ' . $controller . '::' . $method . '()</li>';
        }
        ?>
    </ul>
</section>

<p>
    <a role="button" href="/notes">View notes</a>
</p>