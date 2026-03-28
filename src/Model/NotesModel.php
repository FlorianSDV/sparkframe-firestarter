<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\NoteEntity;
use Exception;
use Sparkframe\Model\Model;

class NotesModel extends Model
{
    protected const string TABLE_NAME = 'Notes';

    public function __construct()
    {
        parent::__construct(NoteEntity::class, 'SqLite');
    }

    /**
     * @throws Exception
     * @return array<NoteEntity>
     */
    public function getAllNotes(): array
    {
        $query = $this->selectQuery()
            ->select(NoteEntity::ID, NoteEntity::TEXT);

        return $query->execute();
    }

    /**
     * @throws Exception
     */
    public function getNote(int $note_id): NoteEntity
    {
        $query = $this->selectQuery()
            ->where([NoteEntity::ID . ' = ' => $note_id]);

        return $query->execute()[0];
    }

    /**
     * @throws Exception
     */
    public function createNote(array $note_data): NoteEntity
    {
        $new_note = new NoteEntity();
        $new_note->text = $note_data['text'];
        $this->insertQuery()
            ->addEntity($new_note)
            ->execute();

        return $new_note;
    }

    /**
     * @throws Exception
     */
    public function updateNote(NoteEntity $note): NoteEntity
    {
        $this->updateQuery()
            ->addEntity($note)
            ->execute();

        return $note;
    }

    public function deleteNote(NoteEntity $note): void
    {
        $this->deleteQuery()
            ->addEntity($note)
            ->execute();
    }
}
