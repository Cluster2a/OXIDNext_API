env := php-fpm-oxidnext-development
ROOT_DIR:=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

init:
	docker exec -it $(env) sh /app/init.sh

db-import:
	docker exec -it $(env) sh /app/db-import.sh

up:
	docker-compose up

down:
	docker-compose stop

bash:
	docker exec -it $(env) /bin/sh

build:
	$(dc) up --build

generate_namespaces:
	docker exec -it $(env) /bin/sh -c "/app/vendor/bin/oe-eshop-unified_namespace_generator"

ide_helper:
	docker exec -it $(env) /bin/sh -c "/app/vendor/bin/oe-eshop-ide_helper"

clear-cache:
	docker exec -it $(env) /bin/sh -c "rm -r /app/source/tmp/* && mkdir /app/source/tmp/ && chmod 777 -R /app/source/tmp/"
	docker exec -it $(env) /bin/sh -c "rm -r /app/source/cache/* && mkdir /app/source/cache/ && chmod 777 -R /app/source/cache/"

composer-update:
	docker exec -it $(env) /bin/sh -c 'cd /app/ && composer update'

composer-dump-autoload:
	docker exec -it $(env) /bin/sh -c 'cd /app/ && composer dump-autoload'

migrate:
	docker exec -it $(env) /bin/sh -c '/app/vendor/bin/oe-eshop-db_migrate migrations:migrate'

update-views:
	docker exec -it $(env) /bin/sh -c '/app/vendor/bin/oe-eshop-db_views_generate'

create-migration:
	docker exec -it $(env) /bin/sh -c '/app/vendor/bin/oe-eshop-db_migrate migrations:generate PR && chmod 777 -R /app/source/migration/project_data'

console-module-install:
	@read -p "Enter the folder name of the module you want to install (e.g. esy/modulename): " MODULEFOLDER \
	&& echo "Installing module /app/source/modules/$${MODULEFOLDER}" \
	&& docker exec -it $(env) /bin/sh -c "/app/vendor/bin/oe-console oe:module:install /app/source/modules/$${MODULEFOLDER}"

console-apply-configuration:
	docker exec -it $(env) /bin/sh -c "/app/vendor/bin/oe-console oe:module:apply-configuration && chmod 777 -R /app/var"