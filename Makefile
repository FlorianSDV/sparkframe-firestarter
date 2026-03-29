COMPOSE_FILE=docker-compose.yml

compose-up:
	docker compose -f $(COMPOSE_FILE) up -d
