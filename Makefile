.DEFAULT_GOAL := help
help:
	@echo ""
	@echo "Available tasks:"
	@echo "shell"
	@echo "up"
	@echo "build"
	@echo "install"
	@echo "deps"

shell:
	@docker compose exec php sh
up:
	@docker compose up --remove-orphans
build:
	@docker compose build
install:
	@docker compose exec php composer install
deps:
	@docker compose exec php composer install --prefer-dist
test:
	@docker compose exec php composer test