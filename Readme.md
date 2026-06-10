# Getting started
Before you start you need to decide if you want to use Docker or not.

If you want to make use of xdebug and have all the correct tools pre-installed (git, xdebug) use a [devcontainer](#when-using-a-devcontainer).

If you just want to run the stack the simplest way is to create the [production stack](#creating-the-production-stack).

If you want to [run everything locally](#when-you-want-to-run-everything-locally) on your host, or [run only MySql in a container](#when-you-dont-want-to-use-docker-but-you-do-want-to-run-mysql-in-a-container) that is also possible.

# When you want to use Docker:
## When using a devcontainer
1. Create the `.env` file:
```shell
cp .env.example .env
```

2. In `.env`, set `COMPOSER_AUTH_PATH` to the absolute path of your `auth.json` on the host (required for `composer install` during the image build).

Make sure:
- That the `.env` file is created before creating the devcontainer
- That you have the correct extension installed for your IDE

3. Follow your IDE's instructions to create the devcontainer. In VS Code, use the "Dev Containers: Reopen in Container" command.

On first build, SQLite and MySQL databases are created and seeded automatically.

4. Open a browser and navigate to http://localhost:8000/

## Creating the production stack
The production stack runs the PHP application and a MySQL container in Docker. SQLite and MySQL databases are created and seeded automatically.

1. Create the `.env` file:
```shell
cp .env.example .env
```

2. In `.env`, set `COMPOSER_AUTH_PATH` to the absolute path of your `auth.json` on the host (required for `composer install` during the image build).

3. Create and start the production stack:
```shell
make create-stack
```

This command builds and starts the app and MySQL containers, then creates and seeds both the SQLite and MySQL databases.

4. Open a browser and navigate to http://localhost:8001/

If the stack already exists and you only need to start the containers again:
```shell
make compose-up
```

## Creating the development stack
The development stack runs the PHP application (with Xdebug) and a MySQL container in Docker. SQLite and MySQL databases are created and seeded automatically.

1. Create the `.env` file:
```shell
cp .env.example .env
```

2. In `.env`, set `COMPOSER_AUTH_PATH` to the absolute path of your `auth.json` on the host (required for `composer install` during the image build).

3. Create and start the development stack:
```shell
make create-stack-dev
```

This command builds and starts the app and MySQL containers, then creates and seeds both the SQLite and MySQL databases.

4. Open a browser and navigate to http://localhost:8000/

If the stack already exists and you only need to start the containers again:
```shell
make compose-up-dev
```

# When you don't want to use Docker, But you do want to run MySQL in a container
Ensure that you have the correct php extensions installed to be able to run mysql and sqlite.
- pdo_mysql
- pdo_sqlite
- sqlite3


1. Create the .env file. There is no need to change any of the values yet.
```shell
cp .env.local.example .env
```
2. Install the dependencies:
```shell
composer install
```
3. Run the make command that lets you spin up a containerized MySql database
```shell
make start-mysql-db-container
```
4. When the container is created, create the mysql database and seed the tables.
```shell
composer create-mysql-db
```
5. Create the sqlite database.
```shell
composer create-sqlite-db
```
6. In .env add the absolute path of notes-app.sqlite (located in the sqlite_db directory) to the DB_URL_SQLITE environment variable.
7. Finally, run the application using PHP's built in server.
```shell
php -S localhost:8000 -t public/
```
8. Open a browser and navigate to http://localhost:8000/

# When you want to run everything locally
Ensure that you have the correct php extensions installed to be able to run mysql and sqlite.
- pdo_mysql
- pdo_sqlite
- sqlite3

1. Because you are not using the provided mysql container you need to host MySql yourself. Do this first before continuing.
- There is no need to create the database, it will be created in a later step.

2. Create the .env file. Change the MySql variables if necessary.
```shell
cp .env.local.example .env
```
3. Install the dependencies:
```shell
composer install
```
4. Create the mysql database and seed the tables.
```shell
composer create-mysql-db
```
5. Create the sqlite database.
```shell
composer create-sqlite-db
```
6. In .env add the absolute path of notes-app.sqlite (located in the sqlite_db directory) to the DB_URL_SQLITE environment variable.
7. Finally, run the application using PHP's built in server.
```shell
php -S localhost:8000 -t public/
```
8. Open a browser and navigate to http://localhost:8000/
