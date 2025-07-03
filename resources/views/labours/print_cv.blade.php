@extends('layouts.print')

@section('content')
@php
    use Carbon\Carbon;
    $thai = fn($d)=> $d ? Carbon::parse($d)->format('d/m/Y') : '–';
    $left = fn($d)=> $d ? now()->diffInDays(Carbon::parse($d),false).' วัน' : '–';
@endphp

<div class="cv-container">
    <!-- Left Column -->
    <div class="cv-left-column">
        <div class="cv-photo-container">
            <img src="{{ $labour->labour_image_thumbnail_path
                        ? asset('storage/'.$labour->labour_image_thumbnail_path)
                        : asset('/template/dist/assets/images/user/avatar-1.jpg') }}"
                class="cv-photo">
        </div>
        
        <div class="cv-section-left">
            <h2>ข้อมูลติดต่อ</h2>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>{{ $labour->labour_idcard_number }}</div>
            </div>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div>{{ $labour->labour_phone_one ?: '–' }}</div>
            </div>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-phone-volume"></i>
                </div>
                <div>{{ $labour->labour_phone_two ?: '–' }}</div>
            </div>
            
            @if(isset($labour->labour_email) && $labour->labour_email)
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>{{ $labour->labour_email }}</div>
            </div>
            @endif
            
            @if(isset($labour->labour_address) && $labour->labour_address)
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div>{{ $labour->labour_address }}</div>
            </div>
            @endif
        </div>
        
        <div class="cv-section-left">
            <h2>สถานะ</h2>
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>{{ optional($labour->labourStatus)->value ?? '–' }}</div>
            </div>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-birthday-cake"></i>
                </div>
                <div>อายุ {{ Carbon::parse($labour->labour_birthday)->age }} ปี</div>
            </div>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div>{{ optional($labour->company)->name ?: '–' }}</div>
            </div>
            
            <div class="cv-contact-item" style="margin-top: 15px;">
                <div>
                @foreach(['A','B'] as $s)
                <span style="display: inline-block; background-color: {{ in_array($s,$labour->completed_steps) ? '#4a90e2' : '#666' }}; 
                             color: white; padding: 3px 10px; margin-right: 5px; border-radius: 3px; font-size: 12px;">
                    Step {{ $s }}
                </span>
                @endforeach
                </div>
            </div>
        </div>
        
        <div class="cv-section-left">
            <h2>เอกสารหลัก</h2>
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-passport"></i>
                </div>
                <div>{{ $labour->labour_passport_number ?: '–' }}</div>
            </div>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>ออก: {{ $thai($labour->labour_passport_issue_date) }}</div>
            </div>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <div>หมดอายุ: {{ $thai($labour->labour_passport_expiry_date) }}</div>
            </div>
            
            <div class="cv-contact-item">
                <div class="cv-contact-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>เหลือ: {{ $left($labour->labour_passport_expiry_date) }}</div>
            </div>
        </div>
        
        @if($labour->labour_note)
        <div class="cv-section-left">
            <h2>บันทึกเพิ่มเติม</h2>
            <p style="margin-top: 10px;">{{ $labour->labour_note }}</p>
        </div>
        @endif
    </div>
    
    <!-- Right Column -->
    <div class="cv-right-column">
        <div class="cv-header">
            <h1>{{ $labour->labour_prefix }} {{ $labour->labour_firstname }} {{ $labour->labour_lastname }}</h1>
            <div class="cv-role">{{ optional($labour->position)->value ?: 'คนงาน' }}</div>
        </div>
        
        <div class="cv-section-right">
            <h2>ข้อมูลส่วนตัว</h2>
            <div class="cv-grid">
                <div class="cv-grid-item">
                    <div class="cv-label">คำนำหน้า</div>
                    <div class="cv-value">{{ $labour->labour_prefix ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">ชื่อ-นามสกุล</div>
                    <div class="cv-value">{{ $labour->labour_firstname.' '.$labour->labour_lastname ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">วันเกิด</div>
                    <div class="cv-value">{{ $thai($labour->labour_birthday) }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">อายุ</div>
                    <div class="cv-value">{{ Carbon::parse($labour->labour_birthday)->age }} ปี</div>
                </div>
                @if(isset($labour->labour_emergency_contact_name) && $labour->labour_emergency_contact_name)
                <div class="cv-grid-item">
                    <div class="cv-label">ผู้ติดต่อฉุกเฉิน</div>
                    <div class="cv-value">{{ $labour->labour_emergency_contact_name }}</div>
                </div>
                @endif
                @if(isset($labour->labour_line_id) && $labour->labour_line_id)
                <div class="cv-grid-item">
                    <div class="cv-label">LINE ID</div>
                    <div class="cv-value">{{ $labour->labour_line_id }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="cv-section-right">
            <h2>ข้อมูลผลตรวจ / CID</h2>
            <div class="cv-grid">
                <div class="cv-grid-item">
                    <div class="cv-label">โรงพยาบาล</div>
                    <div class="cv-value">{{ optional($labour->hospital)->value ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">วันออกผล</div>
                    <div class="cv-value">{{ $thai($labour->labour_disease_issue_date) }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">วันรับผล</div>
                    <div class="cv-value">{{ $thai($labour->labour_disease_receive_date) }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">ผลโรคหมดอายุ</div>
                    <div class="cv-value">{{ $left($labour->labour_disease_issue_date ? Carbon::parse($labour->labour_disease_issue_date)->addDays(30) : null) }}</div>
                </div>
            </div>
        </div>
        
        <div class="cv-section-right">
            <h2>รายละเอียดงาน & การจัดเก็บเอกสาร</h2>
            <div class="cv-grid">
                <div class="cv-grid-item">
                    <div class="cv-label">บริษัทนายจ้าง</div>
                    <div class="cv-value">{{ optional($labour->company)->name ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">ใบสมัครเลขที่</div>
                    <div class="cv-value">{{ $labour->labour_register_number ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">การจัดเก็บเอกสาร</div>
                    <div class="cv-value">{{ optional($labour->manageDoc)->managedoc_name ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">ประเทศ</div>
                    <div class="cv-value">{{ optional($labour->country)->value ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">กลุ่มงาน</div>
                    <div class="cv-value">{{ optional($labour->jobGroup)->value ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">ตำแหน่ง</div>
                    <div class="cv-value">{{ optional($labour->position)->value ?: '–' }}</div>
                </div>
            </div>
        </div>
        
        <div class="cv-section-right">
            <h2>ข้อมูลเจ้าหน้าที่สรรหา</h2>
            <div class="cv-grid">
                <div class="cv-grid-item">
                    <div class="cv-label">ศูนย์สอบ</div>
                    <div class="cv-value">{{ optional($labour->examinationCenter)->value ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">รอบสอบวันที่</div>
                    <div class="cv-value">{{ $thai($labour->lacation_test_date) }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">เจ้าหน้าที่</div>
                    <div class="cv-value">{{ optional($labour->staff)->value ?: '–' }}</div>
                </div>
                <div class="cv-grid-item">
                    <div class="cv-label">ชื่อสาย</div>
                    <div class="cv-value">{{ optional($labour->staffSub)->value ?: '–' }}</div>
                </div>
            </div>
        </div>
        
        @if(isset($listFiles) && count($listFiles) > 0)
        <div class="cv-section-right">
            <h2>ไฟล์เอกสาร</h2>
            <table class="cv-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;">Code</th>
                        <th style="width: 45%;">ชื่อไฟล์</th>
                        <th style="width: 15%;">Step</th>
                        <th style="width: 20%;">อัปเดตล่าสุด</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listFiles as $i=>$f)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $f->managefile_code }}</td>
                        <td>{{ $f->managefile_name }}</td>
                        <td>{{ $f->managefile_step }}</td>
                        <td>{{ $f->file_path ? $thai($f->updated_at) : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <div class="cv-signature-section">
            <div class="cv-signature">
                <div class="cv-signature-line"></div>
                <div class="cv-signature-name">ลายมือชื่อผู้สมัคร</div>
            </div>
            <div class="cv-date">
                วันที่พิมพ์: {{ $thai(now()) }}
            </div>
        </div>
    </div>
</div>
@endsection
