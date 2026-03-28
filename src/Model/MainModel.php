<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\MainEntity;
use Sparkframe\Model\Model;

class MainModel extends Model
{
    public function __construct()
    {
        parent::__construct(MainEntity::class);
    }
}
