<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\NotesModel;
use Exception;
use Sparkframe\Attributes\Route;
use Sparkframe\Tools\RequestMethod;

class NotesController extends BaseController
{
    private NotesModel $notesModel;

    public function __construct()
    {
        $this->notesModel = new NotesModel();
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/get-all', RequestMethod::GET)]
    #[Route('/notes', RequestMethod::GET)]
    public function getAllNotes(): void
    {
        $notes = $this->notesModel->getAllNotes();
        $this->renderPage('notes/index', ['notes' => $notes], 'Notes', 'notes');
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/get/' . INT_ROUTE_PROPERTY, RequestMethod::GET)]
    public function getNote(int $id): void
    {
        $note = $this->notesModel->getNote($id);
        $this->renderPage('notes/show', ['note' => $note], 'Note', 'notes');
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/create', RequestMethod::GET)]
    public function showCreateForm(): void
    {
        $this->renderPage('notes/create', [], 'New note', 'notes');
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/create', RequestMethod::POST)]
    public function createNote(): void
    {
        $post = $this->request->getRequestPost();
        $note = $this->notesModel->createNote($post);
        $this->redirect('/notes/get/' . $note->id);
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/update', RequestMethod::POST)]
    public function updateNote(): void
    {
        $post = $this->request->getRequestPost();
        $note = $this->notesModel->getNote((int) $post['id']);
        $note->text = $post['text'];
        $this->notesModel->updateNote($note);
        $this->redirect('/notes/get/' . $note->id);
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/delete/' . INT_ROUTE_PROPERTY, RequestMethod::POST)]
    public function deleteNote(int $id): void
    {
        $note = $this->notesModel->getNote($id);
        $this->notesModel->deleteNote($note);
        $this->redirect('/notes');
    }
}
