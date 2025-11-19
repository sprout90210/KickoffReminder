up:
	docker-compose up -d --build
down:
	docker-compose down
ps:
	docker-compose ps
logs:
	docker-compose logs
la:
	docker exec -it laravel bash
nginx:
	docker exec -it nginx bash
stan:
	cd src && vendor/bin/phpstan analyse --memory-limit=1G && cd ..
