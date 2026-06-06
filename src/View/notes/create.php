<?php

declare(strict_types=1);

namespace App\View\notes;

?>
<h1>New note</h1>
<p><a href="/notes">&larr; Back to notes</a></p>

<form method="post" action="/notes/create">
    <label for="text">Text</label>
    <textarea id="text" name="text" rows="4" required></textarea>
    <button type="submit">Create</button>
</form>
