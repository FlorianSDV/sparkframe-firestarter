# Getting started
1. Create the .env file
```shell
cp .env.example .env
```

2. Add the path to your auth.json file on your host to the newly created .env

## When using a devcontainer
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
- Create and start the production stack
```shell
make create-stack
```

## Creating the development stack
- Create and start the development stack
```shell
make create-stack-dev
```