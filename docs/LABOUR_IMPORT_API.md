# Labour Import API System

ระบบ Import ข้อมูลคนงานจาก API ภายนอกเข้าสู่ระบบจัดการคนงาน

## Features

### 1. Import ข้อมูลจาก API
- ดึงข้อมูลจาก `https://thailaborland.com/api/getuserpass`
- แสดงรายการผู้สมัครจาก API ในตารางที่สวยงาม
- กดปุ่ม Convert เพื่อแปลงข้อมูลเข้าสู่ระบบ

### 2. Data Mapping ระหว่าง API และระบบ
- `name` → `labour_firstname`, `labour_lastname` (แยกคำแรกและคำที่เหลือ)
- `phone` → `labour_phone_one`
- `email` → `labour_note` (บันทึกเป็นหมายเหตุ)
- `country` → `country_id` (Global Set ID 3)
- `province` → `position_id` (Global Set ID 5)

### 3. Global Sets Auto-Creation
- ระบบจะสร้าง Global Set Values อัตโนมัติหากไม่มีในระบบ
- Global Sets ที่ใช้:
  - ID 1: โรงพยาบาล
  - ID 2: ศูนย์สอบ
  - ID 3: ประเทศ
  - ID 4: กลุ่มงาน
  - ID 5: ตำแหน่งงาน
  - ID 6: สถานะแรงงาน
  - ID 7: เจ้าหน้าที่สรรหา
  - ID 8: สายงานเจ้าหน้าที่

### 4. API Status Callback
- ส่งสถานะ 200 กลับไปยัง External API เมื่อ Import สำเร็จ
- ส่งข้อผิดพลาดกลับเมื่อเกิดปัญหา

## Installation

### 1. รัน Migration
```bash
php artisan migrate
```

### 2. Setup Global Sets เริ่มต้น
```bash
php artisan labour:setup-global-sets
```

### 3. กำหนดค่า Environment
ใน `.env` file:
```env
# API Token สำหรับเข้าถึง External API
LABOUR_API_TOKEN=your_api_token_here

# Callback URL สำหรับส่งสถานะกลับ (optional)
LABOUR_API_CALLBACK_URL=https://thailaborland.com/api/callback
```

## Usage

### 1. เข้าสู่หน้า Import
- ไปที่เมนู "Import ข้อมูล API"
- หรือ URL: `/import-labours`

### 2. Convert ข้อมูล
- ระบบจะแสดงรายการผู้สมัครจาก API
- กดปุ่ม "Convert" เพื่อแปลงข้อมูลเข้าสู่ระบบ
- ระบบจะ redirect ไปหน้า edit labour หลังจากสำเร็จ

### 3. ตรวจสอบข้อมูล
- ข้อมูลที่ import จะมี fields พิเศษ:
  - `api_imported_at`: วันเวลาที่ import
  - `api_candidate_id`: ID จาก API ระบบภายนอก
  - `created_by`: "API Import"

## API Endpoints

### 1. Import Routes (Web)
```
GET  /import-labours         - หน้าแสดงรายการจาก API
POST /import-labours/convert/{id} - แปลงข้อมูล candidate
```

### 2. Status API Routes
```
POST /api/labour-status/receive      - รับสถานะจากระบบภายนอก
GET  /api/labour-status/send/{id}    - ส่งสถานะ labour กลับ
```

## Global Sets Management

### สร้าง Global Set Value ใหม่
```php
use App\Services\GlobalSetService;

$countryId = GlobalSetService::findOrCreateValue(3, 'ไทย');
$positionId = GlobalSetService::findOrCreateValue(5, 'พนักงานทั่วไป');
```

### ตรวจสอบ Global Sets ที่มี
```php
$globalSets = GlobalSetService::getSystemGlobalSets();
```

## Error Handling

### 1. ข้อมูลซ้ำ
- หากเลขบัตรประชาชนซ้ำ จะ return error 500
- Message: "เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว"

### 2. API Connection Error
- ระบบจะ retry การเชื่อมต่อหาก token หมดอายุ
- Log error ไว้ใน Laravel log

### 3. Validation Error
- ตรวจสอบข้อมูลที่จำเป็นก่อน create labour
- แสดง error message ในรูปแบบ JSON

## Logging

ระบบจะ log ข้อมูลสำคัญ:
- API calls และ responses
- Import สำเร็จ/ล้มเหลว
- External API callbacks
- Error messages

ตรวจสอบใน `storage/logs/laravel.log`

## Security

- ใช้ CSRF token สำหรับ AJAX requests
- Validate input data ก่อนบันทึก
- Log การกระทำสำคัญ
- Check permissions ด้วย middleware

## Customization

### เปลี่ยน Data Mapping
แก้ไขใน `ImportLabourController::mapCandidateData()`

### เพิ่ม Global Set
แก้ไขใน `GlobalSetService::getSystemGlobalSets()`

### เปลี่ยน Callback Format
แก้ไขใน `ImportLabourController::notifyExternalAPI()`
