<?php

declare(strict_types=1);

namespace App\View\notes;

/** @var \App\Entity\NoteEntity $note */

?>
<h1>Note #<?= $note->id; ?></h1>
<p><a href="/notes">&larr; Back to notes</a></p>

<form method="post" action="/notes/update">
    <input type="hidden" name="id" value="<?= $note->id; ?>">
    <label for="text">Text</label>
    <textarea id="text" name="text" rows="4"><?= htmlspecialchars($note->text, ENT_QUOTES, 'UTF-8'); ?></textarea>
    <button type="submit">Save</button>
</form>

<form method="post" action="/notes/delete/<?= $note->id; ?>" onsubmit="return confirm('Are you sure you want to delete this note?');">
    <button type="submit" class="secondary">Delete</button>
</form>
