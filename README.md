# Project SA/BIS

## สร้างระบบ HR ในหัวข้อ Appraisal ของบริษัทที่เลือก

### เป็นโปรเจกต์กลุ่มพัฒนาระบบ HR – Appraisal System โดยใช้ PHP ในส่วนของ Backend เพื่อจัดการและดึงข้อมูลจาก PostgreSQL และใช้ PHP, Bootstrap และ JavaScript ในส่วนของ Frontend สำหรับแสดงผลข้อมูลตาม Requirement ที่ได้จากการสัมภาษณ์บริษัท

PHP + PostgreSQL + Docker

---

## Requirements

ติดตั้งสิ่งเหล่านี้ก่อน:

- [Git](https://git-scm.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)

---

## Getting Started

### 1. Clone โปรเจค

```bash
git clone https://github.com/thanachotelu/mafiaSU.git
cd mafiaSU
```

---

### 2. รัน Docker

เปิด **Docker Desktop** ให้รันอยู่ก่อน จากนั้น:

```bash
docker-compose build
docker-compose up -d
```

รอจนขึ้นครบ 3 container (`php-apache`, `appraisal_postgres`, `appraisal_pgadmin`)

---

### 3. เปิดเว็บ

เปิดเบราว์เซอร์ไปที่ **`http://localhost:8000/html/index.php`**

---

### 4. Login

ระบบใช้ **firstname** ของพนักงานเป็น username (ไม่มี password)

| Role | วิธี Login |
|---|---|
| Chief | ใส่ firstname ของ Chief |
| Manager | ใส่ firstname ของ Manager |
| Officer | ใส่ firstname ของ Officer |

> ดู firstname ของพนักงานได้จาก init.sql

---

### 5. ตรวจสอบ Database

เปิด **`http://localhost:5000`**

| Field | ค่า |
|---|---|
| Email | `keakwanwong_t@silpakorn.edu` |
| Password | `password` |

เพิ่ม Server ใน pgAdmin:

| Field | ค่า |
|---|---|
| Host | `appraisal_postgres` |
| Port | `5432` |
| Database | `appraisal` |
| Username | `appraisal_user` |
| Password | `your_strong_password` |

---

## โครงสร้างโปรเจค

```
mafiaSU/
├── .env                    # Environment variables
├── docker-compose.yml      # Docker config
├── docker/
│   ├── Dockerfile.php      # PHP + Apache config
│   ├── Dockerfile.postgres # PostgreSQL config
│   └── init.sql            # Database schema + seed data
└── php/src/
    ├── assets/             # CSS, JS, Images
    └── html/
        ├── index.php       # Login page
        ├── login_cheker.php
        ├── Chief/          # หน้าสำหรับ Chief
        ├── Manager/        # หน้าสำหรับ Manager
        └── Officer/        # หน้าสำหรับ Officer
```

---

## Tech Stack

| Layer | Technology |
|---|---|
| Frontend | PHP + Bootstrap |
| Backend | PHP + PDO |
| Database | PostgreSQL 14 |
| DevOps | Docker + Docker Compose |
| Charts | ApexCharts |

---

## Port Summary

| Service | URL |
|---|---|
| เว็บ | http://localhost:8000/html/index.php |
| pgAdmin | http://localhost:5000 |
| PostgreSQL | localhost:5432 |

---

## ทุกครั้งที่จะเปิดโปรเจค

```bash
docker-compose up -d
```

ปิดโปรเจค:

```bash
docker-compose down
```