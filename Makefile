.DEFAULT_GOAL := help
.PHONY: tests

start: ## Start the project
	docker-compose up -d

build:
	docker-composer up-d

stop: ## Stop the project
	docker-compose stop

down: ## Destroy the project
	docker-compose down

composer-install: ## Install composer dependencies
	docker-compose exec php composer install

composer-require: ## Require a composer dependency
	@read -p "Enter package name: " package; \
	echo "docker-compose exec php composer require $$package"; \
	docker-compose exec php composer require $$package

tests: ## Run all tests
	docker-compose exec php vendor/bin/phpunit

help: ## This help dialog.
	@IFS=$$'\n' ; \
	help_lines=(`fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##/:/'`); \
	printf "%-30s %s\n" "target" "help" ; \
	printf "%-30s %s\n" "------" "----" ; \
	for help_line in $${help_lines[@]}; do \
		IFS=$$':' ; \
		help_split=($$help_line) ; \
		help_command=`echo $${help_split[0]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
		help_info=`echo $${help_split[2]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
		printf '\033[36m'; \
		printf "%-30s %s" $$help_command ; \
		printf '\033[0m'; \
		printf "%s\n" $$help_info; \
	done
