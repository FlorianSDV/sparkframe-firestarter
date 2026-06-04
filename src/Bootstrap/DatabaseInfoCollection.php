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
                $_ENV["DB_URL_SQLITE"],
                "root",
                ""
            ),
            "MySQL" => new DatabaseInfo(
                $_ENV["DB_URL_MYSQL"],
                $_ENV["MYSQL_USER"],
                $_ENV["MYSQL_ROOT_PASSWORD"]
            )
        ];
    }
}
