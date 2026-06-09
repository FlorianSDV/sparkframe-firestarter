COMPOSE_FILE=docker-compose.yml
COMPOSE_FILE_DEV=docker-compose-dev.yml
COMPOSE_FILE_MYSQL=docker-compose-mysql.yml

compose-up:
	docker compose \
		-f $(COMPOSE_FILE) \
		up -d

compose-up-dev:
	docker compose \
		-f $(COMPOSE_FILE_DEV) \
		up -d

create-sqlite-db:
	docker exec \
	sparkframe-firestarter-app-production \
	composer create-sqlite-db


create-sqlite-db-dev:
	docker exec \
	sparkframe-firestarter-app-dev \
	composer create-sqlite-db

create-mysql-db:
	docker exec \
	sparkframe-firestarter-app-production \
	composer create-mysql-db

start-mysql-db-container:
	docker compose \
	-f $(COMPOSE_FILE_MYSQL) \
	up -d

create-stack:
	make compose-up \
		&& make create-sqlite-db-dev

create-stack-dev:
	make compose-up-dev \
		&& make create-sqlite-db-dev