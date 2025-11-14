@extends('layouts.template')

@section('content')
<style>
    .overview-container {
        max-width: 1200px;
        margin: 0 auto;
        font-family: 'Inter', 'Prompt', 'Sarabun', sans-serif;
    }
    
    .overview-header {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .overview-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
        opacity: 0.3;
    }
    
    .overview-header > * {
        position: relative;
        z-index: 1;
    }
    
    .overview-nav {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: sticky;
        top: 20px;
        z-index: 100;
    }
    
    .overview-nav .nav-pills .nav-link {
        border-radius: 8px;
        margin: 0 5px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .overview-nav .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    }
    
    .overview-nav .nav-pills .nav-link:hover {
        border-color: #4299e1;
    }
    
    .overview-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #2d3748;
        border-bottom: 3px solid #4299e1;
        padding-bottom: 10px;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    
    .subsection-title {
        color: #4a5568;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #ebf8ff;
        border-left: 4px solid #4299e1;
        border-radius: 5px;
        font-weight: 600;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }
    
    .stat-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4299e1, #3182ce, #2b77cb);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover::before {
        transform: scaleX(1);
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(66, 153, 225, 0.15);
    }
    
    .stat-icon {
        font-size: 3rem;
        color: #4299e1;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.1);
        color: #3182ce;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #718096;
        font-weight: 500;
    }
    
    .feature-showcase {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }
    
    .feature-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .feature-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .feature-icon {
        font-size: 2rem;
        color: #4299e1;
        margin-right: 1rem;
        width: 50px;
        text-align: center;
    }
    
    .feature-title {
        font-weight: 600;
        color: #2d3748;
        margin: 0;
    }
    
    .feature-description {
        color: #718096;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
    }
    
    .feature-list li {
        padding: 0.5rem 0;
        color: #4a5568;
        position: relative;
        padding-left: 1.5rem;
    }
    
    .feature-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #48bb78;
        font-weight: bold;
    }
    
    .tech-stack {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }
    
    .tech-item {
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .tech-item:hover {
        background: #4299e1;
        color: white;
        transform: translateY(-2px);
    }
    
    .tech-logo {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .workflow-step {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #4299e1;
    }
    
    .step-number {
        background: #4299e1;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }
    
    .step-content h6 {
        margin: 0 0 0.5rem 0;
        color: #2d3748;
        font-weight: 600;
    }
    
    .step-content p {
        margin: 0;
        color: #4a5568;
    }
    
    .system-architecture {
        background: #f7fafc;
        border-radius: 12px;
        padding: 2rem;
        margin: 2rem 0;
    }
    
    .architecture-layer {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
        position: relative;
    }
    
    .layer-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    
    .layer-icon {
        color: #4299e1;
        margin-right: 0.5rem;
    }
    
    .component-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .component-tag {
        background: #ebf8ff;
        color: #2b77cb;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        border: 1px solid #bee3f8;
    }
    
    .roadmap-item {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1.5rem;
        margin: 1rem 0;
        position: relative;
        padding-left: 3rem;
    }
    
    .roadmap-item::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 1.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #4299e1;
    }
    
    .roadmap-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .status-completed {
        background: #c6f6d5;
        color: #22543d;
    }
    
    .status-inprogress {
        background: #fef5e7;
        color: #744210;
    }
    
    .status-planned {
        background: #e6fffa;
        color: #234e52;
    }
    
    @media (max-width: 768px) {
        .overview-nav {
            position: static;
        }
        
        .stats-grid,
        .feature-showcase,
        .tech-stack {
            grid-template-columns: 1fr;
        }
        
        .workflow-step {
            flex-direction: column;
            text-align: center;
        }
        
        .step-number {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>

<div class="overview-container">
    <!-- Header -->
    <div class="overview-header">
        <h1><i class="fas fa-chart-line"></i> ภาพรวมระบบบริหารจัดการแรงงาน</h1>
        <p class="lead mb-2">Labour Management System Overview</p>
        <small>ระบบจัดการข้อมูลแรงงานต่างชาติแบบครบวงจร | เวอร์ชัน 2.1.0</small>
    </div>

    <!-- Navigation -->
    <div class="overview-nav">
        <ul class="nav nav-pills justify-content-center" id="overviewTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="introduction-tab" data-bs-toggle="pill" data-bs-target="#introduction">
                    <i class="fas fa-home"></i> บทนำ
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="statistics-tab" data-bs-toggle="pill" data-bs-target="#statistics">
                    <i class="fas fa-chart-bar"></i> สถิติระบบ
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="features-tab" data-bs-toggle="pill" data-bs-target="#features">
                    <i class="fas fa-star"></i> คุณสมบัติ
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="workflow-tab" data-bs-toggle="pill" data-bs-target="#workflow">
                    <i class="fas fa-project-diagram"></i> ขั้นตอนการทำงาน
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="architecture-tab" data-bs-toggle="pill" data-bs-target="#architecture">
                    <i class="fas fa-sitemap"></i> สถาปัตยกรรม
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="roadmap-tab" data-bs-toggle="pill" data-bs-target="#roadmap">
                    <i class="fas fa-road"></i> แผนงาน
                </button>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="tab-content" id="overviewContent">
        <!-- บทนำ -->
        <div class="tab-pane fade show active" id="introduction">
            <div class="overview-section">
                <h2 class="section-title"><i class="fas fa-info-circle"></i> บทนำ</h2>
                
                <div class="row">
                    <div class="col-lg-8">
                        <p class="lead">ระบบบริหารจัดการแรงงานต่างชาติ เป็นเว็บแอปพลิเคชันที่พัฒนาขึ้นเพื่อช่วยให้การจัดการข้อมูลแรงงาน การเงิน และเอกสารต่างๆ เป็นไปอย่างมีประสิทธิภาพและเป็นระบบ</p>
                        
                        <h4 class="subsection-title"><i class="fas fa-bullseye"></i> วัตถุประสงค์หลัก</h4>
                        <ul>
                            <li><strong>ลดข้อผิดพลาด:</strong> ลดการกรอกข้อมูลซ้ำและข้อผิดพลาดจากการทำงานด้วยกระดาษ</li>
                            <li><strong>เพิ่มประสิทธิภาพ:</strong> เร่งความเร็วในการค้นหาและจัดการข้อมูล</li>
                            <li><strong>ติดตามแบบเรียลไทม์:</strong> ดูสถานะและความคืบหน้าของแต่ละแรงงานได้ทันที</li>
                            <li><strong>การเงินโปร่งใส:</strong> ติดตามเงินมัดจำและการเงินต่างๆ อย่างครบถ้วน</li>
                            <li><strong>แจ้งเตือนอัตโนมัติ:</strong> ไม่พลาดกำหนดสำคัญต่างๆ</li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <div class="tech-stack">
                            <div class="tech-item">
                                <div class="tech-logo">🚀</div>
                                <strong>Laravel 10</strong>
                                <div>PHP Framework</div>
                            </div>
                            <div class="tech-item">
                                <div class="tech-logo">🎨</div>
                                <strong>Bootstrap 5</strong>
                                <div>Frontend UI</div>
                            </div>
                            <div class="tech-item">
                                <div class="tech-logo">🗄️</div>
                                <strong>MySQL 8</strong>
                                <div>Database</div>
                            </div>
                            <div class="tech-item">
                                <div class="tech-logo">🔒</div>
                                <strong>Spatie</strong>
                                <div>Permission System</div>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-users"></i> กลุ่มเป้าหมาย</h4>
                
                <div class="feature-showcase">
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
                            <h5 class="feature-title">เจ้าหน้าที่สรรหา</h5>
                        </div>
                        <div class="feature-description">
                            จัดการข้อมูลแรงงานตั้งแต่การสมัคร ทดสอบฝีมือ จนถึงการส่งออกไปต่างประเทศ
                        </div>
                        <ul class="feature-list">
                            <li>บันทึกข้อมูลแรงงานใหม่</li>
                            <li>อัปโลดเอกสารประกอบ</li>
                            <li>ติดตามสถานะการดำเนินงาน</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-calculator"></i></div>
                            <h5 class="feature-title">เจ้าหน้าที่การเงิน</h5>
                        </div>
                        <div class="feature-description">
                            ดูแลเรื่องเงินมัดจำ การชำระเงิน และการคืนเงินของแรงงานแต่ละคน
                        </div>
                        <ul class="feature-list">
                            <li>บันทึกเงินมัดจำ CID</li>
                            <li>จัดการเงิน CID-P</li>
                            <li>ติดตามเงินคืนแรงงาน</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-user-shield"></i></div>
                            <h5 class="feature-title">ผู้บริหาร</h5>
                        </div>
                        <div class="feature-description">
                            ดูสถิติและรายงานต่างๆ เพื่อใช้ในการวางแผนและตัดสินใจ
                        </div>
                        <ul class="feature-list">
                            <li>ดูแดชบอร์ดสรุปผล</li>
                            <li>ส่งออกรายงาน Excel</li>
                            <li>ติดตามการแจ้งเตือน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- สถิติระบบ -->
        <div class="tab-pane fade" id="statistics">
            <div class="overview-section">
                <h2 class="section-title"><i class="fas fa-chart-bar"></i> สถิติการใช้งานระบบ</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-number">{{ \App\Models\labours\labourModel::count() ?? '---' }}</div>
                        <div class="stat-label">แรงงานทั้งหมด</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                        <div class="stat-number">{{ \App\Models\labours\labourModel::where('labour_visa_status', 'ไปทำงานแล้ว')->count() ?? '---' }}</div>
                        <div class="stat-label">ไปทำงานแล้ว</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-user-times"></i></div>
                        <div class="stat-number">{{ \App\Models\labours\labourModel::where('labour_visa_status', 'ยกเลิก')->count() ?? '---' }}</div>
                        <div class="stat-label">ยกเลิก</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="stat-number">{{ \App\Models\labours\labourModel::whereNotNull('labour_passport_number')->count() ?? '---' }}</div>
                        <div class="stat-label">มีพาสปอร์ต</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="stat-number">{{ \App\Models\labours\labourModel::whereNotNull('labour_cid_deposit_date')->count() ?? '---' }}</div>
                        <div class="stat-label">จ่ายมัดจำแล้ว</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-bell"></i></div>
                        <div class="stat-number">
                            @php
                                $expiring = \App\Models\labours\labourModel::where(function($query) {
                                    $query->whereRaw('DATE_ADD(labour_disease_issue_date, INTERVAL 30 DAY) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)')
                                          ->orWhereRaw('labour_passport_expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 15 DAY)');
                                })->count();
                                echo $expiring ?? '---';
                            @endphp
                        </div>
                        <div class="stat-label">การแจ้งเตือน</div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-globe-asia"></i> สถิติตามประเทศ</h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="countryChart" width="400" height="300"></canvas>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-grid">
                            @php
                                $countries = \App\Models\labours\labourModel::select('country_id', \DB::raw('count(*) as total'))
                                    ->where('country_id', '!=', null)
                                    ->groupBy('country_id')
                                    ->orderBy('total', 'desc')
                                    ->limit(4)
                                    ->get();
                            @endphp
                            
                            @foreach($countries ?? [] as $country)
                            <div class="stat-card">
                                <div class="stat-icon">
                                    @php
                                        $countryFlag = [
                                            1 => '🇲🇲',  // Myanmar
                                            2 => '🇰🇭',  // Cambodia
                                            3 => '🇱🇦',  // Laos
                                        ];
                                    @endphp
                                    {{ $countryFlag[$country->country_id] ?? '🌍' }}
                                </div>
                                <div class="stat-number">{{ $country->total }}</div>
                                <div class="stat-label">
                                    @switch($country->country_id)
                                        @case(1) Myanmar @break
                                        @case(2) Cambodia @break
                                        @case(3) Laos @break
                                        @default Unknown
                                    @endswitch
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-calendar-alt"></i> สถิติรายเดือน</h4>
                
                <canvas id="monthlyChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- คุณสมบัติ -->
        <div class="tab-pane fade" id="features">
            <div class="overview-section">
                <h2 class="section-title"><i class="fas fa-star"></i> คุณสมบัติของระบบ</h2>
                
                <div class="feature-showcase">
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-users"></i></div>
                            <h5 class="feature-title">การจัดการข้อมูลแรงงาน</h5>
                        </div>
                        <div class="feature-description">
                            ระบบจัดการข้อมูลส่วนตัว ประวัติ และเอกสารของแรงงานอย่างครบครัน
                        </div>
                        <ul class="feature-list">
                            <li>บันทึกข้อมูลส่วนตัวครบถ้วน</li>
                            <li>อัปโลดและจัดเก็บเอกสาร</li>
                            <li>ติดตามสถานะ VISA</li>
                            <li>ระบบค้นหาที่ทรงพลัง</li>
                            <li>การคำนวณ BMI อัตโนมัติ</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-calculator"></i></div>
                            <h5 class="feature-title">ระบบการเงินและบัญชี</h5>
                        </div>
                        <div class="feature-description">
                            จัดการเงินมัดจำ การชำระเงิน และการคืนเงินแบบเรียลไทม์
                        </div>
                        <ul class="feature-list">
                            <li>บันทึกเงินมัดจำ CID</li>
                            <li>จัดการเงิน CID-P ขาออก/ขาเข้า</li>
                            <li>การคืนเงินมัดจำ</li>
                            <li>การคำนวณยอดคงเหลือ</li>
                            <li>รองรับหลายช่องทางการชำระ</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-bell"></i></div>
                            <h5 class="feature-title">ระบบแจ้งเตือนอัตโนมัติ</h5>
                        </div>
                        <div class="feature-description">
                            แจ้งเตือนกำหนดสำคัญต่างๆ เพื่อไม่ให้พลาดการทำงาน
                        </div>
                        <ul class="feature-list">
                            <li>เอกสารหมดอายุ (15 วันล่วงหน้า)</li>
                            <li>เงินมัดจำค้างชำระ</li>
                            <li>ผลตรวจโรคหมดอายุ</li>
                            <li>พาสปอร์ตหมดอายุ</li>
                            <li>การแจ้งเตือนแบบสี</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                            <h5 class="feature-title">ระบบสิทธิ์ผู้ใช้</h5>
                        </div>
                        <div class="feature-description">
                            จัดการสิทธิ์การเข้าถึงข้อมูลตามบทบาทของผู้ใช้
                        </div>
                        <ul class="feature-list">
                            <li>สิทธิ์แบบ Role-Based</li>
                            <li>ควบคุมการเข้าถึงระบบการเงิน</li>
                            <li>ป้องกันการแก้ไขข้อมูลโดยไม่ได้รับอนุญาต</li>
                            <li>ระบบ Login ที่ปลอดภัย</li>
                            <li>Session Management</li>
                        </ul>
                        <p style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #ddd;">
                            <a href="{{ route('admin.roles-permissions.index') }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-cog"></i> จัดการสิทธิ์
                            </a>
                        </p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                            <h5 class="feature-title">รายงานและสถิติ</h5>
                        </div>
                        <div class="feature-description">
                            สร้างรายงานและดูสถิติในรูปแบบที่เข้าใจง่าย
                        </div>
                        <ul class="feature-list">
                            <li>แดชบอร์ดแสดงภาพรวม</li>
                            <li>ส่งออกรายงาน Excel</li>
                            <li>กราฟและชาร์ตสถิติ</li>
                            <li>รายงานการเงิน</li>
                            <li>รายงานการแจ้งเตือน</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                            <h5 class="feature-title">Responsive Design</h5>
                        </div>
                        <div class="feature-description">
                            ใช้งานได้ทุกอุปกรณ์ ทั้งคอมพิวเตอร์ แท็บเล็ต และมือถือ
                        </div>
                        <ul class="feature-list">
                            <li>รองรับทุกขนาดหน้าจอ</li>
                            <li>ใช้งานง่ายบนมือถือ</li>
                            <li>เร็วและเสียรคาย</li>
                            <li>ประหยัดอินเทอร์เน็ต</li>
                            <li>ทำงานได้แม้เน็ตช้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- ขั้นตอนการทำงาน -->
        <div class="tab-pane fade" id="workflow">
            <div class="overview-section">
                <h2 class="section-title"><i class="fas fa-project-diagram"></i> ขั้นตอนการทำงาน</h2>
                
                <h4 class="subsection-title"><i class="fas fa-user-plus"></i> ขั้นตอนการเพิ่มแรงงานใหม่</h4>
                
                <div class="workflow-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h6>บันทึกข้อมูลส่วนตัว</h6>
                        <p>กรอกข้อมูลพื้นฐานของแรงงาน เช่น ชื่อ-นามสกุล เลขบัตร วันเกิด ที่อยู่</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h6>ระบุเจ้าหน้าที่และบริษัท</h6>
                        <p>กำหนดเจ้าหน้าที่สรรหาและบริษัทลูกค้าที่จะรับแรงงาน</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h6>ทดสอบฝีมือ</h6>
                        <p>บันทึกวันที่ สถานที่ และผลการทดสอบฝีมือของแรงงาน</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h6>อัปโลดเอกสาร</h6>
                        <p>อัปโลดไฟล์เอกสารที่จำเป็น เช่น สำเนาบัตร รูปถ่าย ใบรับรองแพทย์</p>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-money-bill-wave"></i> ขั้นตอนการจัดการการเงิน</h4>
                
                <div class="workflow-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h6>บันทึกวันยื่น CID</h6>
                        <p>บันทึกวันที่นำเอกสารไปยื่นขอ CID ที่กรมแรงงาน</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h6>รอการแจ้งเตือน</h6>
                        <p>ระบบจะแจ้งเตือนหลังครบ 15 วัน หากยังไม่ได้รับเงินมัดจำ</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h6>บันทึกเงินมัดจำ</h6>
                        <p>เมื่อได้รับเงินมัดจำจากลูกค้า ให้บันทึกวันที่และจำนวนเงิน</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h6>จัดการ CID-P</h6>
                        <p>บันทึกเงิน CID-P ที่จ่ายออกและเงินที่ได้รับกลับคืน</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h6>คืนเงินมัดจำ</h6>
                        <p>หากมีการยกเลิกหรือคืนเงิน ให้บันทึกวันที่และจำนวนเงินคืน</p>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-bell"></i> ขั้นตอนการจัดการการแจ้งเตือน</h4>
                
                <div class="workflow-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h6>ตรวจสอบ Dashboard</h6>
                        <p>เข้าหน้า Dashboard เพื่อดูการแจ้งเตือนที่สำคัญ</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h6>คลิกดูรายละเอียด</h6>
                        <p>คลิกที่การแจ้งเตือนเพื่อดูรายชื่อแรงงานที่ต้องดำเนินการ</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h6>ดำเนินการแก้ไข</h6>
                        <p>ไปยังหน้าแก้ไขข้อมูลแรงงานและทำการอัปเดตข้อมูล</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h6>ส่งออกรายงาน</h6>
                        <p>ส่งออกรายงาน Excel เพื่อใช้ในการติดตามและรายงานต่อ</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- สถาปัตยกรรมระบบ -->
        <div class="tab-pane fade" id="architecture">
            <div class="overview-section">
                <h2 class="section-title"><i class="fas fa-sitemap"></i> สถาปัตยกรรมระบบ</h2>
                
                <div class="system-architecture">
                    <div class="architecture-layer">
                        <div class="layer-title">
                            <i class="fas fa-desktop layer-icon"></i>
                            Presentation Layer (Frontend)
                        </div>
                        <div class="component-list">
                            <span class="component-tag">Bootstrap 5</span>
                            <span class="component-tag">Blade Templates</span>
                            <span class="component-tag">JavaScript</span>
                            <span class="component-tag">CSS3</span>
                            <span class="component-tag">Responsive Design</span>
                        </div>
                    </div>
                    
                    <div class="architecture-layer">
                        <div class="layer-title">
                            <i class="fas fa-cogs layer-icon"></i>
                            Application Layer (Backend)
                        </div>
                        <div class="component-list">
                            <span class="component-tag">Laravel 10</span>
                            <span class="component-tag">PHP 8.1+</span>
                            <span class="component-tag">Eloquent ORM</span>
                            <span class="component-tag">Middleware</span>
                            <span class="component-tag">Service Classes</span>
                        </div>
                    </div>
                    
                    <div class="architecture-layer">
                        <div class="layer-title">
                            <i class="fas fa-shield-alt layer-icon"></i>
                            Security Layer
                        </div>
                        <div class="component-list">
                            <span class="component-tag">Spatie Permissions</span>
                            <span class="component-tag">Laravel Sanctum</span>
                            <span class="component-tag">CSRF Protection</span>
                            <span class="component-tag">Input Validation</span>
                            <span class="component-tag">File Upload Security</span>
                        </div>
                    </div>
                    
                    <div class="architecture-layer">
                        <div class="layer-title">
                            <i class="fas fa-database layer-icon"></i>
                            Data Layer
                        </div>
                        <div class="component-list">
                            <span class="component-tag">MySQL 8.0</span>
                            <span class="component-tag">Migration System</span>
                            <span class="component-tag">Model Relationships</span>
                            <span class="component-tag">Query Optimization</span>
                            <span class="component-tag">Backup Strategy</span>
                        </div>
                    </div>
                    
                    <div class="architecture-layer">
                        <div class="layer-title">
                            <i class="fas fa-server layer-icon"></i>
                            Infrastructure Layer
                        </div>
                        <div class="component-list">
                            <span class="component-tag">Apache/Nginx</span>
                            <span class="component-tag">Linux/Windows Server</span>
                            <span class="component-tag">SSL/TLS</span>
                            <span class="component-tag">File Storage</span>
                            <span class="component-tag">Logging System</span>
                        </div>
                    </div>
                </div>

                <h4 class="subsection-title"><i class="fas fa-flow-chart"></i> Data Flow</h4>
                
                <div class="workflow-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h6>User Request</h6>
                        <p>ผู้ใช้ส่งคำขอผ่าน Web Browser ไปยัง Web Server</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h6>Route & Middleware</h6>
                        <p>Laravel Router จัดการ URL และ Middleware ตรวจสอบสิทธิ์</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h6>Controller & Service</h6>
                        <p>Controller ประมวลผล Logic และเรียกใช้ Service Classes</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h6>Model & Database</h6>
                        <p>Eloquent Model ติดต่อกับฐานข้อมูล MySQL</p>
                    </div>
                </div>
                
                <div class="workflow-step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h6>View & Response</h6>
                        <p>Blade Template สร้าง HTML และส่งกลับไปยัง Browser</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- แผนงาน -->
        <div class="tab-pane fade" id="roadmap">
            <div class="overview-section">
                <h2 class="section-title"><i class="fas fa-road"></i> แผนการพัฒนา</h2>
                
                <h4 class="subsection-title"><i class="fas fa-check-circle"></i> เวอร์ชัน 2.1 (ปัจจุบัน)</h4>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-completed">Completed</div>
                    <h6>ระบบการเงินและบัญชี</h6>
                    <p>เพิ่มการจัดการเงินมัดจำ CID, CID-P และการคืนเงิน พร้อมการคำนวณยอดคงเหลือแบบเรียลไทม์</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-completed">Completed</div>
                    <h6>ระบบแจ้งเตือนอัตโนมัติ</h6>
                    <p>การแจ้งเตือนเอกสารหมดอายุและเงินค้างชำระหลัง 15 วัน</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-completed">Completed</div>
                    <h6>คู่มือออนไลน์</h6>
                    <p>เอกสารคู่มือการใช้งานแบบ Interactive ที่เข้าถึงได้ผ่านเว็บแอป</p>
                </div>

                <h4 class="subsection-title"><i class="fas fa-tools"></i> เวอร์ชัน 2.2 (ในการพัฒนา)</h4>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-inprogress">In Progress</div>
                    <h6>ระบบจัดการลูกค้า (CRM)</h6>
                    <p>เพิ่มระบบจัดการข้อมูลลูกค้า ประวัติการติดต่อ และการติดตามงาน</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-inprogress">In Progress</div>
                    <h6>API สำหรับ Mobile App</h6>
                    <p>พัฒนา RESTful API เพื่อรองรับการทำแอปมือถือในอนาคต</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Planned</div>
                    <h6>ระบบ Workflow Automation</h6>
                    <p>ระบบอนุมัติและ Workflow แบบอัตโนมัติสำหรับขั้นตอนต่างๆ</p>
                </div>

                <h4 class="subsection-title"><i class="fas fa-rocket"></i> เวอร์ชัน 3.0 (แผนอนาคต)</h4>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Planned</div>
                    <h6>Dashboard Analytics</h6>
                    <p>กราฟและชาร์ตแบบ Interactive พร้อม Business Intelligence</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Planned</div>
                    <h6>Multi-language Support</h6>
                    <p>รองรับภาษาอังกฤษและภาษาของประเทศแรงงาน (พม่า, เขมร, ลาว)</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Planned</div>
                    <h6>Cloud Integration</h6>
                    <p>รองรับการจัดเก็บไฟล์บน Cloud Storage และ Backup อัตโนมัติ</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Planned</div>
                    <h6>AI-Powered Features</h6>
                    <p>ระบบแนะนำและการวิเคราะห์ข้อมูลด้วย Machine Learning</p>
                </div>

                <h4 class="subsection-title"><i class="fas fa-lightbulb"></i> คำขอปรับปรุงจากผู้ใช้</h4>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Under Review</div>
                    <h6>ระบบการพิมพ์รายงาน</h6>
                    <p>สร้างรายงานในรูปแบบ PDF ที่สวยงามพร้อมลายเซ็นดิจิทัล</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Under Review</div>
                    <h6>ระบบแชท/สื่อสาร</h6>
                    <p>ระบบสื่อสารภายในองค์กรและการแจ้งเตือนแบบ Real-time</p>
                </div>
                
                <div class="roadmap-item">
                    <div class="roadmap-status status-planned">Under Review</div>
                    <h6>ระบบ Inventory Management</h6>
                    <p>จัดการสินค้าและอุปกรณ์ที่ใช้ในการทำงาน</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll to top when switching tabs
    var overviewTabs = document.querySelectorAll('#overviewTabs button');
    overviewTabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            setTimeout(function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        });
    });
    
    // Initialize Charts when Statistics tab is active
    document.getElementById('statistics-tab').addEventListener('click', function() {
        setTimeout(initializeCharts, 300);
    });
    
    // Add hover effects to stat cards
    var statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            card.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            card.style.transform = 'translateY(-8px)';
        });
    });
    
    // Add tooltips to feature cards
    var featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(function(card) {
        card.addEventListener('click', function() {
            card.style.backgroundColor = '#ebf8ff';
            setTimeout(function() {
                card.style.backgroundColor = 'white';
            }, 200);
        });
    });
});

function initializeCharts() {
    // Country Distribution Chart
    const countryCtx = document.getElementById('countryChart');
    if (countryCtx) {
        new Chart(countryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Myanmar', 'Cambodia', 'Laos', 'Others'],
                datasets: [{
                    data: [45, 30, 20, 5],
                    backgroundColor: ['#4299e1', '#48bb78', '#ed8936', '#9f7aea'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'การกระจายตามประเทศ'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    // Monthly Statistics Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'แรงงานใหม่',
                    data: [12, 19, 3, 5, 2, 8],
                    borderColor: '#4299e1',
                    backgroundColor: 'rgba(66, 153, 225, 0.1)',
                    tension: 0.4
                }, {
                    label: 'ไปทำงานแล้ว',
                    data: [8, 15, 2, 4, 1, 6],
                    borderColor: '#48bb78',
                    backgroundColor: 'rgba(72, 187, 120, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'สถิติรายเดือน'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection