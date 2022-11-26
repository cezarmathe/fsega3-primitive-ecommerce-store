# Makefile

BIND_ADDR ?= 0.0.0.0
BIND_PORT ?= 8080

ADDRESS ?= $(BIND_ADDR):$(BIND_PORT)

default: run

# run runs the built-in php web server.
run:
	@ echo "--> Serving from www on $(ADDRESS)"
	@ echo
	@ cd public && php -S $(ADDRESS)
.PHONY: run

# db-reset will tear down the database and recreate it from scratch.
db-reset: db-teardown db-bootstrap

# db-bootstrap creates the database, runs migrations and seeds data.
db-bootstrap: db-create db-start db-migrate db-seed

# db-teardown will stop and destroy the database.
db-teardown: db-stop db-destroy

# db-create creates a docker container for the database.
db-create:
	@ echo "--> Creating database container"
	docker create \
		-p 5432:5432 \
		--name ecommerce-db \
		-e POSTGRES_DB=ecommerce \
		-e POSTGRES_HOST_AUTH_METHOD=trust \
		postgres:latest
.PHONY: db-create
.PHONY: db-create

# db-migrate runs migrations against the database.
db-migrate:
	@ echo "--> Migrating database"
	@ psql < database/up.sql
.PHONY: db-migrate

# db-seed seeds the database with data.
db-seed:
	@ echo "--> Seeding database"
	@ psql < database/seed.sql
.PHONY: db-seed

# db-destroy destroys the database container.
db-destroy:
	@ echo "--> Destroying database"
	docker rm -f ecommerce-db
.PHONY: db-destroy

# db-start starts the database container.
db-start:
	@ echo "--> Starting database"
	docker start ecommerce-db
	@ sleep 5
.PHONY: db-start

# db-stop stops the database container.
db-stop:
	docker stop ecommerce-db
.PHONY: db-stop
