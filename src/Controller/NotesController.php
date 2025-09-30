<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\NoteEntity;
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
        //todo: misschien magic method die na __construct runt?
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/get-all', RequestMethod::GET)]
    #[Route('/notes', RequestMethod::GET)]
    public function getAllNotes(): string
    {
        return json_encode($this->notesModel->getAllNotes());
    }


    /**
     * @throws Exception
     */
    #[Route('/notes/get/' . INT_ROUTE_PROPERTY, RequestMethod::GET)]
    public function getNote(int $id): string
    {
        $note = $this->notesModel->getNote($id);
        return json_encode($note);
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/create', RequestMethod::POST)]
    public function createNote(): string
    {
        $request_body = json_decode($this->request->getRequestBody(), true);
        $note = $this->notesModel->createNote($request_body);
        return json_encode(["status" => 'Success!', "note" => $note]);
    }

    /**
     * @throws Exception
     */
    #[Route('/notes/update', RequestMethod::PATCH)]
    public function updateNote(): string
    {
        $request_body = json_decode($this->request->getRequestBody(), true);
        $note = $this->notesModel->getNote($request_body['id']);
        $note->text = $request_body['text'];
        $this->notesModel->updateNote($note);
        return json_encode(["status" => "Success!", "note" => $note]);
    }

    #[Route('/notes/delete/' . INT_ROUTE_PROPERTY, RequestMethod::DELETE)]
    public function deleteNote(int $id): string
    {
        $note = $this->notesModel->getNote($id);
        $this->notesModel->deleteNote($note);
        return json_encode(["status" => "success"]);
    }
}
