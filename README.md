<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Card Service

### Create *.env.compose* file
```dotenv
POSTGRES_DB: dbname
POSTGRES_USER: dbuser
POSTGRES_PASSWORD: dbpassword
```

### Rebuild and Run app
```shell
docker-compose --env-file .env.compose up --build -d
```

### Run app
```shell
docker-compose --env-file .env.compose up -d
```

### Test
```shell
docker exec -e XDEBUG_MODE=coverage -it cart-service composer coverage
```

### Shut down app
```shell
docker-compose --env-file .env.compose down
```

### URLS
- URL: [http://localhost:8000](http://localhost:8000)
- Health Check URL: [http://localhost:8000/up](http://localhost:8000/up)
- Coverage URL: [http://localhost:8000/coverage/index.html](http://localhost:8000/coverage/index.html)

### CI/CD Secret Variables
- DB
- DB_USER
- DB_PASSWORD
