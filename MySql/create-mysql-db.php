<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PDOException;
use RuntimeException;
use App\Bootstrap\DatabaseInfoCollection;
use App\Entity\NoteEntity;
use Sparkframe\Bootstrap\Globals;
use Sparkframe\Database\DatabaseInfo;
use Sparkframe\Database\DatabaseWrapperFactory;
use Sparkframe\Database\DatabaseWrapperInterface;
use Sparkframe\Database\MySQLDatabaseWrapper;

function createDatabaseWrapperWithRetry(DatabaseInfo $databaseInfo): DatabaseWrapperInterface
{
    $maxAttempts = 30;
    $sleepSeconds = 2;

    for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
        try {
            return DatabaseWrapperFactory::createDatabaseWrapper($databaseInfo);
        } catch (PDOException $e) {
            $isLastAttempt = $attempt === $maxAttempts;
            $isConnectionError = str_contains($e->getMessage(), 'Connection refused')
                || str_contains($e->getMessage(), 'Connection timed out')
                || str_contains($e->getMessage(), 'getaddrinfo');

            if ($isLastAttempt || !$isConnectionError) {
                throw $e;
            }

            sleep($sleepSeconds);
        }
    }

    throw new RuntimeException('Failed to connect to MySQL.');
}

// Globals are needed to make use of environment variables
$globals = Globals::getInstance();
$globals->initialize(__DIR__ . '/../');


/** @var DatabaseInfo $mysql_database_info */
$mysql_database_info = new DatabaseInfoCollection()->getDatabaseInfoCollection()['MySQL'];

[$server_url, $db_name] = explode('dbname=', $mysql_database_info->getDatabaseUrl());

// Make only a connection to the server because the database does not yet exist
$new_connection = new DatabaseInfo(
    $server_url,
    $mysql_database_info->getUser(),
    $mysql_database_info->getPassword()
);
createDatabaseWrapperWithRetry($new_connection)
    ->getPDO()
    ->exec("CREATE DATABASE IF NOT EXISTS $db_name");

print("MySQL database created successfully" . PHP_EOL);

/** @var MySQLDatabaseWrapper $database_connection */
$database_connection = createDatabaseWrapperWithRetry($mysql_database_info);
$pdo = $database_connection->getPDO();

$table_name = 'Notes';
try {
    $stmt = "create table $table_name (id int auto_increment primary key, text text null);";
    $pdo->exec($stmt);
} catch (Exception $e) {
    if ($e->getCode() == "42S01") {
        print("Table $table_name already exists. Terminating now" . PHP_EOL);
        exit(0);
    }
    print($e);
    exit(1);
}

print("Table notes created successfully" . PHP_EOL);

$note_1 = new NoteEntity();
$note_1->text = 'First note';

$note_2 = new NoteEntity();
$note_2->text = 'Second note';

$insert_query = $database_connection->insertQuery($table_name, NoteEntity::class);
$insert_query->addEntity($note_1)
    ->addEntity($note_2);
$insert_query->execute();
