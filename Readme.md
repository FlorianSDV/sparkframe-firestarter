# Getting started
Before you start you need to decide if you want to use Docker or not.

If you just want to run the stack the simplest way is to create the production stack.

If you want to make use of xdebug and have all the correct tools pre-installed (git, xdebug) use a devcontainer.

If you want to run everything locally on your host, or run only MySql in a container that is also possible.

# When you want to use Docker:
## When using a devcontainer
1. Create the .env file
```shell
cp .env.example .env
```

2. Add the path to your auth.json file on your host to the newly created .env

Make sure:
- That the .env file is created before creating the devcontainer
- That you have the correct extension installed for your IDE

1. Simply follow your IDE's instructions to create the devcontainer
In vscode, you can use the "Dev Containers: Reopen in Container" command to create the devcontainer.
2. After creating the devcontainer, create the database by running:
```shell
composer create-sqlite-db
```

## Creating the production stack
1. Create the .env file
```shell
cp .env.example .env
```

2. Add the path to your auth.json file on your host to the newly created .env

- Create and start the production stack
```shell
make create-stack
```

## Creating the development stack
1. Create the .env file
```shell
cp .env.example .env
```

2. Add the path to your auth.json file on your host to the newly created .env

- Create and start the development stack
```shell
make create-stack-dev
```
# When you don't want to use Docker, But you do want to run MySQL in a container
Ensure that you have the correct php extensions installed to be able to run mysql and sqlite.
- pdo_mysql
- pdo_sqlite
- sqlite3


1. Create the .env file. There is no need to change any of the values
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
6. Finally, run the application using PHP's built in server.
```shell
php -S localhost:8000 -t public/
```
7. Open a browser and navigate to http://localhost:8000/

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
6. Finally, run the application using PHP's built in server.
```shell
php -S localhost:8000 -t public/
```
7. Open a browser and navigate to http://localhost:8000/
