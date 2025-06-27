@extends('layouts.template')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-cloud-download-alt me-2"></i>
                        Import ข้อมูลคนงานจาก API
                    </h5>
                    <div class="badge bg-light text-dark">
                        {{ count($candidates) }} รายการ
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Summary Section -->
                @if(isset($candidates) && count($candidates) > 0)
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $totalCandidates ?? count($candidates) }}</h4>
                                    <small>ผู้สมัครทั้งหมด</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4 id="converted-count">{{ $convertedCount ?? 0 }}</h4>
                                    <small>แปลงแล้ว</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4 id="pending-count">{{ $pendingCount ?? count($candidates) }}</h4>
                                    <small>รอดำเนินการ</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary btn-lg w-100" onclick="refreshData()">
                                <i class="fas fa-sync-alt me-2"></i>
                                รีเฟรชข้อมูล
                            </button>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="alert alert-light border">
                                <small class="text-muted">
                                    <strong>Debug Info:</strong> 
                                    Route: {{ route('import-labours.convert', ['id' => 'ID']) }} | 
                                    CSRF: <span id="csrf-status">{{ csrf_token() ? 'OK' : 'Missing' }}</span> |
                                    jQuery: <span id="jquery-status">Loading...</span> |
                                    Converted IDs: {{ !empty($convertedCandidateIds) ? implode(', ', $convertedCandidateIds) : 'None' }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($candidates) && count($candidates) > 0)
                <!-- Search Section -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   id="searchInput" 
                                   placeholder="ค้นหาจากชื่อ, เบอร์โทร, อีเมล, จังหวัด, ทักษะ, ประเทศที่สนใจ..."
                                   autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="mt-1">
                            <small class="text-muted">
                                <span id="search-result-count">แสดงทั้งหมด {{ count($candidates) }} รายการ</span>
                                <span id="search-filters" class="ms-2"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" 
                                    id="filterDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-2"></i>ตัวกรอง
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item filter-option" href="#" data-filter="all">
                                    <i class="fas fa-list me-2"></i>แสดงทั้งหมด
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="pending">
                                    <i class="fas fa-clock me-2"></i>รอการแปลง
                                </a></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="converted">
                                    <i class="fas fa-check me-2"></i>แปลงแล้ว
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="male">
                                    <i class="fas fa-mars me-2"></i>เพศชาย
                                </a></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="female">
                                    <i class="fas fa-venus me-2"></i>เพศหญิง
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>คำแนะนำ:</strong> กดปุ่ม "Convert" เพื่อแปลงข้อมูลจาก API และบันทึกลงในระบบ
                    <div class="mt-2">
                        <button class="btn btn-sm btn-warning" onclick="testAjax()">
                            <i class="fas fa-bug me-1"></i>ทดสอบ AJAX
                        </button>
                        <button class="btn btn-sm btn-info ms-2" onclick="debugConvert()">
                            <i class="fas fa-search me-1"></i>Debug Convert
                        </button>
                        <button class="btn btn-sm btn-secondary ms-2" onclick="updateCounts(); console.log('Manual count update');">
                            <i class="fas fa-calculator me-1"></i>อัปเดตตัวนับ
                        </button>
                    </div>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>ไม่มีข้อมูล:</strong> ยังไม่มีข้อมูลจาก API หรือเกิดข้อผิดพลาดในการเชื่อมต่อ
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="candidates-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width:80px" class="text-center">#ID</th>
                                <th><i class="fas fa-user me-1"></i>ชื่อ</th>
                                <th><i class="fas fa-birthday-cake me-1"></i>อายุ</th>
                                <th><i class="fas fa-phone me-1"></i>โทรศัพท์</th>
                                <th><i class="fas fa-envelope me-1"></i>อีเมล</th>
                                <th><i class="fas fa-map-marker-alt me-1"></i>จังหวัด</th>
                                <th><i class="fas fa-briefcase me-1"></i>ทักษะ</th>
                                <th><i class="fas fa-globe me-1"></i>ประเทศที่สนใจ</th>
                                <th><i class="fas fa-graduation-cap me-1"></i>การศึกษา</th>
                                <th style="width:120px" class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidates as $row)
                                @php
                                    $isConverted = in_array($row['id'], $convertedCandidateIds ?? []);
                                @endphp
                                <tr id="row-{{ $row['id'] }}" class="candidate-row {{ $isConverted ? 'table-success' : '' }}">
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $row['id'] }}</span>
                                        @if($isConverted)
                                            <br><small class="text-success mt-1">✓ แปลงแล้ว</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $row['nameeng'] ?? 'N/A' }}</strong>
                                                @if(isset($row['nameth']) && $row['nameth'])
                                                    <br><small class="text-muted">{{ $row['nameth'] }}</small>
                                                @endif
                                                @if(isset($row['nickname']) && $row['nickname'])
                                                    <br><small class="text-success">ชื่อเล่น: {{ $row['nickname'] }}</small>
                                                @endif
                                                @if(isset($row['gender']) && $row['gender'])
                                                    <small class="badge badge-outline-primary ms-1">{{ $row['gender'] === 'M' ? 'ชาย' : 'หญิง' }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $row['age'] ?? '-' }} ปี</span>
                                        @if(isset($row['birthdate']))
                                            <br><small class="text-muted">{{ $row['birthdate'] }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-primary">{{ $row['contract']['tel'] ?? '-' }}</span>
                                        @if(isset($row['contract']['emergencytel']))
                                            <br><small class="text-muted">ฉุกเฉิน: {{ $row['contract']['emergencytel'] }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-info">{{ $row['contract']['email'] ?? '-' }}</span>
                                        @if(isset($row['contract']['lineid']))
                                            <br><small class="text-success">Line: {{ $row['contract']['lineid'] }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $row['contract']['province'] ?? '-' }}</span>
                                        @if(isset($row['contract']['distric']))
                                            <br><small class="text-muted">{{ $row['contract']['distric'] }}</small>
                                        @endif
                                        @if(isset($row['contract']['postcode']))
                                            <br><small class="text-secondary">{{ $row['contract']['postcode'] }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($row['skill']) && $row['skill'])
                                            @php
                                                $skills = explode(',', $row['skill']);
                                                $mainSkill = trim($skills[0] ?? '');
                                                $skillCount = count($skills);
                                            @endphp
                                            <span class="badge bg-warning">{{ $mainSkill }}</span>
                                            @if($skillCount > 1)
                                                <br><small class="text-muted">+{{ $skillCount - 1 }} ทักษะอื่น</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $row['interests']['country'] ?? '-' }}</span>
                                        @if(isset($row['interests']['jobtype']))
                                            <br><small class="text-muted">{{ $row['interests']['jobtype'] }}</small>
                                        @endif
                                        @if(isset($row['interests']['salary']))
                                            <br><small class="text-warning">{{ number_format($row['interests']['salary']) }} บาท</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($row['education']) && !empty($row['education']))
                                            @php
                                                $edu = $row['education'];
                                            @endphp
                                            <span class="badge bg-secondary">{{ $edu['level'] ?? '-' }}</span>
                                            @if(isset($edu['branch']))
                                                <br><small class="text-muted">{{ $edu['branch'] }}</small>
                                            @endif
                                            @if(isset($edu['institution']))
                                                <br><small class="text-info">{{ $edu['institution'] }}</small>
                                            @endif
                                            @if(isset($edu['graduationyear']))
                                                <br><small class="text-warning">{{ $edu['graduationyear'] }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($isConverted)
                                            <button class="btn btn-sm btn-success" disabled>
                                                <i class="fas fa-check me-1"></i>
                                                สำเร็จ
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary btn-convert" 
                                                    data-id="{{ $row['id'] }}"
                                                    title="แปลงข้อมูลเข้าสู่ระบบ">
                                                <i class="fas fa-sync-alt me-1"></i>
                                                Convert
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <br>
                                            ไม่มีข้อมูลจาก API
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.candidate-row.converting {
    background-color: #f8f9fa;
}

.candidate-row:hover {
    background-color: #f8f9fa;
}

.candidate-row.table-success {
    background-color: #d1edcc !important;
}

.btn-convert:disabled {
    cursor: not-allowed;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
}

.badge-outline-primary {
    color: #0d6efd;
    border: 1px solid #0d6efd;
    background-color: transparent;
    font-size: 0.7em;
}

.text-muted {
    font-size: 0.85em;
}

#candidates-table {
    font-size: 0.9em;
}

.table-responsive {
    border-radius: 0.375rem;
}

/* Summary cards */
.card.bg-info, .card.bg-success, .card.bg-warning {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: transform 0.15s ease-in-out;
}

.card.bg-info:hover, .card.bg-success:hover, .card.bg-warning:hover {
    transform: translateY(-2px);
}

/* Search Section */
#searchInput {
    border-radius: 0.375rem 0 0 0.375rem;
    font-size: 0.95rem;
}

#searchInput:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.input-group-text {
    border-radius: 0.375rem 0 0 0.375rem;
}

.search-highlight {
    background-color: #fff3cd;
    padding: 1px 3px;
    border-radius: 2px;
    font-weight: 500;
}

/* Filter dropdown */
.dropdown-menu {
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.active {
    background-color: #0d6efd;
    color: white;
}

/* Hide/Show rows */
.candidate-row.search-hidden {
    display: none !important;
}

.no-results-row {
    background-color: #f8f9fa;
    font-style: italic;
    color: #6c757d;
}

/* Loading animation */
.search-loading {
    opacity: 0.6;
    pointer-events: none;
}

.search-loading .input-group::after {
    content: '';
    position: absolute;
    right: 50px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    border: 2px solid #0d6efd;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// ฟังก์ชันทดสอบ AJAX - เรียกใช้เมื่อจำเป็น
function testAjax() {
    if (typeof $ === 'undefined') {
        alert('❌ jQuery ไม่พร้อมใช้งาน');
        return;
    }
    
    console.log('Testing AJAX...');
    
    const testUrl = '{{ url("import-labours/test-convert/999") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        alert('❌ ไม่พบ CSRF Token');
        return;
    }
    
    $.ajax({
        url: testUrl,
        type: 'POST',
        headers: { 
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('Test Success:', response);
            if (response.success) {
                alert('✅ AJAX ทำงานได้ - ทดสอบสำเร็จ!\nLabour ID: ' + response.labour_id);
                if (response.redirect) {
                    window.open(response.redirect, '_blank');
                }
            } else {
                alert('❌ AJAX ทำงานได้แต่เกิดข้อผิดพลาด: ' + response.message);
            }
        },
        error: function(xhr) {
            console.log('Test Error:', xhr);
            console.log('Response Text:', xhr.responseText);
            
            let errorDetails = `Status: ${xhr.status}`;
            if (xhr.responseJSON?.message) {
                errorDetails += `\nMessage: ${xhr.responseJSON.message}`;
            }
            if (xhr.responseText && xhr.responseText.length < 500) {
                errorDetails += `\nResponse: ${xhr.responseText}`;
            }
            
            alert('❌ AJAX Error\n' + errorDetails);
        }
    });
}

// ฟังก์ชัน Debug Convert - ทดสอบการแปลงข้อมูลจริง
function debugConvert() {
    if (typeof $ === 'undefined') {
        alert('❌ jQuery ไม่พร้อมใช้งาน');
        return;
    }
    
    // ใช้ ID ของ candidate แรกในตาราง
    const firstCandidateId = $('.btn-convert').first().data('id');
    if (!firstCandidateId) {
        alert('❌ ไม่พบ Candidate ID');
        return;
    }
    
    console.log('Debug Convert for ID:', firstCandidateId);
    
    const debugUrl = `{{ url("import-labours/debug-convert") }}/${firstCandidateId}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        alert('❌ ไม่พบ CSRF Token');
        return;
    }
    
    $.ajax({
        url: debugUrl,
        type: 'POST',
        headers: { 
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('Debug Success:', response);
            if (response.success) {
                alert('✅ Debug สำเร็จ!\nตรวจสอบ Console และ Log files สำหรับรายละเอียด');
                console.log('Raw Data:', response.raw_data);
                console.log('Mapped Data:', response.mapped_data);
            } else {
                alert('❌ Debug ไม่สำเร็จ: ' + response.message);
                console.error('Debug Error:', response);
            }
        },
        error: function(xhr) {
            console.log('Debug Error:', xhr);
            let errorMsg = 'Debug Error';
            if (xhr.responseJSON?.message) {
                errorMsg = xhr.responseJSON.message;
            }
            alert('❌ ' + errorMsg + ' - Status: ' + xhr.status);
        }
    });
}

// ฟังก์ชันรีเฟรชข้อมูลแบบ AJAX
function refreshData() {
    console.log('Refreshing data...');
    
    // เก็บค่าการค้นหาปัจจุบัน
    const currentSearch = $('#searchInput').val();
    const currentFilterValue = currentFilter;
    
    // แสดง loading
    const $refreshBtn = $('.btn-outline-primary');
    const originalText = $refreshBtn.html();
    $refreshBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>กำลังโหลด...').prop('disabled', true);
    
    // โหลดข้อมูลใหม่
    $.ajax({
        url: window.location.href,
        type: 'GET',
        success: function(response) {
            // โหลดข้อมูลสำเร็จแล้วรีเฟรชทั้งหน้า
            window.location.reload();
        },
        error: function() {
            console.error('Failed to refresh data');
            alert('❌ ไม่สามารถรีเฟรชข้อมูลได้');
        },
        complete: function() {
            // รีเซ็ตปุ่ม
            $refreshBtn.html(originalText).prop('disabled', false);
        }
    });
}

// ฟังก์ชันนับจำนวน candidate ที่ convert แล้วและยังไม่ได้ convert
function updateCounts() {
    // นับจากแถวที่ไม่ใช่แถว "ไม่มีข้อมูล" และไม่ถูกซ่อนด้วยการค้นหา
    const totalRows = $('#candidates-table tbody tr.candidate-row:not(.search-hidden)').length;
    
    // นับจากแถวที่มี class table-success (convert แล้ว) และไม่ถูกซ่อน
    const convertedRows = $('#candidates-table tbody tr.table-success:not(.search-hidden)').length;
    
    // หรือนับจากปุ่มที่เปลี่ยนเป็น "สำเร็จ" แล้ว และไม่ถูกซ่อน
    const convertedButtons = $('#candidates-table tbody tr:not(.search-hidden) .btn-success').length;
    
    // ใช้วิธีที่ให้ผลลัพธ์มากกว่าเพื่อความแม่นยำ
    const actualConverted = Math.max(convertedRows, convertedButtons);
    const pendingRows = Math.max(0, totalRows - actualConverted);
    
    const $convertedCount = $('#converted-count');
    const $pendingCount = $('#pending-count');
    
    if ($convertedCount.length && $pendingCount.length) {
        $convertedCount.text(actualConverted);
        $pendingCount.text(pendingRows);
        console.log('Counts updated - Total:', totalRows, 'Converted:', actualConverted, 'Pending:', pendingRows);
        console.log('Debug - convertedRows:', convertedRows, 'convertedButtons:', convertedButtons);
    } else {
        console.warn('Count elements not found');
    }
}

// ตัวแปรสำหรับจัดเก็บข้อมูลการค้นหา
let searchTimeout = null;
let currentFilter = 'all';

// ฟังก์ชันค้นหาข้อมูล
function performSearch() {
    const searchTerm = $('#searchInput').val().toLowerCase().trim();
    const $rows = $('#candidates-table tbody tr.candidate-row');
    const $noResultsRow = $('#no-results-row');
    
    let visibleCount = 0;
    let totalCount = $rows.length;
    
    // ลบแถว "ไม่พบข้อมูล" ถ้ามี
    $noResultsRow.remove();
    
    console.log('Searching for:', searchTerm, 'with filter:', currentFilter);
    
    $rows.each(function() {
        const $row = $(this);
        const rowText = $row.text().toLowerCase();
        const isConverted = $row.hasClass('table-success') || $row.find('.btn-success').length > 0;
        const isPending = !isConverted;
        
        // ตรวจสอบเพศ
        const genderText = $row.find('td:nth-child(2)').text().toLowerCase();
        const isMale = genderText.includes('ชาย');
        const isFemale = genderText.includes('หญิง');
        
        let matchesSearch = true;
        let matchesFilter = true;
        
        // ตรวจสอบการค้นหา
        if (searchTerm) {
            matchesSearch = rowText.includes(searchTerm);
        }
        
        // ตรวจสอบตัวกรอง
        switch(currentFilter) {
            case 'pending':
                matchesFilter = isPending;
                break;
            case 'converted':
                matchesFilter = isConverted;
                break;
            case 'male':
                matchesFilter = isMale;
                break;
            case 'female':
                matchesFilter = isFemale;
                break;
            case 'all':
            default:
                matchesFilter = true;
                break;
        }
        
        // แสดง/ซ่อนแถว
        if (matchesSearch && matchesFilter) {
            $row.removeClass('search-hidden');
            visibleCount++;
            
            // Highlight search term
            if (searchTerm && searchTerm.length > 1) {
                highlightSearchTerm($row, searchTerm);
            } else {
                removeHighlight($row);
            }
        } else {
            $row.addClass('search-hidden');
            removeHighlight($row);
        }
    });
    
    // แสดงข้อความถ้าไม่พบข้อมูล
    if (visibleCount === 0 && (searchTerm || currentFilter !== 'all')) {
        const noResultsHtml = `
            <tr id="no-results-row" class="no-results-row">
                <td colspan="10" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-search fa-2x mb-2"></i>
                        <br>
                        ไม่พบข้อมูลที่ตรงกับการค้นหา
                        ${searchTerm ? `"<strong>${searchTerm}</strong>"` : ''}
                        ${currentFilter !== 'all' ? `และตัวกรอง "<strong>${getFilterName(currentFilter)}</strong>"` : ''}
                        <br>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="clearSearch()">
                            <i class="fas fa-times me-1"></i>ล้างการค้นหา
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $('#candidates-table tbody').append(noResultsHtml);
    }
    
    // อัปเดตข้อความแสดงผลการค้นหา
    updateSearchResultText(visibleCount, totalCount, searchTerm);
    
    // อัปเดตตัวนับ
    updateCounts();
    
    console.log(`Search results: ${visibleCount}/${totalCount} rows visible`);
}

// ฟังก์ชัน highlight คำที่ค้นหา
function highlightSearchTerm($row, searchTerm) {
    const $cells = $row.find('td');
    
    $cells.each(function() {
        const $cell = $(this);
        let html = $cell.html();
        
        // ลบ highlight เก่าก่อน
        html = html.replace(/<span class="search-highlight">(.*?)<\/span>/gi, '$1');
        
        // เพิ่ม highlight ใหม่
        const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
        html = html.replace(regex, '<span class="search-highlight">$1</span>');
        
        $cell.html(html);
    });
}

// ฟังก์ชันลบ highlight
function removeHighlight($row) {
    const $cells = $row.find('td');
    $cells.each(function() {
        const $cell = $(this);
        let html = $cell.html();
        html = html.replace(/<span class="search-highlight">(.*?)<\/span>/gi, '$1');
        $cell.html(html);
    });
}

// ฟังก์ชัน escape special characters ใน regex
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// ฟังก์ชันอัปเดตข้อความแสดงผลการค้นหา
function updateSearchResultText(visible, total, searchTerm) {
    const $resultCount = $('#search-result-count');
    const $filters = $('#search-filters');
    
    if (visible === total) {
        $resultCount.text(`แสดงทั้งหมด ${total} รายการ`);
    } else {
        $resultCount.text(`พบ ${visible} จาก ${total} รายการ`);
    }
    
    // แสดงตัวกรองที่ใช้
    let filterText = '';
    if (searchTerm) {
        filterText += `ค้นหา: "${searchTerm}"`;
    }
    if (currentFilter !== 'all') {
        if (filterText) filterText += ' | ';
        filterText += `กรอง: ${getFilterName(currentFilter)}`;
    }
    
    $filters.text(filterText);
}

// ฟังก์ชันแปลงชื่อตัวกรอง
function getFilterName(filter) {
    switch(filter) {
        case 'pending': return 'รอการแปลง';
        case 'converted': return 'แปลงแล้ว';
        case 'male': return 'เพศชาย';
        case 'female': return 'เพศหญิง';
        default: return 'ทั้งหมด';
    }
}

// ฟังก์ชันล้างการค้นหา
function clearSearch() {
    $('#searchInput').val('');
    currentFilter = 'all';
    
    // รีเซ็ตปุ่มตัวกรอง
    $('.filter-option').removeClass('active');
    $('.filter-option[data-filter="all"]').addClass('active');
    $('#filterDropdown').html('<i class="fas fa-filter me-2"></i>ตัวกรอง');
    
    performSearch();
    $('#searchInput').focus();
}

// รอให้ DOM พร้อมแล้วค่อยรัน
document.addEventListener('DOMContentLoaded', function() {
    // ตรวจสอบ jQuery และอัปเดต status
    if (typeof $ !== 'undefined') {
        $('#jquery-status').text('OK');
        console.log('Import script loaded');
        
        // นับจำนวนเริ่มต้น
        console.log('Initial count check');
        updateCounts();
        
        // ตรวจสอบสถานะเริ่มต้น
        console.log('Initial status check:');
        console.log('- Total candidate rows:', $('#candidates-table tbody tr.candidate-row').length);
        console.log('- Success rows:', $('#candidates-table tbody tr.table-success').length);
        console.log('- Success buttons:', $('#candidates-table tbody .btn-success').length);
        console.log('- Primary buttons:', $('#candidates-table tbody .btn-primary').length);
        
        // Event listeners สำหรับการค้นหา
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimeout);
            const $input = $(this);
            
            // แสดง loading effect
            $input.closest('.input-group').addClass('search-loading');
            
            searchTimeout = setTimeout(function() {
                $input.closest('.input-group').removeClass('search-loading');
                performSearch();
            }, 300); // ดีเลย์ 300ms เพื่อลด load
        });
        
        // Event listener สำหรับ Enter key
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                clearTimeout(searchTimeout);
                $(this).closest('.input-group').removeClass('search-loading');
                performSearch();
            }
        });
        
        // Event listeners สำหรับตัวกรอง
        $('.filter-option').on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const filter = $this.data('filter');
            const filterText = $this.text().trim();
            
            // อัปเดต active state
            $('.filter-option').removeClass('active');
            $this.addClass('active');
            
            // อัปเดตปุ่ม dropdown
            $('#filterDropdown').html($this.html());
            
            // อัปเดตตัวกรองปัจจุบัน
            currentFilter = filter;
            
            // ทำการค้นหาใหม่
            performSearch();
            
            console.log('Filter changed to:', filter);
        });
        
        // Event listener สำหรับปุ่มล้างการค้นหา
        $(document).on('click', '[onclick="clearSearch()"]', function(e) {
            e.preventDefault();
            clearSearch();
        });

        // Event listener สำหรับปุ่ม Convert
        $(document).on('click', '.btn-convert', function () {
            const $btn = $(this);
            const $row = $btn.closest('tr');
            const id = $btn.data('id');

            console.log('Convert clicked for ID:', id);

            // ตรวจสอบ CSRF token
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            if (!csrfToken) {
                alert('ไม่พบ CSRF Token กรุณารีเฟรชหน้า');
                return;
            }

            // ปิดการใช้งานปุ่มและเปลี่ยนสถานะ
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-1"></i>กำลังแปลง...');
            
            $row.addClass('converting');

            const url = `{{ url('import-labours/convert') }}/${id}`;

            // เรียก Ajax
            $.ajax({
                url: url,
                type: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                success: function(response) {
                    console.log('Success response:', response);
                    
                    if (response.success) {
                        // แสดงข้อความสำเร็จ
                        $btn.removeClass('btn-primary')
                            .addClass('btn-success')
                            .html('<i class="fas fa-check me-1"></i>สำเร็จ')
                            .prop('disabled', true);
                        
                        $row.removeClass('converting').addClass('table-success');
                        
                        console.log('Row after conversion:', $row[0]);
                        console.log('Row classes:', $row.attr('class'));
                        console.log('Button classes:', $btn.attr('class'));
                        
                        // อัปเดตการนับใหม่เพื่อให้แน่ใจ
                        setTimeout(function() {
                            updateCounts();
                            console.log('Final count check after convert');
                        }, 200);

                        // แสดง notification
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                html: `${response.message}<br><small>Labour ID: ${response.labour_id}</small>`,
                                timer: 3000,
                                showConfirmButton: true,
                                confirmButtonText: 'ดูข้อมูล'
                            }).then((result) => {
                                if (result.isConfirmed && response.redirect) {
                                    window.open(response.redirect, '_blank');
                                }
                            });
                        } else {
                            const viewData = confirm(response.message + '\n\nต้องการดูข้อมูลที่แปลงแล้วหรือไม่?');
                            if (viewData && response.redirect) {
                                window.open(response.redirect, '_blank');
                            }
                        }
                    } else {
                        throw new Error(response.message || 'Unknown error');
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);
                    
                    let errorMessage = 'แปลงไม่สำเร็จ';
                    
                    if (xhr.responseJSON?.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status) {
                        errorMessage = `HTTP ${xhr.status}: ${xhr.statusText}`;
                    }

                    // แสดงข้อความผิดพลาด
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: errorMessage
                        });
                    } else {
                        alert(errorMessage);
                    }

                    // รีเซ็ตปุ่ม
                    $btn.prop('disabled', false)
                        .html('<i class="fas fa-sync-alt me-1"></i>Convert');
                    
                    $row.removeClass('converting');
                }
            });
        });

        // Initialize DataTable ถ้ามี (ลดการใช้งานเพื่อความเร็ว)
        if (typeof $.fn.DataTable !== 'undefined' && $('#candidates-table tbody tr').length > 50) {
            // เปิด DataTable เฉพาะเมื่อมีข้อมูลเยอะ (มากกว่า 50 แถว)
            $('#candidates-table').DataTable({
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                searching: true,
                paging: true,
                info: false,
                lengthChange: false,
                language: {
                    search: "ค้นหา:",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป"
                    }
                }
            });
        } else {
            console.log('DataTable skipped - not needed for small dataset');
        }
        
        // เริ่มต้นการค้นหา
        console.log('Initializing search functionality');
        performSearch(); // ทำการค้นหาครั้งแรกเพื่อ setup ข้อความ
        
        // Focus ที่ช่องค้นหา (ถ้าต้องการ)
        // $('#searchInput').focus();
        
    } else {
        document.getElementById('jquery-status').textContent = 'Missing';
        console.error('jQuery not loaded');
    }
});
</script>

