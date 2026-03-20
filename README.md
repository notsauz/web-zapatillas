# Web Zapatillas

## **Descripción del proyecto**
Web de catálogo de zapatillas con marcas, modelos y tendencias. Proyecto para el TFG de DAW.

## **COMANDOS RAPIDOS**

### **PRIMERA VEZ (configuración inicial)**
```
# Clonar el repositorio
git clone `https://github.com/notsauz/web-zapatillas`

# Levantar Docker
docker compose up -d --build

# Instalar dependencias (Opcional)
docker compose exec app composer install

# Generar key de Laravel
docker compose exec app php artisan key:generate

# Ejecutar migraciones y seeders (crear tablas y datos)
docker compose exec app php artisan migrate:fresh --seed

```