# 🚀 PHP CRUD Web Application

[![PHP Version](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Apache](https://img.shields.io/badge/Apache-2.4-D22128?style=flat-square&logo=apache&logoColor=white)](https://httpd.apache.org/)
[![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat-square&logo=docker&logoColor=white)](https://www.docker.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)

เว็บแอปพลิเคชันจัดการข้อมูลผู้ใช้งาน (CRUD - Create, Read, Update, Delete) พัฒนาด้วยภาษา **PHP** และฐานข้อมูล **MySQL** ทำงานบนคอนเทนเนอร์ **Docker** พร้อมดีไซน์หน้าเว็บทันสมัยระดับพรีเมียม (Modern & Glassmorphism UI)

---

## ✨ ฟีเจอร์หลัก (Key Features)

- **🎨 Modern & Responsive Design:** หน้าตาทันสมัย สไตล์ Glassmorphism, Gradient โทน Indigo-Violet, รองรับหน้าจอทุกขนาด (Responsive)
- **📊 Real-time Dashboard Stats:** สรุปยอดสมาชิกทั้งหมด, จำนวนผู้ใช้ชาย (Male), และหญิง (Female) แบบเรียลไทม์
- **🔍 Instant Live Search:** ค้นหาชื่อ-นามสกุล และอีเมลได้ทันทีขณะพิมพ์โดยไม่ต้องโหลดหน้าเว็บใหม่
- **🏷️ Gender Filter:** กรองแสดงเฉพาะกลุ่มเพศ (ทั้งหมด / ชาย / หญิง) ได้อย่างรวดเร็ว
- **🛡️ Secure Prepared Statements:** ป้องกัน SQL Injection ด้วย `mysqli_prepare` และรองรับอักขระภาษาไทยอย่างสมบูรณ์ (`utf8mb4`)
- **⚠️ SweetAlert2 Confirm Modal:** มีหน้าต่างป๊อปอัปยืนยันก่อนลบข้อมูล ป้องกันการกดผิด
- **👤 Initial Avatar Badges:** สัญลักษณ์รูปโปรไฟล์อักษรย่อพร้อมสีแยกตามเพศอัตโนมัติ
- **🐳 Full Dockerized:** รันระบบพร้อมฐานข้อมูล MySQL และ phpMyAdmin ได้ทันทีผ่าน Docker Compose

---

## 🛠️ เทคโนโลยีที่ใช้ (Tech Stack)

| ส่วนประกอบ | เทคโนโลยี |
| :--- | :--- |
| **Backend** | PHP 8.2 (Apache) |
| **Database** | MySQL 8.0 |
| **DB Management** | phpMyAdmin |
| **Frontend** | HTML5, CSS3, JavaScript (Vanilla ES6) |
| **UI Framework** | Bootstrap 5.3.3, Font Awesome 6.5.1 |
| **Alert Library** | SweetAlert2 |
| **Containerization** | Docker & Docker Compose |

---

## 📁 โครงสร้างโปรเจกต์ (Project Structure)

```text
crud-web-project/
├── .gitignore              # ไฟล์ยกเว้นการติดตามของ Git
├── Dockerfile              # Dockerfile สำหรับสร้างอิมเมจ PHP + Apache + mysqli
├── docker-compose.yml      # ตั้งค่าบริการ Web, Database (MySQL) และ phpMyAdmin
├── README.md               # เอกสารประกอบโปรเจกต์
└── www/                    # โฟลเดอร์ซอร์สโค้ดหลักของเว็บไซต์
    ├── add_new.php         # หน้าฟอร์มเพิ่มข้อมูลผู้ใช้งานใหม่
    ├── db_conn.php         # ไฟล์ตั้งค่าและเชื่อมต่อฐานข้อมูล MySQL
    ├── delete.php          # สคริปต์ประมวลผลการลบข้อมูล
    ├── edit.php            # หน้าฟอร์มแก้ไขข้อมูลผู้ใช้งาน
    ├── index.html          # ตัวนำทาง (Redirect) ไปยัง index.php
    ├── index.php           # หน้าหลัก แสดงตารางข้อมูลและแดชบอร์ด
    └── style.css           # สไตล์ชีตหลัก (Custom Modern Design System)
```

---

## 🗄️ โครงสร้างฐานข้อมูล (Database Schema)

**ฐานข้อมูล:** `crud_db`  
**ตาราง:** `crud_681310499`

| ฟิลด์ (Field) | ชนิดข้อมูล (Type) | คีย์ (Key) | คำอธิบาย |
| :--- | :--- | :---: | :--- |
| `id` | `INT` | PK (Auto Increment) | รหัสผู้ใช้งาน |
| `first_name` | `VARCHAR(100)` | - | ชื่อจริง |
| `last_name` | `VARCHAR(100)` | - | นามสกุล |
| `email` | `VARCHAR(100)` | - | อีเมล |
| `gender` | `VARCHAR(100)` | - | เพศ (`male` หรือ `female`) |

---

## 🚀 การติดตั้งและเปิดใช้งาน (Getting Started)

### ความต้องการของระบบ (Prerequisites)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (หรือ Docker Engine & Docker Compose)
- [Git](https://git-scm.com/)

### 1. สั่งรันระบบด้วย Docker Compose
เปิด Terminal หรือ PowerShell ในโฟลเดอร์โปรเจกต์ แล้วพิมพ์คำสั่ง:

```bash
docker compose up -d --build
```

### 2. เข้าใช้งานระบบผ่านเบราว์เซอร์

| บริการ | URL | ข้อมูลเข้าสู่ระบบ |
| :--- | :--- | :--- |
| **CRUD Web Application** | [http://localhost:8000](http://localhost:8000) | - |
| **phpMyAdmin** | [http://localhost:8080](http://localhost:8080) | Server: `db`<br>User: `user` หรือ `root`<br>Password: `password` หรือ `root_password` |
| **MySQL Port** | `localhost:3306` | User: `user`, Password: `password` |

---

## 📌 คำสั่ง Docker ที่มีประโยชน์ (Useful Docker Commands)

```bash
# ตรวจสอบสถานะคอนเทนเนอร์
docker compose ps

# ดูบันทึกการทำงาน (Logs) ของ Web Server
docker compose logs -f web

# ปิดการทำงานคอนเทนเนอร์ทั้งหมด
docker compose down

# ปิดการทำงานพร้อมลบ Volume ข้อมูลฐานข้อมูล (ระวังข้อมูลหาย)
docker compose down -v
```

---

## 👨‍💻 ผู้พัฒนา (Developer)
- รหัสนักศึกษา / โปรเจกต์: `681310499`
- บัญชี GitHub: [@16natrii-sudo](https://github.com/16natrii-sudo)
