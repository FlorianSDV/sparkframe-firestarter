<?php

declare(strict_types=1);

namespace App\Bootstrap;

use Sparkframe\Database\BaseDatabaseInfoCollection;
use Sparkframe\Database\DatabaseInfo;

class DatabaseInfoCollection extends BaseDatabaseInfoCollection
{
    public function __construct()
    {
        $this->database_info_collection = [
            'Default' => new DatabaseInfo(getenv('DB_URL'), '', ''),
            'MySQL' => new DatabaseInfo(getenv('DB_URL_MYSQL'), 'root', '')
        ];
    }
}