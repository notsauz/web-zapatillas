# Web Zapatillas

## **COMANDOS RAPIDOS**
Levantar Docker `docker compose up -d --build`

Ejecutar migraciones y seeds `docker compose exec app-zap php artisan migrate:fresh --seed`

Web `http://localhost:8080`

Intefaz grafica de BBDD `http://localhost:8081`

Informacion de admin en `database\seeders\AdminSeeder.php`

Ejecutar seed de zapatillas `docker compose exec app-zap php artisan db:seed --class=SneakersSeeder`

Ejecutar seed de zapatillas `docker compose exec app-zap php artisan db:seed --class=BrandSeeder`

### **REQUISITOS**
- Docker y Docker Compose
- Node.js versión 20.11.1 o superior (probado con 20.11.1)
- npm

### **PRIMERA VEZ (configuración inicial)**
```
# Clonar el repositorio
git clone https://github.com/notsauz/web-zapatillas

# Crear el .env
cp .env.example .env

# Levantar Docker
docker compose up -d --build

# Instalar dependencias de PHP (Opcional - Docker las instala)
docker compose exec app-zap composer install

# Instalar dependencias de Node.js
npm install

# Generar key de Laravel
docker compose exec app-zap php artisan key:generate

# Ejecutar migraciones y seeders (crear tablas y datos)
docker compose exec app-zap php artisan migrate:fresh --seed

# Compilar assets (desarrollo)
npm run dev

# O compilar para producción
npm run build
```