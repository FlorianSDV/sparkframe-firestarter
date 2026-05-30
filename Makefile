COMPOSE_FILE=docker-compose.yml
COMPOSE_FILE_DEV=docker-compose-dev.yml

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

create-mysql-db:
	docker exec \
	sparkframe-firestarter-app-production \
	composer create-mysql-db

create-stack:
	make compose-up \
		&& make create-sqlite-db

create-stack-dev:
	make compose-up-dev \
		&& make create-sqlite-db