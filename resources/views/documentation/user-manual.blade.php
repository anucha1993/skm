@extends('layouts.template')

@section('content')
<style>
    .manual-container {
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Inter', 'Prompt', 'Sarabun', sans-serif;
    }
    
    .manual-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .manual-nav {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: sticky;
        top: 20px;
        z-index: 100;
    }
    
    .manual-nav .nav-pills .nav-link {
        border-radius: 8px;
        margin: 0 5px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .manual-nav .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .manual-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #2d3748;
        border-bottom: 3px solid #667eea;
        padding-bottom: 10px;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    
    .subsection-title {
        color: #4a5568;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #f7fafc;
        border-left: 4px solid #667eea;
        border-radius: 5px;
        font-weight: 600;
    }
    
    .step-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
        border-left: 4px solid #28a745;
    }
    
    .step-number {
        background: #667eea;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 10px;
    }
    
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin: 1.5rem 0;
    }
    
    .feature-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .feature-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #667eea;
    }
    
    .example-box {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 1rem;
        margin: 1rem 0;
    }
    
    .warning-box {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 1rem;
        margin: 1rem 0;
    }
    
    .success-box {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        padding: 1rem;
        margin: 1rem 0;
    }
    
    .code-block {
        background: #2d3748;
        color: #e2e8f0;
        padding: 1rem;
        border-radius: 8px;
        font-family: 'Monaco', 'Consolas', monospace;
        overflow-x: auto;
        margin: 1rem 0;
    }
    
    .url-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }
    
    .url-table th,
    .url-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .url-table th {
        background: #f7fafc;
        font-weight: 600;
        color: #2d3748;
    }
    
    .url-table tr:hover {
        background: #f7fafc;
    }
    
    .badge-custom {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .badge-green { background: #48bb78; color: white; }
    .badge-red { background: #f56565; color: white; }
    .badge-yellow { background: #ed8936; color: white; }
    .badge-blue { background: #4299e1; color: white; }
    
    .toc {
        background: #f7fafc;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .toc ul {
        list-style: none;
        padding-left: 0;
    }
    
    .toc li {
        padding: 0.25rem 0;
    }
    
    .toc a {
        text-decoration: none;
        color: #4a5568;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .toc a:hover {
        color: #667eea;
    }
    
    @media (max-width: 768px) {
        .manual-nav {
            position: static;
        }
        
        .feature-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="manual-container">
    <!-- Header -->
    <div class="manual-header">
        <h1><i class="fas fa-book"></i> คู่มือการใช้งานระบบบริหารจัดการแรงงาน</h1>
        <p class="mb-0">Labour Management System - User Manual</p>
        <small>เวอร์ชัน 2.1.0 | อัปเดต: 13 พฤศจิกายน 2025</small>
    </div>

    <!-- Navigation -->
    <div class="manual-nav">
        <ul class="nav nav-pills justify-content-center" id="manualTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview">
                    <i class="fas fa-home"></i> ภาพรวม
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="getting-started-tab" data-bs-toggle="pill" data-bs-target="#getting-started">
                    <i class="fas fa-play"></i> เริ่มต้นใช้งาน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="labour-management-tab" data-bs-toggle="pill" data-bs-target="#labour-management">
                    <i class="fas fa-users"></i> จัดการแรงงาน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="finance-tab" data-bs-toggle="pill" data-bs-target="#finance">
                    <i class="fas fa-calculator"></i> การเงิน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications">
                    <i class="fas fa-bell"></i> แจ้งเตือน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="troubleshooting-tab" data-bs-toggle="pill" data-bs-target="#troubleshooting">
                    <i class="fas fa-tools"></i> แก้ไขปัญหา
                </button>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="tab-content" id="manualContent">
        <!-- ภาพรวมระบบ -->
        <div class="tab-pane fade show active" id="overview">
            <div class="manual-section">
                <h2 class="section-title"><i class="fas fa-eye"></i> ภาพรวมระบบ</h2>
                
                <p class="lead">ระบบบริหารจัดการแรงงานนี้เป็นเว็บแอปพลิเคชันที่พัฒนาด้วย Laravel Framework สำหรับการจัดการข้อมูลแรงงานต่างชาติ โดยมีคุณสมบัติครบครันทั้งด้านข้อมูล การเงิน และการแจ้งเตือน</p>

                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <h5>จัดการข้อมูลแรงงาน</h5>
                        <p>บันทึก แก้ไข และติดตามสถานะแรงงานแบบครบวงจร พร้อมระบบอัปโลดเอกสาร</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-calculator"></i></div>
                        <h5>ระบบการเงินและบัญชี</h5>
                        <p>จัดการเงินมัดจำ CID, CID-P และการคืนเงิน พร้อมการคำนวณแบบเรียลไทม์</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-bell"></i></div>
                        <h5>ระบบแจ้งเตือน</h5>
                        <p>แจ้งเตือนเอกสารหมดอายุ การเงินค้างชำระ และสถิติต่างๆ แบบอัตโนมัติ</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                        <h5>ระบบสิทธิ์ผู้ใช้</h5>
                        <p>แบ่งสิทธิ์การเข้าถึงตามบทบาท เพื่อความปลอดภัยของข้อมูล</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                        <h5>รายงานและสถิติ</h5>
                        <p>สร้างรายงาน Excel และดูสถิติต่างๆ ในรูปแบบกราฟที่เข้าใจง่าย</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
                        <h5>จัดการเอกสาร</h5>
                        <p>อัปโลด จัดเก็บ และจัดการไฟล์เอกสารต่างๆ แบบเป็นระบบ</p>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-users-cog"></i> กลุ่มผู้ใช้งาน</h4>
                
                <div class="step-card">
                    <h6><span class="badge-custom badge-blue">Admin</span> ผู้ดูแลระบบ</h6>
                    <p>เข้าถึงได้ทุกฟังก์ชัน รวมถึงการจัดการผู้ใช้ สิทธิ์ และการตั้งค่าระบบ</p>
                </div>
                
                <div class="step-card">
                    <h6><span class="badge-custom badge-green">Finance</span> เจ้าหน้าที่การเงิน</h6>
                    <p>เข้าถึงระบบการเงิน สร้างรายงาน และจัดการข้อมูลการเงินของแรงงาน</p>
                </div>
                
                <div class="step-card">
                    <h6><span class="badge-custom badge-yellow">Staff</span> เจ้าหน้าที่ทั่วไป</h6>
                    <p>จัดการข้อมูลแรงงานพื้นฐาน อัปโลดเอกสาร และดูข้อมูลทั่วไป</p>
                </div>
            </div>
        </div>

        <!-- เริ่มต้นใช้งาน -->
        <div class="tab-pane fade" id="getting-started">
            <div class="manual-section">
                <h2 class="section-title"><i class="fas fa-play"></i> เริ่มต้นใช้งาน</h2>

                <h4 class="subsection-title"><i class="fas fa-sign-in-alt"></i> การเข้าสู่ระบบ</h4>
                
                <div class="step-card">
                    <h6><span class="step-number">1</span>เปิดเว็บไซต์</h6>
                    <p>เข้าไปที่ URL ของระบบที่ได้รับจาก IT หรือผู้ดูแลระบบ</p>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">2</span>กรอกข้อมูล Login</h6>
                    <ul>
                        <li>Username หรือ Email ที่ได้รับ</li>
                        <li>Password ที่กำหนดไว้</li>
                    </ul>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">3</span>เข้าสู่ระบบ</h6>
                    <p>กดปุ่ม "เข้าสู่ระบบ" หรือ "Login" เพื่อเข้าใช้งาน</p>
                </div>

                <div class="warning-box">
                    <strong><i class="fas fa-exclamation-triangle"></i> หมายเหตุ:</strong>
                    หากลืมรหัสผ่าน สามารถคลิก "Forgot Password" หรือติดต่อผู้ดูแลระบบ
                </div>

                <h4 class="subsection-title"><i class="fas fa-tachometer-alt"></i> หน้า Dashboard</h4>
                
                <p>หลังเข้าสู่ระบบแล้ว คุณจะเห็นหน้า Dashboard ที่แสดงข้อมูลสำคัญ:</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-chart-bar"></i> การ์ดสถิติ</h6>
                        <ul>
                            <li>คนงานทั้งหมด</li>
                            <li>คนงานที่ไปทำงานแล้ว</li>
                            <li>คนงานที่ยกเลิก</li>
                            <li>สถานะ VISA ต่างๆ</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-bell"></i> การแจ้งเตือน</h6>
                        <ul>
                            <li>เอกสารหมดอายุ (15 วันล่วงหน้า)</li>
                            <li>เงินมัดจำค้างชำระ</li>
                            <li>รายงานสถิติต่างๆ</li>
                        </ul>
                    </div>
                </div>

                <div class="success-box">
                    <strong><i class="fas fa-lightbulb"></i> เทคนิค:</strong>
                    คลิกที่การ์ดสถิติเพื่อดูรายละเอียดและส่งออกรายงาน Excel ได้ทันที!
                </div>
            </div>
        </div>

        <!-- จัดการแรงงาน -->
        <div class="tab-pane fade" id="labour-management">
            <div class="manual-section">
                <h2 class="section-title"><i class="fas fa-users"></i> การจัดการข้อมูลแรงงาน</h2>

                <h4 class="subsection-title"><i class="fas fa-plus"></i> การเพิ่มข้อมูลแรงงานใหม่</h4>
                
                <div class="step-card">
                    <h6><span class="step-number">1</span>เข้าสู่หน้าเพิ่มข้อมูล</h6>
                    <p>คลิกเมนู <strong>"Labours"</strong> → <strong>"Create New"</strong> หรือไปที่ <code>/labours/create</code></p>
                </div>

                <div class="step-card">
                    <h6><span class="step-number">2</span>กรอกข้อมูลในแต่ละแท็บ</h6>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6><i class="fas fa-id-card"></i> แท็บ "ข้อมูลส่วนตัว"</h6>
                            <ul>
                                <li>คำนำหน้า (Mr./Ms./Miss.)</li>
                                <li>ชื่อ-นามสกุล (ภาษาอังกฤษ)</li>
                                <li>เลขบัตรประชาชน (13 หลัก)</li>
                                <li>วันเกิด, เพศ, สัญชาติ</li>
                                <li>ที่อยู่และการติดต่อ</li>
                                <li>น้ำหนัก-ส่วนสูง (คำนวณ BMI อัตโนมัติ)</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-user-tie"></i> แท็บ "เจ้าหน้าที่สรรหา"</h6>
                            <ul>
                                <li>เจ้าหน้าที่หลัก</li>
                                <li>เจ้าหน้าที่ช่วย</li>
                                <li>บริษัทลูกค้า</li>
                                <li>เอกสารที่ใช้</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <h6><i class="fas fa-certificate"></i> แท็บ "ทดสอบฝีมือ"</h6>
                            <ul>
                                <li>วันที่ทดสอบ</li>
                                <li>สถานที่ทดสอบ</li>
                                <li>บริษัทที่ทดสอบ</li>
                                <li>ผลการทดสอบ</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-file-alt"></i> แท็บ "ไฟล์เอกสาร"</h6>
                            <p>หลังบันทึกข้อมูลแล้วจึงจะสามารถอัปโลดไฟล์ได้</p>
                        </div>
                    </div>
                </div>

                <div class="example-box">
                    <strong>ตัวอย่างการกรอกข้อมูล:</strong>
                    <ul>
                        <li><strong>ชื่อ:</strong> Somchai Jaidee</li>
                        <li><strong>เลขบัตร:</strong> 1234567890123 (เฉพาะตัวเลข 13 หลัก)</li>
                        <li><strong>เบอร์โทร:</strong> 0812345678 (ไม่ใส่เครื่องหมาย)</li>
                        <li><strong>อีเมล:</strong> somchai@gmail.com</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-edit"></i> การแก้ไขข้อมูลแรงงาน</h4>
                
                <div class="step-card">
                    <h6><span class="step-number">1</span>ค้นหาและเลือกแรงงาน</h6>
                    <p>ใช้ช่องค้นหาในหน้ารายการแรงงาน สามารถค้นหาจาก:</p>
                    <ul>
                        <li>เลขบัตรประชาชน</li>
                        <li>ชื่อ-นามสกุล</li>
                        <li>เบอร์โทรศัพท์</li>
                        <li>ประเทศ</li>
                    </ul>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">2</span>คลิกปุ่ม Edit</h6>
                    <p>คลิกปุ่ม <span class="badge-custom badge-yellow">Edit</span> ในแถวของแรงงานที่ต้องการแก้ไข</p>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">3</span>อัปโลดไฟล์เอกสาร</h6>
                    <p>ในแท็บ "ไฟล์เอกสาร" สามารถ:</p>
                    <ul>
                        <li>อัปโลดไฟล์ใหม่</li>
                        <li>ดาวน์โหลดไฟล์ที่มี</li>
                        <li>ลบไฟล์ที่ไม่ต้องการ</li>
                    </ul>
                </div>

                <div class="warning-box">
                    <strong><i class="fas fa-exclamation-triangle"></i> ข้อควรระวัง:</strong>
                    <ul>
                        <li>เลขบัตรประชาชนต้องไม่ซ้ำในระบบ</li>
                        <li>ไฟล์แต่ละไฟล์ไม่เกิน 2MB</li>
                        <li>รองรับไฟล์ประเภท: PDF, JPG, PNG, DOC</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ระบบการเงิน -->
        <div class="tab-pane fade" id="finance">
            <div class="manual-section">
                <h2 class="section-title"><i class="fas fa-calculator"></i> ระบบการเงินและบัญชี</h2>

                <div class="warning-box">
                    <strong><i class="fas fa-shield-alt"></i> การควบคุมสิทธิ์การเข้าถึง:</strong>
                    <p>แท็บการเงินมีการควบคุมสิทธิ์แบบหลายระดับ:</p>
                    <ul>
                        <li><strong><span class="badge-custom badge-red">finance-manage</span></strong> - จัดการข้อมูลการเงิน (แก้ไข บันทึก ลบได้)</li>
                        <li><strong><span class="badge-custom badge-yellow">finance-view</span></strong> - ดูข้อมูลการเงิน (อ่านได้อย่างเดียว)</li>
                        <li><strong><span class="badge-custom badge-blue">account-update-labour</span></strong> - สิทธิ์เดิม (เพื่อความเข้ากันได้)</li>
                    </ul>
                    <p><strong>หมายเหตุ:</strong> หากไม่มีสิทธิ์ใดๆ ข้างต้น แท็บการเงินจะไม่แสดงในระบบ</p>
                </div>
                
                <div class="config-card">
                    <h6><i class="fas fa-users-cog"></i> การกำหนดสิทธิ์ที่แนะนำตามตำแหน่งงาน</h6>
                    <table class="url-table">
                        <thead>
                            <tr>
                                <th>ตำแหน่งงาน</th>
                                <th>สิทธิ์ที่แนะนำ</th>
                                <th>สามารถทำได้</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>ผู้จัดการการเงิน</strong></td>
                                <td><span class="badge-custom badge-red">finance-manage</span></td>
                                <td>ดู แก้ไข บันทึกข้อมูลการเงินทั้งหมด</td>
                            </tr>
                            <tr>
                                <td><strong>เจ้าหน้าที่การเงิน</strong></td>
                                <td><span class="badge-custom badge-red">finance-manage</span></td>
                                <td>ดู แก้ไข บันทึกข้อมูลการเงิน</td>
                            </tr>
                            <tr>
                                <td><strong>หัวหน้างาน</strong></td>
                                <td><span class="badge-custom badge-yellow">finance-view</span></td>
                                <td>ดูข้อมูลการเงิน ตรวจสอบยอดเงิน</td>
                            </tr>
                            <tr>
                                <td><strong>เจ้าหน้าที่ทั่วไป</strong></td>
                                <td>ไม่มีสิทธิ์</td>
                                <td>ไม่สามารถเข้าถึงข้อมูลการเงินได้</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="subsection-title"><i class="fas fa-money-bill-wave"></i> ขั้นตอนการจัดการเงินที่ถูกต้อง</h4>
                
                <div class="step-card">
                    <h6><span class="step-number">1</span>บันทึกวันที่ยื่น CID</h6>
                    <p>ในแท็บ "ข้อมูลเพิ่มเติม" บันทึกวันที่ที่ยื่นขอ CID</p>
                    <div class="example-box">
                        <strong>ตัวอย่าง:</strong> สมชาย ยื่นขอ CID วันที่ 1 พฤศจิกายน 2025
                    </div>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">2</span>ระบบแจ้งเตือนอัตโนมัติ (หลัง 15 วันทำการ)</h6>
                    <div class="config-card">
                        <strong>เงื่อนไขการแจ้งเตือน:</strong>
                        <ul>
                            <li>มีข้อมูลในช่อง "วันที่ยื่น CID" (แท็บข้อมูลเพิ่มเติม)</li>
                            <li>วันที่ผ่านไป = ปัจจุบัน - วันยื่น CID > 15 วัน</li>
                            <li>ช่อง "วันที่วางเงินประกัน" = ยังไม่ได้กรอก (แท็บการเงิน)</li>
                            <li>ช่อง "จำนวนเงินประกัน" = ยังไม่ได้กรอกหรือ = 0 (แท็บการเงิน)</li>
                        </ul>
                        <strong>การแจ้งเตือน:</strong> แสดงในการ์ด "เงินมัดจำค้างชำระ" ใน Dashboard
                    </div>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">3</span>บันทึกเงินมัดจำ CID</h6>
                    <p>ในแท็บ "การเงิน" → ส่วน "เงินประกัน (Deposit)" กรอกข้อมูล:</p>
                    <ul>
                        <li><strong>วันที่วางเงินประกัน:</strong> วันที่ได้รับเงินมัดจำจากลูกค้า</li>
                        <li><strong>จำนวนเงินประกัน (บาท):</strong> จำนวนเงินที่ได้รับ</li>
                        <li><strong>วิธีการจ่าย:</strong> เงินสด, SCB, BBL</li>
                        <li><strong>สถานะการมัดจำ:</strong> None, ยกเลิก-คืนเงินประกัน, ยกเลิก-ไม่คืนเงินประกัน</li>
                    </ul>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">4</span>บันทึก CID-P</h6>
                    <p>ในแท็บ "การเงิน" → ส่วน "CID-P (CID Payment)" กรอกข้อมูล:</p>
                    <ul>
                        <li><strong>วันที่รับ Date CID-P:</strong> วันที่ได้รับแจ้งให้จ่าย CID-P</li>
                        <li><strong>จำนวนเงิน CID-P (บาท):</strong> จำนวนเงินที่ต้องจ่าย</li>
                        <li><strong>วันที่ชำระ CID-P:</strong> วันที่จ่ายเงิน CID-P จริง</li>
                        <li><strong>จำนวนเงิน CID-P เข้า (บาท):</strong> จำนวนเงินที่ได้รับคืน</li>
                    </ul>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">5</span>บันทึกเงินคืน (ถ้ามี)</h6>
                    <p>ในแท็บ "การเงิน" → ส่วน "การคืนเงินมัดจำ" กรอกข้อมูล:</p>
                    <ul>
                        <li><strong>วันที่คืนเงินมัดจำ:</strong> วันที่คืนเงินให้แรงงาน</li>
                        <li><strong>จำนวนเงินคืน (บาท):</strong> จำนวนเงินที่คืน</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-chart-line"></i> การคำนวณยอดคงเหลือแบบเรียลไทม์</h4>
                
                <div class="config-card">
                    <h6><i class="fas fa-calculator"></i> สูตรการคำนวณยอดคงเหลือ</h6>
                    <div class="terminal-box">
ยอดคงเหลือ = (เงินมัดจำ CID + เงิน CID-P ขาเข้า) - (เงิน CID-P ขาออก + เงินคืน)
                    </div>
                    
                    <h6 class="mt-3">ฟิลด์ที่ใช้ในการคำนวณ:</h6>
                    <table class="url-table">
                        <thead>
                            <tr>
                                <th>รายการ</th>
                                <th>ฟิลด์ในฐานข้อมูล</th>
                                <th>ประเภท</th>
                                <th>หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>เงินมัดจำ CID</td>
                                <td><code>labour_cid_deposit_total</code></td>
                                <td>เงินเข้า (+)</td>
                                <td>เงินที่ได้รับจากลูกค้า</td>
                            </tr>
                            <tr>
                                <td>เงิน CID-P ขาออก</td>
                                <td><code>labour_cidp_total</code></td>
                                <td>เงินออก (-)</td>
                                <td>เงินที่จ่ายให้หน่วยงาน</td>
                            </tr>
                            <tr>
                                <td>เงิน CID-P ขาเข้า</td>
                                <td><code>labour_cidp_return_total</code></td>
                                <td>เงินเข้า (+)</td>
                                <td>เงินที่ได้รับกลับจากหน่วยงาน</td>
                            </tr>
                            <tr>
                                <td>เงินคืนมัดจำ</td>
                                <td><code>labour_refund_total</code></td>
                                <td>เงินออก (-)</td>
                                <td>เงินที่คืนให้แรงงาน</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="example-box">
                    <strong>ตัวอย่างการคำนวณ (กรณีปกติ):</strong>
                    <table class="table table-sm mt-2">
                        <tr><td>เงินมัดจำ CID (รับจากลูกค้า)</td><td class="text-success">+ 50,000 บาท</td></tr>
                        <tr><td>เงิน CID-P ขาออก (จ่ายให้หน่วยงาน)</td><td class="text-danger">- 30,000 บาท</td></tr>
                        <tr><td>เงิน CID-P ขาเข้า (ได้รับกลับ)</td><td class="text-success">+ 25,000 บาท</td></tr>
                        <tr><td>เงินคืน (คืนให้แรงงาน)</td><td class="text-danger">- 10,000 บาท</td></tr>
                        <tr class="table-success"><td><strong>ยอดคงเหลือ</strong></td><td><strong>35,000 บาท</strong></td></tr>
                    </table>
                    <small class="text-muted">การคำนวณ: 50,000 + 25,000 - 30,000 - 10,000 = 35,000 บาท</small>
                </div>
                
                <div class="warning-box">
                    <strong>ตัวอย่างการคำนวณ (กรณียกเลิก):</strong>
                    <table class="table table-sm mt-2">
                        <tr><td>เงินมัดจำ CID (รับจากลูกค้า)</td><td class="text-success">+ 50,000 บาท</td></tr>
                        <tr><td>เงิน CID-P ขาออก</td><td class="text-muted">0 บาท (ยังไม่จ่าย)</td></tr>
                        <tr><td>เงิน CID-P ขาเข้า</td><td class="text-muted">0 บาท</td></tr>
                        <tr><td>เงินคืน (คืนให้แรงงาน)</td><td class="text-danger">- 45,000 บาท</td></tr>
                        <tr class="table-success"><td><strong>ยอดคงเหลือ</strong></td><td><strong>5,000 บาท</strong></td></tr>
                    </table>
                    <small class="text-muted">การคำนวณ: 50,000 + 0 - 0 - 45,000 = 5,000 บาท (บริษัทได้กำไร 5,000 บาท)</small>
                </div>

                <h6><i class="fas fa-palette"></i> ความหมายของสี</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-2 bg-success text-white rounded">
                            <strong>สีเขียว</strong><br>ยอดคงเหลือเป็นบวก
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-2 bg-danger text-white rounded">
                            <strong>สีแดง</strong><br>ยอดคงเหลือเป็นลบ
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-2 bg-primary text-white rounded">
                            <strong>สีน้ำเงิน</strong><br>ยอดคงเหลือเท่ากับศูนย์
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ระบบแจ้งเตือน -->
        <div class="tab-pane fade" id="notifications">
            <div class="manual-section">
                <h2 class="section-title"><i class="fas fa-bell"></i> ระบบแจ้งเตือน</h2>

                <h4 class="subsection-title"><i class="fas fa-calendar-times"></i> การแจ้งเตือนเอกสารหมดอายุ</h4>
                
                <p>ระบบจะแจ้งเตือนล่วงหน้า <strong>15 วัน</strong> ก่อนเอกสารหมดอายุ โดยตรวจสอบทุกวันเวลา 00:00 น.</p>

                <div class="config-card">
                    <h6><i class="fas fa-cogs"></i> เงื่อนไขการคำนวณวันหมดอายุ</h6>
                    <table class="url-table">
                        <thead>
                            <tr>
                                <th>ประเภทเอกสาร</th>
                                <th>ฟิลด์ใน UI</th>
                                <th>สูตรการคำนวณ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>ใบรับรองแพทย์ (ผลโรค)</strong></td>
                                <td>"วันที่ตรวจโรค" (แท็บข้อมูลเพิ่มเติม)</td>
                                <td>วันที่ตรวจโรค + 30 วัน</td>
                            </tr>
                            <tr>
                                <td><strong>พาสปอร์ต</strong></td>
                                <td>"วันหมดอายุพาสปอร์ต" (แท็บข้อมูลส่วนตัว)</td>
                                <td>วันหมดอายุตามที่ระบุ</td>
                            </tr>
                            <tr>
                                <td><strong>CID</strong></td>
                                <td>"วันที่หมดอายุ CID" (แท็บข้อมูลเพิ่มเติม)</td>
                                <td>วันหมดอายุตามที่ระบุ</td>
                            </tr>
                            <tr>
                                <td><strong>Affidavit</strong></td>
                                <td>"วันหมดอายุ Affidavit" (แท็บข้อมูลเพิ่มเติม)</td>
                                <td>วันหมดอายุตามที่ระบุ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-heartbeat"></i> ใบรับรองแพทย์ (ผลโรค)</h6>
                        <div class="example-box">
                            <strong>เงื่อนไขการแจ้งเตือน:</strong><br>
                            1. ต้องมีข้อมูลในช่อง "วันที่ตรวจโรค"<br>
                            2. คำนวณ: วันที่ตรวจโรค + 30 วัน = วันหมดอายุ<br>
                            3. หาก (วันหมดอายุ - วันปัจจุบัน) ≤ 15 วัน = แจ้งเตือน<br><br>
                            
                            <strong>ตัวอย่าง:</strong><br>
                            วันที่ตรวจโรค: 15 ตุลาคม 2025<br>
                            วันหมดอายุ: 14 พฤศจิกายน 2025<br>
                            วันที่แจ้งเตือน: 30 ตุลาคม 2025 เป็นต้นไป
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-passport"></i> พาสปอร์ต</h6>
                        <div class="example-box">
                            <strong>เงื่อนไขการแจ้งเตือน:</strong><br>
                            1. ต้องมีข้อมูลในช่อง "วันหมดอายุพาสปอร์ต"<br>
                            2. ใช้วันหมดอายุตรงตามที่ระบุในพาสปอร์ต<br>
                            3. หาก (วันหมดอายุ - วันปัจจุบัน) ≤ 15 วัน = แจ้งเตือน<br><br>
                            
                            <strong>ตัวอย่าง:</strong><br>
                            วันหมดอายุพาสปอร์ต: 30 พฤศจิกายน 2025<br>
                            วันที่แจ้งเตือน: 15 พฤศจิกายน 2025 เป็นต้นไป
                        </div>
                    </div>
                </div>

                <h6><i class="fas fa-traffic-light"></i> ระดับความเร่งด่วนของการแจ้งเตือน</h6>
                
                <div class="config-card">
                    <h6>การคำนวณสีและระดับความเร่งด่วน</h6>
                    <p>ระบบจะคำนวณจำนวนวันที่เหลือก่อนหมดอายุ และแสดงสีตามระดับความเร่งด่วน:</p>
                    
                    <div class="terminal-box">
วันที่เหลือ = วันหมดอายุ - วันปัจจุบัน
                    </div>
                    
                    <table class="url-table">
                        <thead>
                            <tr>
                                <th>วันที่เหลือ</th>
                                <th>สีการแจ้งเตือน</th>
                                <th>ความหมาย</th>
                                <th>การดำเนินการที่แนะนำ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0-5 วัน</td>
                                <td><span class="badge-custom badge-red">สีแดง (Critical)</span></td>
                                <td>อันตราย! ต้องทำทันที</td>
                                <td>ดำเนินการภายในวันนี้</td>
                            </tr>
                            <tr>
                                <td>6-10 วัน</td>
                                <td><span class="badge-custom badge-yellow">สีส้ม (Warning)</span></td>
                                <td>เตือน! เริ่มเตรียมตัว</td>
                                <td>วางแผนและเริ่มดำเนินการ</td>
                            </tr>
                            <tr>
                                <td>11-15 วัน</td>
                                <td><span class="badge-custom badge-yellow">สีเหลือง (Info)</span></td>
                                <td>แจ้งให้ทราบล่วงหน้า</td>
                                <td>เตรียมความพร้อม</td>
                            </tr>
                            <tr>
                                <td>มากกว่า 15 วัน</td>
                                <td><span class="badge-custom badge-green">ไม่แจ้งเตือน</span></td>
                                <td>ยังไม่หมดอายุ</td>
                                <td>ติดตามตามปกติ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="example-box">
                    <strong>ตัวอย่างการคำนวณสี:</strong><br><br>
                    
                    <strong>วันปัจจุบัน:</strong> 13 พฤศจิกายน 2025<br><br>
                    
                    • เอกสารหมดอายุ 15 พฤศจิกายน 2025 → เหลือ 2 วัน → <span class="badge-custom badge-red">สีแดง</span><br>
                    • เอกสารหมดอายุ 20 พฤศจิกายน 2025 → เหลือ 7 วัน → <span class="badge-custom badge-yellow">สีส้ม</span><br>
                    • เอกสารหมดอายุ 25 พฤศจิกายน 2025 → เหลือ 12 วัน → <span class="badge-custom badge-yellow">สีเหลือง</span><br>
                    • เอกสารหมดอายุ 1 ธันวาคม 2025 → เหลือ 18 วัน → ไม่แจ้งเตือน
                </div>

                <h4 class="subsection-title"><i class="fas fa-money-check-alt"></i> การแจ้งเตือนเงินมัดจำค้างชำระ</h4>
                
                <div class="config-card">
                    <h6><i class="fas fa-search"></i> เงื่อนไขการตรวจสอบเงินมัดจำค้างชำระ</h6>
                    <p>ระบบจะแจ้งเตือนเมื่อแรงงานตรงตามเงื่อนไขทั้งหมดต่อไปนี้:</p>
                    
                    <table class="url-table">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>เงื่อนไข</th>
                                <th>ฟิลด์ที่ตรวจสอบ</th>
                                <th>เงื่อนไขใน SQL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>มีการบันทึกวันที่ยื่น CID</td>
                                <td>"วันที่ยื่น CID" (แท็บข้อมูลเพิ่มเติม)</td>
                                <td><code>IS NOT NULL</code></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>ผ่านไปแล้วมากกว่า 15 วัน</td>
                                <td>"วันที่ยื่น CID" (แท็บข้อมูลเพิ่มเติม)</td>
                                <td><code>DATEDIFF(CURDATE(), labour_cid_date) > 15</code></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>ยังไม่ได้บันทึกวันที่รับเงินมัดจำ</td>
                                <td>"วันที่วางเงินประกัน" (แท็บการเงิน)</td>
                                <td><code>IS NULL</code></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>หรือยังไม่ได้บันทึกจำนวนเงินมัดจำ</td>
                                <td>"จำนวนเงินประกัน" (แท็บการเงิน)</td>
                                <td><code>IS NULL OR = 0</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="warning-box">
                    <strong><i class="fas fa-calculator"></i> สูตรการคำนวณ:</strong><br>
                    <code>วันที่ผ่านไป = วันปัจจุบัน - วันยื่น CID</code><br>
                    <strong>เงื่อนไขแจ้งเตือน:</strong> วันที่ผ่านไป > 15 วัน และยังไม่ได้รับเงินมัดจำ
                </div>

                <div class="example-box">
                    <strong>ตัวอย่างการคำนวณ:</strong><br><br>
                    
                    <strong>กรณีที่ 1: ต้องแจ้งเตือน</strong><br>
                    • วันที่ยื่น CID: 1 พฤศจิกายน 2025<br>
                    • วันปัจจุบัน: 20 พฤศจิกายน 2025<br>
                    • วันที่ผ่านไป: 20 - 1 = 19 วัน (เกิน 15 วัน ✓)<br>
                    • วันที่วางเงินประกัน: ยังไม่ได้กรอก (NULL ✓)<br>
                    • จำนวนเงินประกัน: ยังไม่ได้กรอก (NULL ✓)<br>
                    <strong>ผลลัพธ์:</strong> <span class="badge-custom badge-red">แสดงแจ้งเตือน</span><br><br>
                    
                    <strong>กรณีที่ 2: ไม่ต้องแจ้งเตือน (รับเงินแล้ว)</strong><br>
                    • วันที่ยื่น CID: 1 พฤศจิกายน 2025<br>
                    • วันปัจจุบัน: 20 พฤศจิกายน 2025<br>
                    • วันที่ผ่านไป: 19 วัน (เกิน 15 วัน ✓)<br>
                    • วันที่วางเงินประกัน: 15 พฤศจิกายน 2025 (มีข้อมูล ✗)<br>
                    • จำนวนเงินประกัน: 50,000 บาท (มีข้อมูล ✗)<br>
                    <strong>ผลลัพธ์:</strong> <span class="badge-custom badge-green">ไม่แจ้งเตือน</span><br><br>
                    
                    <strong>กรณีที่ 3: ไม่ต้องแจ้งเตือน (ยังไม่ครบ 15 วัน)</strong><br>
                    • วันที่ยื่น CID: 10 พฤศจิกายน 2025<br>
                    • วันปัจจุบัน: 20 พฤศจิกายน 2025<br>
                    • วันที่ผ่านไป: 10 วัน (ยังไม่เกิน 15 วัน ✗)<br>
                    • วันรับเงินมัดจำ: NULL<br>
                    <strong>ผลลัพธ์:</strong> <span class="badge-custom badge-blue">ไม่แจ้งเตือน (รอให้ครบ 15 วัน)</span>
                </div>

                <h4 class="subsection-title"><i class="fas fa-key"></i> การขอสิทธิ์เข้าถึงระบบการเงิน</h4>
                
                <div class="config-card">
                    <h6><i class="fas fa-user-plus"></i> ขั้นตอนการขอสิทธิ์</h6>
                    <div class="step-card">
                        <h6><span class="step-number">1</span>ติดต่อผู้ดูแลระบบ</h6>
                        <p>ติดต่อ Admin หรือ IT เพื่อขอสิทธิ์เข้าถึงระบบการเงิน</p>
                    </div>
                    
                    <div class="step-card">
                        <h6><span class="step-number">2</span>ระบุประเภทสิทธิ์ที่ต้องการ</h6>
                        <ul>
                            <li><strong>finance-view:</strong> เพื่อดูข้อมูลการเงิน (สำหรับหัวหน้า หรือผู้ตรวจสอบ)</li>
                            <li><strong>finance-manage:</strong> เพื่อจัดการข้อมูลการเงิน (สำหรับเจ้าหน้าที่การเงิน)</li>
                        </ul>
                    </div>
                    
                    <div class="step-card">
                        <h6><span class="step-number">3</span>รอการอนุมัติ</h6>
                        <p>ผู้ดูแลระบบจะตรวจสอบและกำหนดสิทธิ์ตามตำแหน่งงานและความจำเป็น</p>
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-info-circle"></i>
                            <strong>ผู้ดูแลระบบ:</strong> คุณสามารถจัดการสิทธิ์ได้ที่เมนู <a href="{{ route('admin.roles-permissions.index') }}" target="_blank" class="alert-link">จัดการสิทธิ์</a>
                        </div>
                    </div>
                    
                    <div class="step-card">
                        <h6><span class="step-number">4</span>ทดสอบการเข้าใช้งาน</h6>
                        <p>เข้าสู่ระบบใหม่และตรวจสอบว่าแท็บการเงินแสดงในหน้าแก้ไขข้อมูลแรงงาน</p>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-mouse-pointer"></i> การใช้งานการแจ้งเตือน</h4>
                
                <div class="step-card">
                    <h6><span class="step-number">1</span>ดูการแจ้งเตือนในหน้า Dashboard</h6>
                    <div class="config-card">
                        <strong>การ์ดการแจ้งเตือนที่แสดง:</strong>
                        <ul>
                            <li><strong>ผลโรคหมดอายุ:</strong> ใบรับรองแพทย์จะหมดอายุใน 15 วันข้างหน้า</li>
                            <li><strong>พาสปอร์ตหมดอายุ:</strong> พาสปอร์ตจะหมดอายุใน 15 วันข้างหน้า</li>
                            <li><strong>CID หมดอายุ:</strong> CID จะหมดอายุใน 15 วันข้างหน้า</li>
                            <li><strong>Affidavit หมดอายุ:</strong> Affidavit จะหมดอายุใน 15 วันข้างหน้า</li>
                            <li><strong>เงินมัดจำค้างชำระ:</strong> ยื่น CID แล้วเกิน 15 วันแต่ยังไม่ได้รับเงิน</li>
                        </ul>
                        <strong>สีของตัวเลข:</strong> จำนวนที่แสดงจะมีสีตามระดับความเร่งด่วน
                    </div>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">2</span>คลิก "ดูรายละเอียด"</h6>
                    <div class="config-card">
                        <strong>ข้อมูลที่แสดง:</strong>
                        <ul>
                            <li>รายชื่อแรงงานที่ต้องดำเนินการ</li>
                            <li>วันที่หมดอายุหรือวันที่ค้างชำระ</li>
                            <li>จำนวนวันที่เหลือ (สำหรับเอกสาร)</li>
                            <li>จำนวนวันที่ค้างชำระ (สำหรับเงินมัดจำ)</li>
                            <li>สถานะปัจจุบันของแต่ละคน</li>
                        </ul>
                        <strong>การเรียงลำดับ:</strong> เรียงตามความเร่งด่วน (หมดอายุเร็วที่สุดก่อน)
                    </div>
                </div>
                
                <div class="step-card">
                    <h6><span class="step-number">3</span>ส่งออกรายงาน Excel</h6>
                    <div class="config-card">
                        <strong>ไฟล์ที่ได้:</strong>
                        <ul>
                            <li>รายชื่อแรงงานที่ต้องดำเนินการทั้งหมด</li>
                            <li>ข้อมูลการติดต่อ (เบอร์โทร, ที่อยู่)</li>
                            <li>วันที่หมดอายุและจำนวนวันที่เหลือ</li>
                            <li>ข้อมูลลูกค้าและเจ้าหน้าที่รับผิดชอบ</li>
                        </ul>
                        <strong>รูปแบบไฟล์:</strong> Excel (.xlsx) พร้อมการจัดรูปแบบและสีตามระดับ
                    </div>
                </div>

                <h6><i class="fas fa-link"></i> ลิงก์การเข้าถึงและ SQL Query</h6>
                <table class="url-table">
                    <thead>
                        <tr>
                            <th>ประเภทการแจ้งเตือน</th>
                            <th>URL รายละเอียด</th>
                            <th>เงื่อนไขการค้นหา (SQL)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>ผลโรคหมดอายุ</strong></td>
                            <td><code>/dashboard/notification-details?type=disease_expiring</code></td>
                            <td>
                                <code>DATE_ADD(labour_disease_issue_date, INTERVAL 30 DAY)<br>
                                BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)</code>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>พาสปอร์ตหมดอายุ</strong></td>
                            <td><code>/dashboard/notification-details?type=passport_expiring</code></td>
                            <td>
                                <code>labour_passport_expiry_date<br>
                                BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)</code>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>CID หมดอายุ</strong></td>
                            <td><code>/dashboard/notification-details?type=cid_expiring</code></td>
                            <td>
                                <code>labour_cid_exp<br>
                                BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)</code>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Affidavit หมดอายุ</strong></td>
                            <td><code>/dashboard/notification-details?type=affidavit_expiring</code></td>
                            <td>
                                <code>labour_affidavit_exp<br>
                                BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)</code>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>เงินมัดจำค้างชำระ</strong></td>
                            <td><code>/dashboard/notification-details?type=unpaid_deposits</code></td>
                            <td>
                                <code>labour_cid_date IS NOT NULL<br>
                                AND DATEDIFF(CURDATE(), labour_cid_date) > 15<br>
                                AND (labour_cid_deposit_date IS NULL<br>
                                OR labour_cid_deposit_total IS NULL OR labour_cid_deposit_total = 0)</code>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="success-box">
                    <strong><i class="fas fa-info-circle"></i> หมายเหตุสำคัญ:</strong>
                    <ul>
                        <li><strong>CURDATE():</strong> วันปัจจุบันของระบบ</li>
                        <li><strong>DATE_ADD(CURDATE(), INTERVAL 15 DAY):</strong> วันปัจจุบัน + 15 วัน</li>
                        <li><strong>DATEDIFF(วันที่1, วันที่2):</strong> คำนวณจำนวนวันระหว่างสองวันที่</li>
                        <li><strong>BETWEEN:</strong> ค้นหาข้อมูลที่อยู่ในช่วงวันที่ที่กำหนด</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- แก้ไขปัญหา -->
        <div class="tab-pane fade" id="troubleshooting">
            <div class="manual-section">
                <h2 class="section-title"><i class="fas fa-tools"></i> การแก้ไขปัญหาที่พบบ่อย</h2>

                <h4 class="subsection-title"><i class="fas fa-question-circle"></i> ปัญหาเกี่ยวกับการเงิน</h4>
                
                <div class="step-card">
                    <h6><i class="fas fa-eye-slash"></i> แท็บการเงินไม่แสดง</h6>
                    <p><strong>สาเหตุ:</strong> ไม่มีสิทธิ์เข้าถึงระบบการเงิน</p>
                    <p><strong>วิธีแก้:</strong> ติดต่อ Admin เพื่อขอเพิ่มสิทธิ์ <code>account-update-labour</code></p>
                </div>
                
                <div class="step-card">
                    <h6><i class="fas fa-calculator"></i> การคำนวณยอดคงเหลือผิดพลาด</h6>
                    <p><strong>สาเหตุ:</strong> ข้อมูลตัวเลขผิดรูปแบบ</p>
                    <p><strong>วิธีแก้:</strong></p>
                    <ul>
                        <li>ใส่เฉพาะตัวเลขและจุดทศนิยม</li>
                        <li>ไม่ใส่เครื่องหมายคอมมา (,) หรืออักขระพิเศษ</li>
                        <li>รีเฟรชหน้าและใส่ข้อมูลใหม่</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-upload"></i> ปัญหาการอัปโหลดไฟล์</h4>
                
                <div class="step-card">
                    <h6><i class="fas fa-file-times"></i> อัปโหลดไฟล์ไม่ได้</h6>
                    <p><strong>สาเหตุที่เป็นไปได้:</strong></p>
                    <ul>
                        <li>ไฟล์ใหญ่เกิน 2MB</li>
                        <li>ประเภทไฟล์ไม่รองรับ</li>
                        <li>ยังไม่ได้บันทึกข้อมูลแรงงาน</li>
                    </ul>
                    <p><strong>วิธีแก้:</strong></p>
                    <ul>
                        <li>ลดขนาดไฟล์ให้เหลือไม่เกิน 2MB</li>
                        <li>ใช้ไฟล์ประเภท PDF, JPG, PNG เท่านั้น</li>
                        <li>บันทึกข้อมูลแรงงานก่อนอัปโหลดไฟล์</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-bell-slash"></i> ปัญหาการแจ้งเตือน</h4>
                
                <div class="step-card">
                    <h6><i class="fas fa-calendar-times"></i> การแจ้งเตือนไม่ทำงาน</h6>
                    <p><strong>สาเหตุ:</strong> ข้อมูลวันที่ไม่ครบถ้วน</p>
                    <p><strong>วิธีแก้:</strong></p>
                    <ul>
                        <li>ตรวจสอบข้อมูลวันหมดอายุของเอกสาร</li>
                        <li>ตรวจสอบวันที่ยื่น CID สำหรับการแจ้งเตือนการเงิน</li>
                        <li>รีเฟรชหน้า Dashboard</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-keyboard"></i> ปัญหาการกรอกข้อมูล</h4>
                
                <div class="step-card">
                    <h6><i class="fas fa-id-card"></i> เลขบัตรประชาชนซ้ำ</h6>
                    <p><strong>เมื่อเห็นข้อความ:</strong> "เลขบัตรประชาชนนี้มีอยู่ในระบบแล้ว"</p>
                    <p><strong>วิธีแก้:</strong></p>
                    <ul>
                        <li>ตรวจสอบเลขบัตรอีกครั้งให้แน่ใจ</li>
                        <li>ค้นหาข้อมูลเดิมในระบบ</li>
                        <li>หากแน่ใจว่าถูกต้อง ติดต่อ Admin ตรวจสอบ</li>
                    </ul>
                </div>

                <h4 class="subsection-title"><i class="fas fa-phone-alt"></i> การติดต่อขอความช่วยเหลือ</h4>
                
                <div class="success-box">
                    <h6><i class="fas fa-info-circle"></i> ข้อมูลที่ควรเตรียมเมื่อแจ้งปัญหา:</h6>
                    <ul>
                        <li>ชื่อผู้ใช้งาน</li>
                        <li>เวลาที่เกิดปัญหา</li>
                        <li>หน้าที่เกิดปัญหา</li>
                        <li>ข้อความ Error (ถ่ายภาพหน้าจอ)</li>
                        <li>ขั้นตอนที่ทำก่อนเกิดปัญหา</li>
                    </ul>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="step-card">
                            <h6><i class="fas fa-cog"></i> ฝ่าย IT</h6>
                            <p>สำหรับปัญหาเทคนิค การอัปโหลดไฟล์ ระบบล่ม</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="step-card">
                            <h6><i class="fas fa-calculator"></i> ฝ่ายการเงิน</h6>
                            <p>สำหรับปัญหาเกี่ยวกับระบบการเงิน การคำนวณ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// เพิ่ม smooth scrolling และ highlight active sections
document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll to top when switching tabs
    var tabTriggers = document.querySelectorAll('#manualTabs button');
    tabTriggers.forEach(function(tab) {
        tab.addEventListener('click', function() {
            setTimeout(function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        });
    });
    
    // Add copy-to-clipboard functionality for code blocks
    var codeBlocks = document.querySelectorAll('.code-block');
    codeBlocks.forEach(function(block) {
        block.style.position = 'relative';
        block.style.cursor = 'pointer';
        block.title = 'คลิกเพื่อคัดลอก';
        
        block.addEventListener('click', function() {
            navigator.clipboard.writeText(block.textContent).then(function() {
                // Show temporary success message
                var originalText = block.innerHTML;
                block.innerHTML = '<i class="fas fa-check"></i> คัดลอกแล้ว!';
                block.style.backgroundColor = '#48bb78';
                
                setTimeout(function() {
                    block.innerHTML = originalText;
                    block.style.backgroundColor = '#2d3748';
                }, 1000);
            });
        });
    });
    
    // Add tooltips to badges
    var badges = document.querySelectorAll('.badge-custom');
    badges.forEach(function(badge) {
        badge.title = 'สิทธิ์: ' + badge.textContent;
    });
    
    // Highlight external links
    var links = document.querySelectorAll('a[href^="http"]');
    links.forEach(function(link) {
        link.innerHTML += ' <i class="fas fa-external-link-alt"></i>';
        link.target = '_blank';
    });
});

// Add print functionality
function printManual() {
    window.print();
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        var searchBox = document.createElement('input');
        searchBox.type = 'text';
        searchBox.placeholder = 'ค้นหาในคู่มือ...';
        searchBox.style.position = 'fixed';
        searchBox.style.top = '20px';
        searchBox.style.right = '20px';
        searchBox.style.zIndex = '9999';
        searchBox.style.padding = '10px';
        searchBox.style.borderRadius = '5px';
        searchBox.style.border = '2px solid #667eea';
        
        document.body.appendChild(searchBox);
        searchBox.focus();
        
        searchBox.addEventListener('blur', function() {
            document.body.removeChild(searchBox);
        });
    }
});
</script>
@endsection