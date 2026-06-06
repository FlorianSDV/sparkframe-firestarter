<?php

declare(strict_types=1);

namespace App\View;

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
    </ul>
</section>

<section>
    <h2>API endpoints</h2>
    <ul>
        <li><code>GET /notes</code> — list notes (HTML)</li>
        <li><code>GET /notes/get/{id}</code> — view a single note</li>
        <li><code>POST /notes/create</code> — create a note</li>
        <li><code>POST /notes/update</code> — update a note</li>
        <li><code>POST /notes/delete/{id}</code> — delete a note</li>
    </ul>
</section>

<p>
    <a role="button" href="/notes">View notes</a>
</p>
