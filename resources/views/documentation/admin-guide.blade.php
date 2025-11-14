@extends('layouts.template')

@section('content')
<style>
    .admin-manual-container {
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Inter', 'Prompt', 'Sarabun', sans-serif;
    }
    
    .admin-header {
        background: linear-gradient(135deg, #e53e3e 0%, #dd6b20 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .admin-nav {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: sticky;
        top: 20px;
        z-index: 100;
    }
    
    .admin-nav .nav-pills .nav-link {
        border-radius: 8px;
        margin: 0 5px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .admin-nav .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #e53e3e 0%, #dd6b20 100%);
    }
    
    .admin-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #2d3748;
        border-bottom: 3px solid #e53e3e;
        padding-bottom: 10px;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    
    .subsection-title {
        color: #4a5568;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #fff5f5;
        border-left: 4px solid #e53e3e;
        border-radius: 5px;
        font-weight: 600;
    }
    
    .config-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
        border-left: 4px solid #e53e3e;
    }
    
    .config-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        margin: 0.5rem 0;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .config-item:hover {
        border-color: #e53e3e;
        box-shadow: 0 2px 8px rgba(229, 62, 62, 0.1);
    }
    
    .config-key {
        font-family: 'Monaco', 'Consolas', monospace;
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.9rem;
    }
    
    .config-value {
        color: #4a5568;
        font-weight: 500;
    }
    
    .terminal-box {
        background: #1a202c;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 8px;
        font-family: 'Monaco', 'Consolas', monospace;
        overflow-x: auto;
        margin: 1rem 0;
        position: relative;
    }
    
    .terminal-box::before {
        content: '$ ';
        color: #68d391;
        font-weight: bold;
    }
    
    .permission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }
    
    .permission-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .permission-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .permission-name {
        font-family: 'Monaco', 'Consolas', monospace;
        background: #f1f5f9;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
        color: #2d3748;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    
    .database-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
        font-size: 0.9rem;
    }
    
    .database-table th,
    .database-table td {
        padding: 8px 12px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .database-table th {
        background: #fff5f5;
        font-weight: 600;
        color: #2d3748;
        font-size: 0.85rem;
    }
    
    .database-table tr:hover {
        background: #fff5f5;
    }
    
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    
    .status-running { background: #48bb78; }
    .status-stopped { background: #f56565; }
    .status-warning { background: #ed8936; }
    
    .maintenance-alert {
        background: #fed7d7;
        border: 1px solid #feb2b2;
        border-radius: 8px;
        padding: 1rem;
        margin: 1rem 0;
        border-left: 4px solid #e53e3e;
    }
    
    .backup-info {
        background: #e6fffa;
        border: 1px solid #81e6d9;
        border-radius: 8px;
        padding: 1rem;
        margin: 1rem 0;
    }
    
    .security-warning {
        background: #fffbeb;
        border: 1px solid #f6e05e;
        border-radius: 8px;
        padding: 1rem;
        margin: 1rem 0;
        border-left: 4px solid #ed8936;
    }
    
    @media (max-width: 768px) {
        .admin-nav {
            position: static;
        }
        
        .permission-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="admin-manual-container">
    <!-- Header -->
    <div class="admin-header">
        <h1><i class="fas fa-user-shield"></i> คู่มือผู้ดูแลระบบ</h1>
        <p class="mb-0">System Administrator Manual</p>
        <small>เวอร์ชัน 2.1.0 | อัปเดต: 13 พฤศจิกายน 2025</small>
    </div>

    <!-- Navigation -->
    <div class="admin-nav">
        <ul class="nav nav-pills justify-content-center" id="adminTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="system-overview-tab" data-bs-toggle="pill" data-bs-target="#system-overview">
                    <i class="fas fa-server"></i> ภาพรวมระบบ
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="user-management-tab" data-bs-toggle="pill" data-bs-target="#user-management">
                    <i class="fas fa-users-cog"></i> จัดการผู้ใช้
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="permissions-tab" data-bs-toggle="pill" data-bs-target="#permissions">
                    <i class="fas fa-shield-alt"></i> สิทธิ์การใช้งาน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="database-tab" data-bs-toggle="pill" data-bs-target="#database">
                    <i class="fas fa-database"></i> ฐานข้อมูล
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="maintenance-tab" data-bs-toggle="pill" data-bs-target="#maintenance">
                    <i class="fas fa-tools"></i> การบำรุงรักษา
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security">
                    <i class="fas fa-lock"></i> ความปลอดภัย
                </button>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="tab-content" id="adminContent">
        <!-- ภาพรวมระบบ -->
        <div class="tab-pane fade show active" id="system-overview">
            <div class="admin-section">
                <h2 class="section-title"><i class="fas fa-server"></i> ภาพรวมระบบ</h2>
                
                <h4 class="subsection-title"><i class="fas fa-info-circle"></i> ข้อมูลเทคนิค</h4>
                
                <div class="config-card">
                    <h6><i class="fas fa-code"></i> Stack เทคโนโลยี</h6>
                    <div class="config-item">
                        <span class="config-key">Framework</span>
                        <span class="config-value">Laravel 10.x</span>
                    </div>
                    <div class="config-item">
                        <span class="config-key">PHP Version</span>
                        <span class="config-value">8.1+</span>
                    </div>
                    <div class="config-item">
                        <span class="config-key">Database</span>
                        <span class="config-value">MySQL 8.0</span>
                    </div>
                    <div class="config-item">
                        <span class="config-key">Web Server</span>
                        <span class="config-value">Apache/Nginx</span>
                    </div>
                    <div class="config-item">
                        <span class="config-key">Frontend</span>
                        <span class="config-value">Bootstrap 5 + Blade Templates</span>
                    </div>
                </div>
                
                <h4 class="subsection-title"><i class="fas fa-folder-tree"></i> โครงสร้างไดเรกทอรี</h4>
                
                <div class="terminal-box">
app/
├── Http/Controllers/
│   ├── DashboardController.php      # หน้าแดชบอร์ด + แจ้งเตือน
│   ├── labours/labourController.php # จัดการข้อมูลแรงงาน  
│   └── DocumentationController.php  # คู่มือออนไลน์
├── Models/
│   └── labours/labourModel.php      # โมเดลข้อมูลแรงงาน
└── Services/
    ├── GlobalSetService.php         # การตั้งค่าระบบ
    └── TokenService.php             # การจัดการ API Token
                </div>
                
                <h4 class="subsection-title"><i class="fas fa-chart-line"></i> สถานะระบบปัจจุบัน</h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-heartbeat"></i> Service Status</h6>
                            <div class="config-item">
                                <span><span class="status-indicator status-running"></span>Web Application</span>
                                <span class="text-success">Running</span>
                            </div>
                            <div class="config-item">
                                <span><span class="status-indicator status-running"></span>Database</span>
                                <span class="text-success">Connected</span>
                            </div>
                            <div class="config-item">
                                <span><span class="status-indicator status-running"></span>File Storage</span>
                                <span class="text-success">Available</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-database"></i> Database Info</h6>
                            <div class="config-item">
                                <span>Total Labours</span>
                                <span class="text-info">{{ \App\Models\labours\labourModel::count() ?? 'N/A' }}</span>
                            </div>
                            <div class="config-item">
                                <span>Active Users</span>
                                <span class="text-info">{{ \App\Models\User::count() ?? 'N/A' }}</span>
                            </div>
                            <div class="config-item">
                                <span>Last Backup</span>
                                <span class="text-warning">Manual Check Required</span>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-cog"></i> การตั้งค่าสำคัญ</h4>
                
                <div class="terminal-box">
# ไฟล์การตั้งค่าสำคัญ
.env                    # ตัวแปรสภาพแวดล้อม
config/app.php          # การตั้งค่าแอปพลิเคชัน
config/database.php     # การเชื่อมต่อฐานข้อมูล
config/filesystems.php  # การจัดเก็บไฟล์
config/permission.php   # ระบบสิทธิ์การใช้งาน
                </div>
            </div>
        </div>

        <!-- การจัดการผู้ใช้ -->
        <div class="tab-pane fade" id="user-management">
            <div class="admin-section">
                <h2 class="section-title"><i class="fas fa-users-cog"></i> การจัดการผู้ใช้งาน</h2>

                <h4 class="subsection-title"><i class="fas fa-user-plus"></i> การสร้างผู้ใช้ใหม่</h4>
                
                <div class="config-card">
                    <h6>วิธีเพิ่มผู้ใช้งานใหม่</h6>
                    <ol>
                        <li>เข้าสู่หน้าการจัดการผู้ใช้</li>
                        <li>คลิกปุ่ม "สร้างผู้ใช้ใหม่"</li>
                        <li>กรอกข้อมูล:
                            <ul>
                                <li>ชื่อผู้ใช้ (Username)</li>
                                <li>อีเมล</li>
                                <li>รหัสผ่าน</li>
                                <li>ชื่อ-นามสกุล</li>
                                <li>บทบาท (Role)</li>
                            </ul>
                        </li>
                        <li>กำหนดสิทธิ์การเข้าถึง</li>
                        <li>บันทึกข้อมูล</li>
                    </ol>
                </div>

                <h4 class="subsection-title"><i class="fas fa-users"></i> ประเภทผู้ใช้งาน</h4>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="config-card">
                            <h6 class="text-danger"><i class="fas fa-crown"></i> Super Admin</h6>
                            <ul>
                                <li>เข้าถึงทุกฟังก์ชัน</li>
                                <li>จัดการผู้ใช้</li>
                                <li>ตั้งค่าระบบ</li>
                                <li>ดูข้อมูลระบบ</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="config-card">
                            <h6 class="text-success"><i class="fas fa-calculator"></i> Finance Manager</h6>
                            <ul>
                                <li>จัดการข้อมูลการเงิน</li>
                                <li>ดูรายงานการเงิน</li>
                                <li>อัปเดตสถานะการเงิน</li>
                                <li>ส่งออกรายงาน Excel</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="config-card">
                            <h6 class="text-info"><i class="fas fa-user"></i> Staff</h6>
                            <ul>
                                <li>ดูข้อมูลแรงงาน</li>
                                <li>แก้ไขข้อมูลพื้นฐาน</li>
                                <li>อัปโลดเอกสาร</li>
                                <li>ดูรายงานทั่วไป</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-key"></i> การรีเซ็ตรหัสผ่าน</h4>
                
                <div class="terminal-box">
# วิธีรีเซ็ตรหัสผ่านผ่าน Artisan Command
php artisan tinker
User::where('email', 'user@example.com')->first()->update(['password' => bcrypt('new_password')]);
exit
                </div>

                <div class="security-warning">
                    <strong><i class="fas fa-exclamation-triangle"></i> ข้อควรระวัง:</strong>
                    <ul>
                        <li>รหัสผ่านควรมีความยาวอย่างน้อย 8 ตัวอักษร</li>
                        <li>ควรผสมตัวอักษร ตัวเลข และอักขระพิเศษ</li>
                        <li>ไม่ควรใช้รหัสผ่านที่เดาง่าย</li>
                        <li>บอกผู้ใช้ให้เปลี่ยนรหัสผ่านในการเข้าใช้ครั้งแรก</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- สิทธิ์การใช้งาน -->
        <div class="tab-pane fade" id="permissions">
            <div class="admin-section">
                <h2 class="section-title"><i class="fas fa-shield-alt"></i> ระบบสิทธิ์การใช้งาน</h2>

                <h4 class="subsection-title"><i class="fas fa-list"></i> รายการสิทธิ์ในระบบ</h4>
                
                <div class="permission-grid">
                    <div class="permission-card">
                        <div class="permission-name">labour-view</div>
                        <p><strong>ดูข้อมูลแรงงาน:</strong> ดูรายการและรายละเอียดแรงงาน</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">labour-create</div>
                        <p><strong>เพิ่มแรงงาน:</strong> สร้างข้อมูลแรงงานใหม่</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">labour-update</div>
                        <p><strong>แก้ไขแรงงาน:</strong> อัปเดตข้อมูลแรงงาน</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">labour-delete</div>
                        <p><strong>ลบแรงงาน:</strong> ลบข้อมูลแรงงาน</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">account-update-labour</div>
                        <p><strong>อัปเดตข้อมูลการเงิน (เก่า):</strong> แก้ไขข้อมูลการเงินของแรงงาน (สิทธิ์เดิม)</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">finance-view</div>
                        <p><strong>ดูข้อมูลการเงิน:</strong> เข้าถึงและดูข้อมูลการเงินอย่างเดียว (ไม่สามารถแก้ไข)</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">finance-manage</div>
                        <p><strong>จัดการข้อมูลการเงิน:</strong> เข้าถึง ดู แก้ไข และบันทึกข้อมูลการเงินได้ทั้งหมด</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">export-labour</div>
                        <p><strong>ส่งออกรายงาน:</strong> ดาวน์โหลดรายงาน Excel</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">user-management</div>
                        <p><strong>จัดการผู้ใช้:</strong> เพิ่ม แก้ไข ลบผู้ใช้</p>
                    </div>
                    
                    <div class="permission-card">
                        <div class="permission-name">system-admin</div>
                        <p><strong>ดูแลระบบ:</strong> เข้าถึงการตั้งค่าระบบทั้งหมด</p>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-user-tag"></i> การกำหนดสิทธิ์</h4>
                
                <div class="config-card">
                    <h6>การกำหนดสิทธิ์ให้ผู้ใช้</h6>
                    <div class="terminal-box">
# ผ่าน Laravel Tinker
php artisan tinker

# หาผู้ใช้
$user = User::where('email', 'user@example.com')->first();

# กำหนดสิทธิ์การเงิน
$user->givePermissionTo('finance-view');     # ดูข้อมูลการเงิน
$user->givePermissionTo('finance-manage');   # จัดการข้อมูลการเงิน

# กำหนดสิทธิ์หลายอัน
$user->givePermissionTo(['labour-view', 'labour-update', 'finance-view']);

# ลบสิทธิ์
$user->revokePermissionTo('finance-manage');

# ตรวจสอบสิทธิ์ที่มี
$user->permissions->pluck('name');

exit
                    </div>
                </div>
                
                <div class="config-card mt-3">
                    <h6>ตัวอย่างการกำหนดสิทธิ์ตามตำแหน่งงาน</h6>
                    <div class="terminal-box">
# สำหรับผู้จัดการการเงิน
$financeManager = User::where('email', 'finance.manager@company.com')->first();
$financeManager->givePermissionTo([
    'labour-view', 'labour-create', 'labour-update', 
    'finance-view', 'finance-manage', 'export-labour'
]);

# สำหรับเจ้าหน้าที่การเงิน
$financeStaff = User::where('email', 'finance.staff@company.com')->first();
$financeStaff->givePermissionTo([
    'labour-view', 'labour-update', 
    'finance-view', 'export-labour'
]);

# สำหรับหัวหน้างาน (ดูข้อมูลการเงินอย่างเดียว)
$supervisor = User::where('email', 'supervisor@company.com')->first();
$supervisor->givePermissionTo([
    'labour-view', 'finance-view'
]);
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-users"></i> การกำหนดสิทธิ์ตามบทบาท</h4>
                
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle"></i>
                    <strong>การจัดการสิทธิ์:</strong> คุณสามารถจัดการ Roles, Permissions และกำหนดให้ผู้ใช้ได้ที่เมนู <a href="{{ route('admin.roles-permissions.index') }}" target="_blank" class="alert-link">จัดการสิทธิ์</a>
                </div>
                
                <table class="database-table">
                    <thead>
                        <tr>
                            <th>บทบาท</th>
                            <th>สิทธิ์ที่แนะนำ</th>
                            <th>คำอธิบาย</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Admin</strong></td>
                            <td>ทุกสิทธิ์</td>
                            <td>สิทธิ์เต็มในการจัดการระบบ</td>
                        </tr>
                        <tr>
                            <td><strong>Finance Manager</strong></td>
                            <td>labour-*, finance-manage, export-labour</td>
                            <td>จัดการข้อมูลแรงงานและการเงินเต็มรูปแบบ</td>
                        </tr>
                        <tr>
                            <td><strong>Finance Staff</strong></td>
                            <td>labour-view, labour-update, finance-view, export-labour</td>
                            <td>ดูข้อมูลการเงินและแก้ไขข้อมูลแรงงานพื้นฐาน</td>
                        </tr>
                        <tr>
                            <td><strong>Staff</strong></td>
                            <td>labour-view, labour-update, export-labour</td>
                            <td>ดูและแก้ไขข้อมูลเท่านั้น</td>
                        </tr>
                        <tr>
                            <td><strong>Viewer</strong></td>
                            <td>labour-view</td>
                            <td>ดูข้อมูลเท่านั้น</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ฐานข้อมูล -->
        <div class="tab-pane fade" id="database">
            <div class="admin-section">
                <h2 class="section-title"><i class="fas fa-database"></i> การจัดการฐานข้อมูล</h2>

                <h4 class="subsection-title"><i class="fas fa-table"></i> ตารางสำคัญในระบบ</h4>
                
                <table class="database-table">
                    <thead>
                        <tr>
                            <th>ชื่อตาราง</th>
                            <th>ฟังก์ชัน</th>
                            <th>ฟิลด์สำคัญ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>labours</code></td>
                            <td>ข้อมูลแรงงาน</td>
                            <td>labour_id, labour_firstname, labour_passport, labour_cid_deposit_*</td>
                        </tr>
                        <tr>
                            <td><code>users</code></td>
                            <td>ข้อมูลผู้ใช้</td>
                            <td>id, name, email, password</td>
                        </tr>
                        <tr>
                            <td><code>permissions</code></td>
                            <td>สิทธิ์การใช้งาน</td>
                            <td>id, name, guard_name</td>
                        </tr>
                        <tr>
                            <td><code>model_has_permissions</code></td>
                            <td>สิทธิ์ของผู้ใช้</td>
                            <td>permission_id, model_type, model_id</td>
                        </tr>
                        <tr>
                            <td><code>globalsets</code></td>
                            <td>การตั้งค่าระบบ</td>
                            <td>gs_id, gs_name, gs_value</td>
                        </tr>
                    </tbody>
                </table>

                <h4 class="subsection-title"><i class="fas fa-history"></i> Migration ล่าสุด</h4>
                
                <div class="config-card">
                    <h6><i class="fas fa-money-bill-wave"></i> Finance Fields Migration</h6>
                    <p>ไฟล์: <code>2025_11_12_063017_add_finance_fields_to_labours_table.php</code></p>
                    <p>เพิ่มฟิลด์การเงิน:</p>
                    <ul>
                        <li><code>labour_cid_deposit_date</code> - วันที่รับเงินมัดจำ CID</li>
                        <li><code>labour_cid_deposit_total</code> - จำนวนเงินมัดจำ</li>
                        <li><code>labour_cidp_date</code> - วันที่จ่าย CID-P</li>
                        <li><code>labour_cidp_total</code> - จำนวนเงิน CID-P</li>
                        <li><code>labour_cidp_return_date</code> - วันที่ได้รับเงิน CID-P กลับ</li>
                        <li><code>labour_cidp_return_total</code> - จำนวนเงิน CID-P กลับ</li>
                        <li><code>labour_refund_date</code> - วันที่คืนเงินมัดจำ</li>
                        <li><code>labour_refund_total</code> - จำนวนเงินคืน</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-save"></i> การสำรองข้อมูล</h4>
                
                <div class="backup-info">
                    <h6><i class="fas fa-database"></i> คำสั่งสำรองข้อมูล</h6>
                    <div class="terminal-box">
# สำรองฐานข้อมูลทั้งหมด
mysqldump -u root -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# สำรองเฉพาะตารางสำคัญ
mysqldump -u root -p database_name labours users permissions > backup_essential_$(date +%Y%m%d).sql

# กู้คืนข้อมูล
mysql -u root -p database_name < backup_file.sql
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-chart-pie"></i> การตรวจสอบสถานะฐานข้อมูล</h4>
                
                <div class="terminal-box">
# ตรวจสอบขนาดฐานข้อมูล
SELECT 
    table_schema AS 'Database',
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)'
FROM information_schema.tables 
WHERE table_schema = 'your_database_name';

# ตรวจสอบจำนวนแถวในตารางสำคัญ
SELECT COUNT(*) as total_labours FROM labours;
SELECT COUNT(*) as total_users FROM users;
                </div>
            </div>
        </div>

        <!-- การบำรุงรักษา -->
        <div class="tab-pane fade" id="maintenance">
            <div class="admin-section">
                <h2 class="section-title"><i class="fas fa-tools"></i> การบำรุงรักษาระบบ</h2>

                <h4 class="subsection-title"><i class="fas fa-clock"></i> งานบำรุงรักษาประจำ</h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-calendar-day"></i> รายวัน</h6>
                            <ul>
                                <li>ตรวจสอบ Log Files</li>
                                <li>ดูการแจ้งเตือนระบบ</li>
                                <li>ตรวจสอบการใช้งาน Disk Space</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-calendar-week"></i> รายสัปดาห์</h6>
                            <ul>
                                <li>สำรองข้อมูลฐานข้อมูล</li>
                                <li>ทำความสะอาดไฟล์ Temporary</li>
                                <li>อัปเดต Security Patches</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-calendar-alt"></i> รายเดือน</h6>
                            <ul>
                                <li>ตรวจสอบ Performance ระบบ</li>
                                <li>รีวิวสิทธิ์ผู้ใช้งาน</li>
                                <li>ทดสอบระบบ Backup & Restore</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-calendar"></i> รายปี</h6>
                            <ul>
                                <li>อัปเกรด Framework และ Dependencies</li>
                                <li>ตรวจสอบ Security Audit</li>
                                <li>วางแผนการขยายระบบ</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-file-alt"></i> การจัดการ Log Files</h4>
                
                <div class="terminal-box">
# ดู Laravel Logs
tail -f storage/logs/laravel.log

# ดู Apache/Nginx Access Logs
tail -f /var/log/apache2/access.log
tail -f /var/log/nginx/access.log

# ลบ Log เก่า (เก็บแค่ 30 วันล่าสุด)
find storage/logs -name "*.log" -type f -mtime +30 -delete

# ดูขนาด Log Files
du -sh storage/logs/
                </div>

                <h4 class="subsection-title"><i class="fas fa-broom"></i> การทำความสะอาดระบบ</h4>
                
                <div class="terminal-box">
# ล้าง Cache ต่างๆ
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# ล้าง Session เก่า
php artisan session:gc

# Optimize Application
php artisan optimize
php artisan config:cache
php artisan route:cache
                </div>

                <div class="maintenance-alert">
                    <strong><i class="fas fa-exclamation-triangle"></i> ข้อควรระวังในการบำรุงรักษา:</strong>
                    <ul>
                        <li>ทำ Backup ก่อนการอัปเดตหรือเปลี่ยนแปลงใดๆ</li>
                        <li>ทดสอบในสภาพแวดล้อม Development ก่อน</li>
                        <li>แจ้งผู้ใช้ล่วงหน้าหากต้องปิดระบบ</li>
                        <li>เก็บ Log การทำงานไว้เป็นหลักฐาน</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ความปลอดภัย -->
        <div class="tab-pane fade" id="security">
            <div class="admin-section">
                <h2 class="section-title"><i class="fas fa-lock"></i> ความปลอดภัยของระบบ</h2>

                <h4 class="subsection-title"><i class="fas fa-shield-virus"></i> มาตรการป้องกันพื้นฐาน</h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-key"></i> การจัดการรหัสผ่าน</h6>
                            <ul>
                                <li>บังคับใช้รหัสผ่านที่แข็งแรง</li>
                                <li>เข้ารหัสด้วย bcrypt</li>
                                <li>บังคับเปลี่ยนรหัสผ่านเป็นระยะ</li>
                                <li>ไม่อนุญาตให้ใช้รหัสผ่านเก่า</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="config-card">
                            <h6><i class="fas fa-user-lock"></i> การควบคุมการเข้าถึง</h6>
                            <ul>
                                <li>ระบบสิทธิ์แบบ Role-Based</li>
                                <li>Session Timeout หลังไม่ใช้งาน</li>
                                <li>IP Whitelisting (ถ้าจำเป็น)</li>
                                <li>Login Attempt Limiting</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-file-shield"></i> การรักษาความปลอดภัยไฟล์</h4>
                
                <div class="config-card">
                    <h6>การตรวจสอบไฟล์อัปโหลด</h6>
                    <ul>
                        <li><strong>ประเภทไฟล์:</strong> จำกัดเฉพาะ PDF, JPG, PNG, DOC</li>
                        <li><strong>ขนาดไฟล์:</strong> สูงสุด 2MB ต่อไฟล์</li>
                        <li><strong>ชื่อไฟล์:</strong> ตรวจสอบอักขระพิเศษ</li>
                        <li><strong>ที่เก็บไฟล์:</strong> นอก Document Root</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-database"></i> ความปลอดภัยฐานข้อมูล</h4>
                
                <div class="terminal-box">
# ตรวจสอบการใช้งาน Prepared Statements
# ใน Laravel ORM จะใช้ Prepared Statements โดยอัตโนมัติ

# ตรวจสอบสิทธิ์ Database User
SHOW GRANTS FOR 'username'@'localhost';

# เปลี่ยนรหัสผ่าน Database
ALTER USER 'username'@'localhost' IDENTIFIED BY 'new_strong_password';
                </div>

                <h4 class="subsection-title"><i class="fas fa-eye"></i> การติดตามและตรวจสอบ</h4>
                
                <div class="config-card">
                    <h6>สิ่งที่ควรติดตาม</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>การ Login ที่ผิดปกติ</li>
                                <li>การเข้าถึงไฟล์ที่ไม่ได้รับอนุญาต</li>
                                <li>การใช้งานฟังก์ชันที่อันตราย</li>
                                <li>การอัปโหลดไฟล์ประเภทต้องห้าม</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>การเปลี่ยนแปลงข้อมูลสำคัญ</li>
                                <li>การใช้งานนอกเวลา</li>
                                <li>Error 404/500 ที่ผิดปกติ</li>
                                <li>การเข้าถึงจาก IP แปลกใหม่</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-exclamation-triangle"></i> แผนตอบสนองเหตุการณ์</h4>
                
                <div class="security-warning">
                    <h6>เมื่อพบการโจมตี</h6>
                    <ol>
                        <li><strong>ระงับการเข้าถึง:</strong> ปิด IP หรือบัญชีผู้ใช้ที่น่าสงสัย</li>
                        <li><strong>เก็บหลักฐาน:</strong> บันทึก Log และข้อมูลการโจมตี</li>
                        <li><strong>ประเมินความเสียหาย:</strong> ตรวจสอบข้อมูลที่อาจรั่วไหล</li>
                        <li><strong>แก้ไขช่องโหว่:</strong> อัปเดต Security Patch</li>
                        <li><strong>แจ้งผู้เกี่ยวข้อง:</strong> รายงานให้ผู้บริหารทราบ</li>
                        <li><strong>เปลี่ยนรหัสผ่าน:</strong> บังคับเปลี่ยนรหัสผ่านผู้ใช้ทั้งหมด</li>
                    </ol>
                </div>

                <h4 class="subsection-title"><i class="fas fa-clipboard-check"></i> Security Checklist</h4>
                
                <table class="database-table">
                    <thead>
                        <tr>
                            <th>รายการตรวจสอบ</th>
                            <th>ความถี่</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>อัปเดต Laravel Framework</td>
                            <td>รายเดือน</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>ตรวจสอบ SSL Certificate</td>
                            <td>รายเดือน</td>
                            <td><span class="badge bg-success">OK</span></td>
                        </tr>
                        <tr>
                            <td>สำรองข้อมูลฐานข้อมูล</td>
                            <td>รายสัปดาห์</td>
                            <td><span class="badge bg-success">OK</span></td>
                        </tr>
                        <tr>
                            <td>ตรวจสอบ File Permissions</td>
                            <td>รายสัปดาห์</td>
                            <td><span class="badge bg-success">OK</span></td>
                        </tr>
                        <tr>
                            <td>รีวิวสิทธิ์ผู้ใช้งาน</td>
                            <td>รายเดือน</td>
                            <td><span class="badge bg-info">Due</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll to top when switching tabs
    var adminTabs = document.querySelectorAll('#adminTabs button');
    adminTabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            setTimeout(function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        });
    });
    
    // Add tooltips to status indicators
    var statusIndicators = document.querySelectorAll('.status-indicator');
    statusIndicators.forEach(function(indicator) {
        if (indicator.classList.contains('status-running')) {
            indicator.title = 'Service กำลังทำงานปกติ';
        } else if (indicator.classList.contains('status-stopped')) {
            indicator.title = 'Service หยุดทำงาน';
        } else if (indicator.classList.contains('status-warning')) {
            indicator.title = 'Service มีปัญหา';
        }
    });
    
    // Copy terminal commands
    var terminalBoxes = document.querySelectorAll('.terminal-box');
    terminalBoxes.forEach(function(box) {
        box.style.cursor = 'pointer';
        box.title = 'คลิกเพื่อคัดลอกคำสั่ง';
        
        box.addEventListener('click', function() {
            var text = box.textContent.replace('$ ', '');
            navigator.clipboard.writeText(text).then(function() {
                var originalBg = box.style.backgroundColor;
                box.style.backgroundColor = '#22543d';
                
                setTimeout(function() {
                    box.style.backgroundColor = originalBg;
                }, 500);
            });
        });
    });
    
    // Highlight config keys on hover
    var configKeys = document.querySelectorAll('.config-key');
    configKeys.forEach(function(key) {
        key.addEventListener('mouseenter', function() {
            key.style.backgroundColor = '#e53e3e';
            key.style.color = 'white';
        });
        
        key.addEventListener('mouseleave', function() {
            key.style.backgroundColor = '#f1f5f9';
            key.style.color = '#2d3748';
        });
    });
});
</script>
@endsection