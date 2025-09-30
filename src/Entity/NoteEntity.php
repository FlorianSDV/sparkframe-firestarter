<?php

declare(strict_types=1);

namespace App\Entity;

class NoteEntity extends BaseEntity
{
    public const string ID = 'id';
    public const string TEXT = 'text';
    public int $id;
    public string $text;
    protected const array COLUMN_DESCRIPTIONS = [
        'id' => ['int', 'primary'],
        'text' => ['string']
    ];
}
