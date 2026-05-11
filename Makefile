COMPOSE_FILE=docker-compose.yml
COMPOSE_FILE_DEV=docker-compose-dev.yml

compose-up:
	docker compose \
		-f $(COMPOSE_FILE) \
		up -d

compose-up-dev:
	docker compose \
		-f $(COMPOSE_FILE) \
		-f $(COMPOSE_FILE_DEV) \
		up -d

migrate:
	docker run -ti --rm \
		-v $(PWD):/apps \
		-w /apps/sqlite_db \
		alpine/sqlite notes-app.sqlite ".read migrate.sql" \
		&& cd sqlite_db/ \
		&& sudo chmod o=rw notes-app.db

create-stack:
	make compose-up \
		&& make migrate
