<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\NotesModel;
use Exception;
use Sparkframe\Attributes\Route;
use Sparkframe\Controller\Controller;
use Sparkframe\Tools\RequestMethod;

class NotesApiController extends Controller
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
    #[Route('/api/notes/get-all', RequestMethod::GET)]
    #[Route('/api/notes', RequestMethod::GET)]
    public function getAllNotes(): void
    {
        $notes = $this->notesModel->getAllNotes();
        echo json_encode($notes);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/notes/get/' . INT_ROUTE_PROPERTY, RequestMethod::GET)]
    public function getNote(int $id): void
    {
        $note = $this->notesModel->getNote($id);
        echo json_encode($note);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/notes/create', RequestMethod::POST)]
    public function createNote(): void
    {
        $request_body = json_decode($this->request->getRequestBody(), true);
        $note = $this->notesModel->createNote($request_body);
        echo json_encode(["status" => 'Success!', "note" => $note]);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/notes/update', RequestMethod::PATCH)]
    public function updateNote(): void
    {
        $request_body = json_decode($this->request->getRequestBody(), true);
        $note = $this->notesModel->getNote($request_body['id']);
        $note->text = $request_body['text'];
        $this->notesModel->updateNote($note);
        echo json_encode(["status" => "Success!", "note" => $note]);
    }

    #[Route('/api/notes/delete/' . INT_ROUTE_PROPERTY, RequestMethod::DELETE)]
    public function deleteNote(int $id): void
    {
        $note = $this->notesModel->getNote($id);
        $this->notesModel->deleteNote($note);
        echo json_encode(["status" => "success"]);
    }
}
