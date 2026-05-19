<?php

$db_directory = 'sqlite_db';
$db_path = $db_directory . '/notes-app.sqlite';

if (file_exists($db_path)) {
    print('Sqlite database already exists. Terminating now...' . PHP_EOL);
    return;
}

$db = new SQLite3($db_path, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

// Create a table
$db->query(
'CREATE TABLE IF NOT EXISTS "Notes" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "text" TEXT
  )'
);

// Insert some sample data.
$db->query('INSERT INTO "Notes" ("text") VALUES ("First note")');
$db->query('INSERT INTO "Notes" ("text") VALUES ("Second note")');

// Get a count of the number of notes
$notes_count = $db->querySingle('SELECT COUNT(DISTINCT "id") FROM "Notes"');
echo("Notes count: $notes_count\n");

// Close the connection
$db->close();

chown($db_directory, 'www-data');

chgrp($db_directory, 'www-data');

chmod($db_path, 0600);
