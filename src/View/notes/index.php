<?php

declare(strict_types=1);

namespace App\View\notes;

/** @var list<\App\Entity\NoteEntity> $notes */

?>
<h1>Notes</h1>
<p><a href="/notes/create">Add note</a></p>

<?php if (count($notes) === 0): ?>
    <article>
        <p>No notes yet. <a href="/notes/create">Create one</a>.</p>
    </article>
<?php else: ?>
    <p><?= count($notes); ?> note<?= count($notes) === 1 ? '' : 's'; ?> found.</p>
    <ul class="notes-list">
        <li class="notes-list-header">
            <span class="notes-id">ID</span>
            <span class="notes-text">Text</span>
        </li>
        <?php foreach ($notes as $note): ?>
            <li>
                <a href="/notes/get/<?= $note->id; ?>">
                    <span class="notes-id"><?= $note->id; ?></span>
                    <span class="notes-text"><?= htmlspecialchars($note->text, ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
