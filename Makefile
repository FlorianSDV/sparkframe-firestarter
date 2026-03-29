COMPOSE_FILE=docker-compose.yml

compose-up:
	docker compose \
		-f $(COMPOSE_FILE) \
		up -d

migrate:
	docker run -ti --rm \
		-v $(PWD):/apps \
		-w /apps/sqlite_db \
		alpine/sqlite notes-app.db ".read migrate.sql" \
		&& cd sqlite_db/ \
		&& sudo chmod o=rw notes-app.db

create-stack:
	make compose-up \
		&& make migrate
