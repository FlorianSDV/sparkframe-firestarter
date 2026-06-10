COMPOSE_FILE=docker-compose.yml
COMPOSE_FILE_DEV=docker-compose-dev.yml
COMPOSE_FILE_MYSQL=docker-compose-mysql.yml



compose-up-dev:
	docker compose \
		-f $(COMPOSE_FILE_DEV) \
		up -d




create-sqlite-db-dev:
	docker exec \
	sparkframe-firestarter-app-dev \
	composer create-sqlite-db



start-mysql-db-container:
	docker compose \
	-f $(COMPOSE_FILE_MYSQL) \
	up -d


create-stack-dev:
	make compose-up-dev \
		&& make create-sqlite-db-dev
# Maak je nog even niet druk over herbruikbaarheid

# prod
# Als je dit runt ben je ready to go
# - app en mysql container
# sqlite gemaakt en geseed
# mysql gemaakt en geseed
create-stack:
	make compose-up \
		&& make create-sqlite-db \
		&& make create-mysql-db

# Als de stack bestaat dan volstaat deze
compose-up:
	docker compose \
		-f $(COMPOSE_FILE) \
		-f $(COMPOSE_FILE_MYSQL) \
		up -d --wait

create-sqlite-db:
	docker exec \
	sparkframe-firestarter-app-production \
	composer create-sqlite-db

create-mysql-db:
	docker exec \
	sparkframe-firestarter-app-production \
	composer create-mysql-db
# dev

# local - hybrid

# local