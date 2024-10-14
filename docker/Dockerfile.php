FROM php:8.1-apache

# ติดตั้งไลบรารีที่จำเป็นสำหรับการติดตั้ง PDO และการใช้งาน GD
RUN apt-get update && apt-get install -y libpq-dev libjpeg-dev libpng-dev libfreetype6-dev

# เปิดใช้งานส่วนขยาย PDO สำหรับ MySQL และ PostgreSQL
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# กำหนดสิทธิ์ในการเข้าถึงโฟลเดอร์เว็บเซิร์ฟเวอร์
RUN chown -R www-data:www-data /var/www/html