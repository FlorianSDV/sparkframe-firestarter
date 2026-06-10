COMPOSE_FILE=docker-compose.yml
COMPOSE_FILE_DEV=docker-compose-dev.yml
COMPOSE_FILE_MYSQL=docker-compose-mysql.yml

# General
stop-mysql-container:
	docker compose \
	-f $(COMPOSE_FILE_MYSQL) \
	down

stop-dev-container:
	docker compose \
	-f $(COMPOSE_FILE_DEV) \
	down

stop-production-container:
	docker compose \
	-f $(COMPOSE_FILE) \
	down

# production
create-stack:
	make compose-up \
		&& make create-sqlite-db \
		&& make create-mysql-db

compose-up:
	docker compose \
		-f $(COMPOSE_FILE) \
		-f $(COMPOSE_FILE_MYSQL) \
		up -d --wait

create-sqlite-db:
	docker compose \
		-f $(COMPOSE_FILE) \
		-f $(COMPOSE_FILE_MYSQL) \
		exec sparkframe-firestarter \
		composer create-sqlite-db

create-mysql-db:
	docker compose \
		-f $(COMPOSE_FILE) \
		-f $(COMPOSE_FILE_MYSQL) \
		exec sparkframe-firestarter \
		composer create-mysql-db

# dev
create-stack-dev:
	make compose-up-dev \
		&& make create-sqlite-db-dev \
		&& make create-mysql-db-dev

compose-up-dev:
	docker compose \
		-f $(COMPOSE_FILE_DEV) \
		-f $(COMPOSE_FILE_MYSQL) \
		up -d --wait

create-sqlite-db-dev:
	docker compose \
		-f $(COMPOSE_FILE_DEV) \
		-f $(COMPOSE_FILE_MYSQL) \
		exec sparkframe-firestarter-dev \
		composer create-sqlite-db

create-mysql-db-dev:
	docker compose \
		-f $(COMPOSE_FILE_DEV) \
		-f $(COMPOSE_FILE_MYSQL) \
		exec sparkframe-firestarter-dev \
		composer create-mysql-db

# local - hybrid
create-local-stack:
	composer install \
	&& make start-mysql-db-container \
	&& composer create-mysql-db \
	&& composer create-sqlite-db

start-mysql-db-container:
	docker compose \
	-f $(COMPOSE_FILE_MYSQL) \
	up -d
