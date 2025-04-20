<?php

namespace App\Model;

use App\Entity\MainEntity;

class MainModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct(new MainEntity());
    }
}
