# 🔧 คู่มือผู้ดูแลระบบ (Admin Guide)

## 📋 สารบัญ
1. [การติดตั้งและกำหนดค่า](#การติดตั้งและกำหนดค่า)
2. [การจัดการผู้ใช้และสิทธิ์](#การจัดการผู้ใช้และสิทธิ์)
3. [การบำรุงรักษาฐานข้อมูล](#การบำรุงรักษาฐานข้อมูล)
4. [การสำรองข้อมูล](#การสำรองข้อมูล)
5. [การแก้ไขปัญหาระบบ](#การแก้ไขปัญหาระบบ)
6. [การอัปเดตระบบ](#การอัปเดตระบบ)

---

## การติดตั้งและกำหนดค่า

### ⚙️ ข้อกำหนดระบบ
```
PHP >= 8.1
MySQL >= 8.0 หรือ MariaDB >= 10.3
Composer
Node.js >= 16.x
Apache/Nginx Web Server
```

### 📦 การติดตั้งครั้งแรก

#### 1. ดาวน์โหลดและตั้งค่าพื้นฐาน
```bash
# Clone repository
git clone [repository-url] skm
cd skm

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:fresh --seed

# Build assets
npm run build

# Start server
php artisan serve
```

#### 2. การตั้งค่า .env
```env
APP_NAME="Labour Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skm_database
DB_USERNAME=username
DB_PASSWORD=password

# File upload settings
FILESYSTEM_DISK=public
MAX_FILE_SIZE=2048

# Mail settings (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### 🗂️ การตั้งค่าไดเร็กทอรี

#### สิทธิ์โฟลเดอร์
```bash
# ให้สิทธิ์เขียนไฟล์
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/storage/

# เชื่อมโยง storage
php artisan storage:link
```

---

## การจัดการผู้ใช้และสิทธิ์

### 👤 การสร้าง Admin User แรก

#### วิธีที่ 1: ผ่าน Seeder
```bash
php artisan migrate:fresh --seed
# Default admin: admin@admin.com / password: password
```

#### วิธีที่ 2: ผ่าน Tinker
```bash
php artisan tinker

# สร้างผู้ใช้
$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@company.com',
    'password' => bcrypt('secure-password')
]);

# กำหนดสิทธิ์ Admin
$adminRole = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
$user->assignRole($adminRole);
```

### 🛡️ ระบบสิทธิ์และบทบาท

#### บทบาทหลักในระบบ
```php
// Administrator - เข้าถึงทุกอย่าง
'admin' => [
    'create-labour', 'edit-labour', 'delete-labour',
    'account-update-labour', 'manage-users', 'manage-roles',
    'view-dashboard', 'export-reports'
]

// Finance Manager - จัดการการเงิน
'finance' => [
    'create-labour', 'edit-labour', 'account-update-labour',
    'view-dashboard', 'export-reports'
]

// Staff - เจ้าหน้าที่ทั่วไป
'staff' => [
    'create-labour', 'edit-labour', 'view-dashboard'
]
```

#### การสร้างบทบาทใหม่
```bash
php artisan tinker

# สร้าง Role
$role = \Spatie\Permission\Models\Role::create(['name' => 'new-role']);

# สร้าง Permission
$permission = \Spatie\Permission\Models\Permission::create(['name' => 'new-permission']);

# กำหนด Permission ให้ Role
$role->givePermissionTo($permission);

# กำหนด Role ให้ User
$user->assignRole($role);
```

---

## การบำรุงรักษาฐานข้อมูล

### 🗄️ การจัดการ Migration

#### การสร้าง Migration ใหม่
```bash
# สร้าง migration สำหรับเพิ่มฟิลด์
php artisan make:migration add_new_field_to_labours_table --table=labours

# สร้าง migration สำหรับตารางใหม่
php artisan make:migration create_new_table --create=new_table

# รัน migration
php artisan migrate

# ย้อนกลับ migration
php artisan migrate:rollback --step=1
```

#### การตรวจสอบสถานะ Migration
```bash
# ดู migration ที่รันแล้ว
php artisan migrate:status

# ดู SQL ที่จะรัน (ไม่รันจริง)
php artisan migrate --pretend
```

### 🔧 การล้างข้อมูล Cache

```bash
# ล้าง application cache
php artisan cache:clear

# ล้าง config cache
php artisan config:clear

# ล้าง route cache
php artisan route:clear

# ล้าง view cache
php artisan view:clear

# ล้างทุกอย่าง
php artisan optimize:clear
```

### 📊 การตรวจสอบฐานข้อมูล

#### คำสั่ง SQL สำหรับตรวจสอบ
```sql
-- ตรวจสอบจำนวนแรงงาน
SELECT COUNT(*) as total_labours FROM labours;

-- ตรวจสอบแรงงานที่มีปัญหาข้อมูล
SELECT labour_id, labour_firstname, labour_lastname 
FROM labours 
WHERE labour_idcard_number IS NULL OR labour_idcard_number = '';

-- ตรวจสอบไฟล์ที่อัปโหลดแล้ว
SELECT COUNT(*) as uploaded_files 
FROM list_files 
WHERE file_path IS NOT NULL;

-- ตรวจสอบเงินมัดจำค้างชำระ
SELECT COUNT(*) as unpaid_deposits
FROM labours 
WHERE labour_cid_stand_date IS NOT NULL 
AND labour_cid_stand_date <= DATE_SUB(NOW(), INTERVAL 15 DAY)
AND labour_cid_deposit_date IS NULL;
```

---

## การสำรองข้อมูล

### 💾 การสำรอง Database

#### การสำรองด้วย mysqldump
```bash
# สำรองฐานข้อมูลทั้งหมด
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# สำรองเฉพาะตารางสำคัญ
mysqldump -u username -p database_name labours users roles permissions > labours_backup.sql

# สำรองพร้อม gzip
mysqldump -u username -p database_name | gzip > backup_$(date +%Y%m%d).sql.gz
```

#### สคริปต์สำรองอัตโนมัติ
```bash
#!/bin/bash
# backup_script.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/path/to/backup"
DB_NAME="skm_database"
DB_USER="username"
DB_PASS="password"

# สำรองฐานข้อมูล
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# สำรองไฟล์
tar -czf $BACKUP_DIR/files_$DATE.tar.gz storage/app/public/

# ลบไฟล์เก่าที่เก็บไว้เกิน 30 วัน
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete

echo "Backup completed: $DATE"
```

#### ตั้งค่า Cron Job สำหรับสำรองอัตโนมัติ
```bash
# เปิด crontab
crontab -e

# สำรองทุกวันเวลา 02:00
0 2 * * * /path/to/backup_script.sh >> /path/to/backup.log 2>&1
```

### 📁 การกู้คืนข้อมูล

#### การกู้คืน Database
```bash
# กู้คืนจากไฟล์ backup
mysql -u username -p database_name < backup_file.sql

# กู้คืนจาก gzip
gunzip < backup_file.sql.gz | mysql -u username -p database_name
```

#### การกู้คืนไฟล์
```bash
# แตกไฟล์จาก tar.gz
tar -xzf files_backup.tar.gz -C /

# คัดลอกไฟล์กลับ
cp -R backup_storage/* storage/app/public/
```

---

## การแก้ไขปัญหาระบบ

### 🚨 ปัญหาที่พบบ่อย

#### 1. 500 Internal Server Error
```bash
# ตรวจสอบ log
tail -f storage/logs/laravel.log

# ตรวจสอบสิทธิ์ไฟล์
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# ล้าง cache
php artisan optimize:clear
```

#### 2. Database Connection Error
```bash
# ตรวจสอบการเชื่อมต่อ database
php artisan tinker
DB::connection()->getPdo();

# ตรวจสอบ config
php artisan config:show database
```

#### 3. File Upload ไม่ทำงาน
```bash
# ตรวจสอบ storage link
php artisan storage:link

# ตรวจสอบขนาดไฟล์ใน php.ini
upload_max_filesize = 2M
post_max_size = 2M
max_execution_time = 300

# ตรวจสอบสิทธิ์โฟลเดอร์
chmod -R 755 storage/app/public/
```

### 📋 Log Files ที่ควรตรวจสอบ

```bash
# Laravel application logs
tail -f storage/logs/laravel.log

# Web server logs (Apache)
tail -f /var/log/apache2/error.log
tail -f /var/log/apache2/access.log

# Web server logs (Nginx)
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log

# MySQL logs
tail -f /var/log/mysql/error.log
```

### 🔍 การ Debug ระบบ

#### เปิด Debug Mode (เฉพาะ Development)
```env
APP_DEBUG=true
APP_LOG_LEVEL=debug
```

#### ใช้ Laravel Telescope (ถ้าติดตั้ง)
```bash
# ติดตั้ง Telescope
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate

# เข้าดูที่ /telescope
```

---

## การอัปเดตระบบ

### 🔄 การอัปเดต Laravel และ Dependencies

#### ขั้นตอนการอัปเดต
```bash
# 1. สำรองข้อมูลก่อน
./backup_script.sh

# 2. Pull โค้ดล่าสุด
git pull origin main

# 3. อัปเดต dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# 4. รัน migration ใหม่
php artisan migrate --force

# 5. ล้าง cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. ตรวจสอบระบบ
php artisan tinker
```

#### การตรวจสอบหลังอัปเดต
```bash
# ตรวจสอบ migration
php artisan migrate:status

# ตรวจสอบ dependencies
composer show --outdated

# ตรวจสอบ log หา error
tail -f storage/logs/laravel.log
```

### 🛡️ การอัปเดตด้านความปลอดภัย

#### การอัปเดต Security Patches
```bash
# อัปเดต composer dependencies
composer update --with-dependencies

# ตรวจสอบ vulnerabilities
composer audit

# อัปเดต npm packages
npm audit && npm audit fix
```

### 📋 Maintenance Mode

#### การเปิด Maintenance Mode
```bash
# เปิด maintenance mode
php artisan down --refresh=15

# เปิด maintenance mode พร้อมข้อความ
php artisan down --message="System under maintenance. Please try again later."

# เปิด maintenance mode แต่อนุญาต IP บางตัว
php artisan down --allow=192.168.1.100 --allow=192.168.1.101

# ปิด maintenance mode
php artisan up
```

---

## ⚡ Performance Optimization

### 🚀 การปรับแต่งประสิทธิภาพ

#### Laravel Optimization
```bash
# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Enable OPcache (ใน php.ini)
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
```

#### Database Optimization
```sql
-- เพิ่ม index สำหรับการค้นหา
ALTER TABLE labours ADD INDEX idx_idcard (labour_idcard_number);
ALTER TABLE labours ADD INDEX idx_status (labour_status);
ALTER TABLE labours ADD INDEX idx_country (country_id);

-- ตรวจสอบ slow queries
SET long_query_time = 2;
SET slow_query_log = 1;
```

### 📊 การตรวจสอบประสิทธิภาพ

```bash
# ตรวจสอบ memory usage
php artisan tinker
echo memory_get_peak_usage(true) / 1024 / 1024 . ' MB';

# ตรวจสอบ database queries
# ใช้ Laravel Debugbar หรือ Telescope

# ตรวจสอบ file size
du -sh storage/logs/
du -sh storage/app/public/
```

---

## 📞 การติดต่อและสนับสนุน

### 🔧 Developer Contact
- **Email**: developer@company.com
- **GitHub**: [repository-link]
- **Documentation**: [wiki-link]

### 🆘 Emergency Procedures
1. **ระบบล่ม**: เปิด maintenance mode ทันที
2. **Data Loss**: กู้คืนจาก backup ล่าสุด
3. **Security Breach**: เปลี่ยนรหัส database และ application key
4. **Performance Issue**: ตรวจสอบ slow query log และ application log

---

*เอกสารนี้อัปเดตล่าสุด: 13 พฤศจิกายน 2025*

*สำหรับผู้ดูแลระบบเท่านั้น*