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
            "SqLite" => new DatabaseInfo(
                getenv("DB_URL_SQLITE"),
                "root",
                ""
            )
        ];
    }
}
