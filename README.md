# Simple Laravel 10 User Roles and Permissions
Learn how to develop simple Laravel 10 user roles and permissions application

> The complete tutorial step by step guide is available on my blog. [AllPHPTricks Laravel roles and permissions](https://www.allphptricks.com/simple-laravel-10-user-roles-and-permissions/)

## Blog
https://www.allphptricks.com/

## การอัปเดตล่าสุด (27 ตุลาคม 2025)

### 🎛️ ระบบ Dashboard ครบครัน
เพิ่มระบบแดชบอร์ดการแจ้งเตือนและสถิติแบบครอบคลุม:

#### ฟีเจอร์ใหม่ที่เพิ่ม: 27/10/2025
- **Dashboard Controller** (`app/Http/Controllers/DashboardController.php`)
  - คำนวณสถิติ (คนงานทั้งหมด, ไปทำงาน, ยกเลิก, สถานะ VISA)
  - ระบบแจ้งเตือนเอกสารหมดอายุ (แจ้งเตือน 15 วันล่วงหน้า)
  - ฟังก์ชันส่งออกรายงาน Excel
  - หน้ารายละเอียดสำหรับแต่ละหมวดสถิติ

- **การอัปเดต Database Schema**
  - เพิ่มฟิลด์ CID: `labour_cid_number`, `labour_cid_issue_date`, `labour_cid_expiry_date`
  - เพิ่มฟิลด์ Affidavit: `labour_affidavit_number`, `labour_affidavit_issue_date`, `labour_affidavit_expiry_date`
  - เพิ่มการติดตาม VISA: `labour_visa_status`, `labour_visa_submission_date`, `labour_visa_approval_date`
  - ลบฟิลด์ `labour_work_status` ที่ไม่ใช้แล้ว

- **หน้า Dashboard**
  - แดshบอร์ดทันสมัยแบบ responsive (`resources/views/dashboard/index.blade.php`)
  - การ์ดสถิติแบบ interactive พร้อม hover effects และการแสดงผลด้วย Chart.js
  - การ์ดแจ้งเตือนสำหรับเอกสารหมดอายุ (ผลโรค, พาสปอร์ต, CID, Affidavit)
  - หน้ารายละเอียดสำหรับการแจ้งเตือนและสถิติพร้อมส่งออก Excel
  - ขนาดคอนเทนเนอร์มาตรฐาน (max-width: 1200px) รูปลักษณ์เป็นมืออาชีพ

- **ระบบส่งออก Excel**
  - `NotificationExport.php` - ส่งออกการแจ้งเตือนเอกสารหมดอายุ
  - `StatisticExport.php` - ส่งออกสถิติคนงานตามหมวดหมู่
  - หัวตารางที่จัดรูปแบบและข้อมูลที่จัดรูปแบบวันที่แบบไทย

- **การอัปเดตฟอร์ม**
  - อัปเดตฟอร์มสร้าง/แก้ไขคนงานพร้อมฟิลด์ CID, Affidavit และ VISA ใหม่
  - ลบฟิลด์สถานะการทำงาน (รวมเข้ากับสถานะคนงานที่มีอยู่)

#### เส้นทาง (Routes) ที่เพิ่ม:
- `/dashboard` (แดshบอร์ดหลัก - ตั้งเป็นหน้าแรก)
- `/dashboard/notification-details/{type}` (รายการแจ้งเตือนแบบละเอียด)
- `/dashboard/statistic-details/{type}` (รายการสถิติแบบละเอียด)
- `/dashboard/export-notification/{type}` (ส่งออก Excel สำหรับการแจ้งเตือน)
- `/dashboard/export-statistic/{type}` (ส่งออก Excel สำหรับสถิติ)

#### ทางเทคนิค:
- การผสานรวม Chart.js สำหรับการแสดงผลข้อมูล
- Bootstrap 5 + CSS แบบกำหนดเองพร้อมเอฟเฟกต์ glassmorphism
- การออกแบบ responsive พร้อมการปรับให้เหมาะกับมือถือ
- ฟังก์ชันรีเฟรชอัตโนมัติ (ทุก 5 นาที)
- การ migrate ฐานข้อมูลอย่างปลอดภัยโดยไม่สูญเสียข้อมูล


## Installation 
Make sure that you have setup the environment properly. You will need minimum PHP 8.1, MySQL/MariaDB, composer and Node.js.

1. Download the project (or clone using GIT)
2. Copy `.env.example` into `.env` and configure your database credentials
3. Go to the project's root directory using terminal window/command prompt
4. Run `composer install`
5. Set the application key by running `php artisan key:generate --ansi`
6. Run migrations `php artisan migrate:fresh --seed`
7. Run `npm install`
8. Run `npm run build` to build assets
9. Start local server by executing `php artisan serve`
