CREATE TABLE IF NOT EXISTS Notes
(
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    text TEXT
);

INSERT INTO Notes (text)
SELECT *
FROM (VALUES ('First note'), ('Second note'))
WHERE (SELECT COUNT(*) FROM "Notes") = 0;