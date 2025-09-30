<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\NoteEntity;
use Exception;

class NotesModel extends BaseModel
{
    protected const string TABLE_NAME = 'Notes';

    public function __construct()
    {
        // todo: je wil waarschijnlijk geen class instantie maar de class naam.
        parent::__construct(NoteEntity::class, 'MySQL');
        // parent::__construct(NoteEntity::class, 'Default');
    }


    /**
     * @throws Exception
     * @return array<NoteEntity>
     */
    public function getAllNotes(): array
    {
        $query = $this->selectQuery()
            ->select(NoteEntity::ID, NoteEntity::TEXT);
        //            ->limit(1);

        return $query->execute();
    }

    /**
     * @throws Exception
     */
    public function getNote(int $note_id): NoteEntity
    {
        $query = $this->selectQuery()
            ->where([NoteEntity::ID => $note_id]);

        return $query->execute()[0];
    }

    /**
     * @throws Exception
     */
    public function createNote(array $note_data): NoteEntity
    {
        // Note moet een is_new state hebben.
        $new_note = new NoteEntity();
        $new_note->text = $note_data['text'];

        // addEntity moet een enkele entity of een hele reeks entities accepteren of een array van entities.
        // Voor nu is het een enkele entity.
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
        $this->updateQuery()->addEntity($note)->execute();

        return $note;
    }

    public function deleteNote(NoteEntity $note): void
    {
        $delete_query = $this->deleteQuery();
        $delete_query->addEntity($note);

        $delete_query->execute();
    }
}