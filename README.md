# Web Zapatillas

## **COMANDOS RAPIDOS**
Levantar Docker `docker compose up -d --build`

Ejecutar migraciones y seeds `docker compose exec app-zap php artisan migrate:fresh --seed`

Web `http://localhost:8080`

Intefaz grafica de BBDD `http://localhost:8081`

### **PRIMERA VEZ (configuración inicial)**
```
# Clonar el repositorio
git clone https://github.com/notsauz/web-zapatillas

# Crear el .env
cp .env.example .env

# Levantar Docker
docker compose up -d --build

# Instalar dependencias (Opcional)
docker compose exec app-zap composer install

# Generar key de Laravel
docker compose exec app-zap php artisan key:generate

# Ejecutar migraciones y seeders (crear tablas y datos)
docker compose exec app-zap php artisan migrate:fresh --seed

```