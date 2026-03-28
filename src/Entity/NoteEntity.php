<?php

declare(strict_types=1);

namespace App\Entity;

use Sparkframe\Attributes\Column;
use Sparkframe\Attributes\Primary;
use Sparkframe\Entity\Entity;

class NoteEntity extends Entity
{
    public const string ID = 'id';
    public const string TEXT = 'text';

    #[Primary]
    public int $id;
    
    #[Column]
    public string $text;
}
