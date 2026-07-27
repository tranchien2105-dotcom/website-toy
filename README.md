# website-toy

Dự án này là một ứng dụng web Laravel + Vue chạy trong Docker Compose. Toàn bộ mã nguồn backend/frontend nằm trong thư mục `src/`.

## Công nghệ chính

- PHP 8.3
- Laravel 12
- MySQL 8.0
- Vue 3
- Vue Router
- Pinia
- Vite
- Tailwind CSS
- Alpine.js
- CKEditor 5
- Laravel Sanctum, Socialite, DomPDF, Excel, Toastr
- Docker Compose (app, nginx, mysql, node)

## Cấu trúc chính

- `src/` - mã nguồn Laravel chính
- `docker-compose.yml` - thiết lập 4 service: `app`, `nginx`, `mysql`, `node`
- `docker/php/Dockerfile` - image PHP-FPM, cài PHP extension và Composer
- `docker/nginx/default.conf` - cấu hình Nginx cho Laravel
- `src/package.json` - cấu hình frontend/Vite
- `src/composer.json` - cấu hình PHP/Laravel

## Các service Docker

- `app`: PHP-FPM, mount `./src:/var/www`
- `nginx`: phục vụ Laravel ở port `8080`
- `mysql`: MySQL 8, xuất cổng `3308` để truy cập từ host
- `node`: Node 22, chạy `npm install` và `npm run dev -- --host` cho Vite

## Hướng dẫn chạy

1. Mở terminal tại thư mục gốc dự án:
   ```bash
   cd /home/minhchien/project/website-toy
   ```

2. Chạy Docker Compose:
   ```bash
   docker compose up -d
   ```

3. Vào container `app` và cài Composer nếu chưa có:
   ```bash
   docker compose exec app composer install
   ```

4. Vào container `node` và cài npm nếu cần:
   ```bash
   docker compose exec node npm install
   ```

5. Tạo file môi trường và thiết lập .env:
   ```bash
   cd src
   cp .env.example .env
   ```

6. Chỉnh lại cấu hình database trong `src/.env`:
   ```env
   APP_URL=http://localhost:8080
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=website_toy_db
   DB_USERNAME=website_toy_user
   DB_PASSWORD=123456
   ```

7. Tạo khóa ứng dụng và migrate:
   ```bash
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate --force
   ```

8. Mở trình duyệt truy cập:
   ```
   http://localhost:8080
   ```

## Chạy phát triển

- Frontend Vite chạy ở `http://localhost:5173`
- Nginx Laravel chạy ở `http://localhost:8080`

Nếu muốn chạy thủ công trong container node:
```bash
docker compose exec node npm run dev -- --host
```

## Lưu ý

- Mã nguồn thực tế đang nằm trong `src/`, không phải thư mục gốc.
- `.env.example` mặc định dùng SQLite, nhưng Docker Compose cấu hình MySQL nên cần chỉnh `.env` về kết nối MySQL.
- `docker compose down` để dừng và xóa container nếu cần.

## Tóm tắt chức năng

Dự án là một ứng dụng Laravel có frontend Vue/Vite. Cấu trúc chuẩn gồm backend Laravel, frontend Vite/Vue, hệ môi trường Docker cho chạy nhanh.
