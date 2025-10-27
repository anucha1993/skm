@extends('layouts.template')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show slide-up" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <style>
        /* Professional Statistics Cards */
        .stats-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
            height: 100px;
            width: 100%;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        
        .stats-card .card-body {
            padding: 1rem;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        /* Primary Card (Total) */
        .stats-card-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stats-card-primary::before { background: linear-gradient(90deg, #4f46e5, #7c3aed); }

        /* Success Card */
        .stats-card-success {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: white;
        }
        .stats-card-success::before { background: linear-gradient(90deg, #059669, #047857); }

        /* Warning Card */
        .stats-card-warning {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }
        .stats-card-warning::before { background: linear-gradient(90deg, #d97706, #b45309); }

        /* Info Card */
        .stats-card-info {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
        }
        .stats-card-info::before { background: linear-gradient(90deg, #2563eb, #1d4ed8); }

        /* Danger Card */
        .stats-card-danger {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
        }
        .stats-card-danger::before { background: linear-gradient(90deg, #dc2626, #b91c1c); }

        /* Secondary Card */
        .stats-card-secondary {
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
            color: white;
        }
        .stats-card-secondary::before { background: linear-gradient(90deg, #475569, #334155); }

        /* Dark Card */
        .stats-card-dark {
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            color: white;
        }
        .stats-card-dark::before { background: linear-gradient(90deg, #111827, #000000); }

        /* Light Card (Default fallback) */
        .stats-card-light {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #334155;
            border: 1px solid #e2e8f0;
        }
        .stats-card-light::before { background: linear-gradient(90deg, #94a3b8, #64748b); }

        .stats-number {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stats-label {
            font-size: 0.8rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .stats-icon {
            font-size: 2rem;
            opacity: 0.25;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Plane animation */
        .stats-card:hover .fa-plane {
            animation: planefly 2s ease-in-out infinite;
        }

        @keyframes planefly {
            0%, 100% { 
                transform: translateY(-50%) translateX(0) rotate(0deg); 
            }
            50% { 
                transform: translateY(-50%) translateX(5px) rotate(5deg); 
            }
        }

        /* Professional Table Styling */
        .professional-table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .professional-table {
            margin-bottom: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.9rem;
        }

        .professional-table thead th {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 12px;
            border: none;
            text-align: center;
            vertical-align: middle;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .professional-table thead th:first-child {
            border-top-left-radius: 16px;
        }

        .professional-table thead th:last-child {
            border-top-right-radius: 16px;
        }

        .professional-table tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid #f3f4f6;
            border-right: none;
            border-left: none;
            vertical-align: middle;
            color: #374151;
            text-align: center;
        }

        .professional-table tbody tr {
            transition: all 0.2s ease;
        }

        .professional-table tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, rgba(99, 102, 241, 0.02) 100%);
            transform: scale(1.001);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .professional-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badge styles for data source */
        .badge.bg-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }

        .badge {
            font-size: 0.75em;
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-weight: 600;
            border: none;
            color: white;
        }

        .badge i {
            font-size: 0.9em;
            margin-right: 4px;
        }

        /* Column Specific Styling */
        .professional-table .col-id {
            width: 80px;
            font-weight: 600;
            color: #6366f1;
        }

        .professional-table .col-image {
            width: 80px;
        }

        .professional-table .col-image img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .professional-table .col-image img:hover {
            transform: scale(1.1);
            border-color: #6366f1;
        }

        .professional-table .col-name {
            min-width: 200px;
            text-align: left;
            font-weight: 600;
        }

        .professional-table .col-phone {
            width: 120px;
            font-family: monospace;
            font-weight: 500;
        }

        .professional-table .col-actions {
            width: 120px;
        }

        /* Professional Action Buttons */
        .action-btn-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        /* View Button - Blue */
        .action-btn-view {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .action-btn-view:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            color: white;
        }

        /* Edit Button - Orange */
        .action-btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        .action-btn-edit:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
            color: white;
        }

        /* Delete Button - Red */
        .action-btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .action-btn-delete:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            color: white;
        }

        .action-btn:active {
            transform: translateY(-1px) scale(1.02);
        }

        /* Tooltip enhancement */
        .action-btn[title] {
            position: relative;
        }

        .action-btn[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 110%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 1000;
            opacity: 1;
            animation: tooltipFade 0.2s ease-in;
        }

        @keyframes tooltipFade {
            from { opacity: 0; transform: translateX(-50%) translateY(5px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        /* Status Steps Styling */
        .status-step {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-step.pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .status-step.processing {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .status-step.completed {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Source Info Styling */
        .source-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .source-info .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 100px;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            cursor: default;
        }

        .source-info .badge.bg-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .source-info .badge.bg-success {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .source-info .badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .source-info .badge.source-filter {
            cursor: pointer;
            user-select: none;
            position: relative;
            transition: all 0.3s ease;
        }

        .source-info .badge.source-filter:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .source-info .badge.source-filter:active {
            transform: translateY(-1px) scale(1.02);
        }

        .source-info .badge.source-filter::after {
            content: '🔍';
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 0.7rem;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .source-info .badge.source-filter:hover::after {
            opacity: 1;
        }

        /* Active Filter Styling */
        .source-info .badge.active-filter {
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
            animation: pulse-filter 2s infinite;
        }

        @keyframes pulse-filter {
            0%, 100% { 
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3); 
            }
            50% { 
                box-shadow: 0 0 0 6px rgba(99, 102, 241, 0.1); 
            }
        }

        .source-info .api-id {
            font-size: 0.7rem;
            font-weight: 500;
            color: #6b7280;
            font-family: 'Courier New', monospace;
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            margin-top: 2px;
        }

        /* Country Flag Styling */
        .country-flag {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .country-flag .flag-icon {
            width: 24px;
            height: 16px;
            border-radius: 2px;
            background-size: cover;
            border: 1px solid #e5e7eb;
        }

        .badge.bg-primary {
            box-shadow: 0 1px 3px rgba(13, 110, 253, 0.3);
        }

        .badge.bg-success {
            box-shadow: 0 1px 3px rgba(25, 135, 84, 0.3);
        }

        #labours-table tbody tr:hover .badge {
            transform: translateY(-1px);
            transition: transform 0.15s ease-in-out;
        }

        /* Mobile Responsive Table */
        @media (max-width: 1200px) {
            .professional-table {
                font-size: 0.8rem;
            }
            
            .professional-table thead th {
                padding: 12px 8px;
                font-size: 0.75rem;
            }
            
            .professional-table tbody td {
                padding: 10px 8px;
            }
        }

        @media (max-width: 992px) {
            .professional-table-container {
                margin: 0 -15px;
                border-radius: 0;
            }
            
            .professional-table {
                font-size: 0.75rem;
            }
            
            .col-name {
                min-width: 150px !important;
            }
            
            .action-btn {
                width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }
        }

        @media (max-width: 768px) {
            .stats-card {
                height: 85px;
            }
            
            .stats-card .card-body {
                padding: 0.75rem;
            }
            
            .stats-number {
                font-size: 1.5rem;
            }
            
            .stats-label {
                font-size: 0.7rem;
            }
            
            .stats-icon {
                font-size: 1.5rem;
                right: 0.75rem;
            }

            /* Mobile Table Adjustments */
            .professional-table thead th {
                padding: 8px 4px;
                font-size: 0.7rem;
            }
            
            .professional-table tbody td {
                padding: 8px 4px;
            }
            
            .col-image img {
                width: 40px;
                height: 40px;
            }
            
            .action-btn-group {
                flex-direction: column;
                gap: 4px;
            }
        }

        @media (max-width: 576px) {
            .stats-card {
                margin-bottom: 0.75rem;
                height: 80px;
            }
            
            .stats-number {
                font-size: 1.3rem;
            }
            
            .stats-label {
                font-size: 0.65rem;
            }
            
            .stats-icon {
                font-size: 1.3rem;
            }
            
            /* Very Small Screen Table */
            .professional-table {
                font-size: 0.7rem;
            }

            /* Mobile Source Info */
            .source-info .badge {
                min-width: 80px;
                padding: 0.4rem 0.6rem;
                font-size: 0.7rem;
            }

            .source-info .api-id {
                font-size: 0.65rem;
            }
        }
    </style>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card stats-card stats-card-primary fade-in">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="stats-number text-white mb-0">{{ $totalLabours }}</h3>
                            <p class="stats-label text-white mb-0">คนงานทั้งหมด</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $statusIcons = [
                'รอดำเนินการ' => ['icon' => 'fas fa-clock', 'color' => 'warning'],
                'กำลังดำเนินการ' => ['icon' => 'fas fa-spinner fa-spin', 'color' => 'info'],  
                'ดำเนินการสำเร็จ' => ['icon' => 'fas fa-plane', 'color' => 'success'],
                'บินไปทำงานแล้ว' => ['icon' => 'fas fa-plane', 'color' => 'success'],
                'ดำเนินการแล้ว' => ['icon' => 'fas fa-check-double', 'color' => 'success'],
                'อันใหม่' => ['icon' => 'fas fa-star', 'color' => 'primary'],
                'ยกเลิก' => ['icon' => 'fas fa-times-circle', 'color' => 'danger'],
                'ไม่ระบุ' => ['icon' => 'fas fa-question-circle', 'color' => 'secondary'],
                'ไม่อนุมัติ' => ['icon' => 'fas fa-ban', 'color' => 'dark'],
                'อันไม่ผ่านงาน' => ['icon' => 'fas fa-exclamation-triangle', 'color' => 'warning'],
                'อันไม่ผ่านงานแล้ว' => ['icon' => 'fas fa-times', 'color' => 'danger']
            ];
        @endphp
        @foreach ($statusCounts as $label => $count)
            @php
                $statusConfig = $statusIcons[$label] ?? ['icon' => 'fas fa-chart-bar', 'color' => 'light'];
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card stats-card stats-card-{{ $statusConfig['color'] }} fade-in">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="stats-number mb-0">{{ $count }}</h4>
                                <p class="stats-label mb-0">{{ $label }}</p>
                            </div>
                            <div class="stats-icon">
                                <i class="{{ $statusConfig['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card fade-in">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-user-hard-hat me-2 text-primary"></i>ข้อมูลคนงาน</h4>
                            <small class="text-muted">จัดการข้อมูลคนงานทั้งหมด</small>
                        </div>
                        <a href="{{ route('labours.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>เพิ่มข้อมูลใหม่
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="bg-light p-3 rounded mb-4">
                        <form class="row g-3 align-items-center" method="get" action="" id="filter-form">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-search me-2"></i>ค้นหา
                                </label>
                                <input type="text" name="search" class="form-control"
                                    placeholder="เลขบัตร/ชื่อ-สกุล/ประเทศ/ประเภทงาน/โทรศัพท์"
                                    value="{{ request('search') }}">
                            </div>

                            <div class="col-lg-2 col-md-3">
                                <label class="form-label">
                                    <i class="fas fa-filter me-2"></i>สถานะ
                                </label>
                                <select name="status" class="form-select" id="status-select">
                                    <option value="all">ทุกสถานะ</option>
                                    @foreach ($statusGlobalSet->values as $status)
                                        <option value="{{ $status->id }}"
                                            @if (request('status') == $status->id) selected @endif>{{ $status->value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>ค้นหา
                                    </button>
                                    <a href="{{ route('labours.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-refresh me-2"></i>ล้าง
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">
                                    <i class="fas fa-database me-2"></i>แหล่งข้อมูล
                                </label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="source" id="all" value="all" 
                                           @if(request('source', 'all') == 'all') checked @endif>
                                    <label class="btn btn-outline-secondary" for="all">ทั้งหมด</label>

                                    <input type="radio" class="btn-check" name="source" id="api" value="api"
                                           @if(request('source') == 'api') checked @endif>
                                    <label class="btn btn-outline-primary" for="api">
                                        <i class="fas fa-cloud-download-alt me-1"></i>API Import
                                    </label>

                                    <input type="radio" class="btn-check" name="source" id="manual" value="manual"
                                           @if(request('source') == 'manual') checked @endif>
                                    <label class="btn btn-outline-success" for="manual">
                                        <i class="fas fa-user-plus me-1"></i>Manual Entry
                                    </label>
                                </div>
                            </div>

                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Status filter functionality
                                    var statusSelect = document.getElementById('status-select');
                                    if (statusSelect) {
                                        statusSelect.addEventListener('change', function() {
                                            document.getElementById('filter-form').submit();
                                        });
                                    }

                                    // Source radio button functionality
                                    var sourceRadios = document.querySelectorAll('input[name="source"]');
                                    sourceRadios.forEach(function(radio) {
                                        radio.addEventListener('change', function() {
                                            document.getElementById('filter-form').submit();
                                        });
                                    });
                                    /////
                                    // Source filter functionality
                                    var currentSourceFilter = '{{ request("source") }}' || 'all';
                                    
                                    // Badge click functionality to sync with radio buttons
                                    document.querySelectorAll('.source-filter').forEach(function(badge) {
                                        badge.addEventListener('click', function() {
                                            var source = this.getAttribute('data-source');
                                            var currentSource = document.querySelector('input[name="source"]:checked').value;
                                            
                                            // Toggle logic: if same source, go to 'all', otherwise select the clicked source
                                            var targetSource = (currentSource === source) ? 'all' : source;
                                            
                                            // Update radio button
                                            var targetRadio = document.getElementById(targetSource);
                                            if (targetRadio) {
                                                targetRadio.checked = true;
                                                // Trigger form submission
                                                document.getElementById('filter-form').submit();
                                            }
                                        });
                                        
                                        // Add visual feedback for clickable badges
                                        badge.style.cursor = 'pointer';
                                    });

                                });
                            </script>
                        </div>
                    </div>
                    <div class="professional-table-container">
                        <table class="table professional-table" id="labours-table">
                            <thead>
                                <tr>
                                    <th class="col-id"><i class="fas fa-hashtag me-1"></i>รหัส</th>
                                    <th class="col-image"><i class="fas fa-image me-1"></i>รูปภาพ</th>
                                    <th><i class="fas fa-id-card me-1"></i>เลขบัตรประชาชน</th>
                                    <th class="col-name"><i class="fas fa-user me-1"></i>ชื่อ-สกุล</th>
                                    <th><i class="fas fa-database me-1"></i>แหล่งข้อมูล</th>
                                    <th><i class="fas fa-flag me-1"></i>ประเทศ</th>
                                    <th><i class="fas fa-briefcase me-1"></i>ประเภทงาน</th>
                                    <th><i class="fas fa-tasks me-1"></i>Steps</th>
                                    <th class="col-phone"><i class="fas fa-phone me-1"></i>โทรศัพท์</th>
                                    <th class="col-actions"><i class="fas fa-cogs me-1"></i>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($labours as $row)
                                    <tr>
                                        <td>{{ $row->labour_id }}</td>
                                        <td class="text-center">
                                            <img src="{{ $row->labour_image_thumbnail_path ? asset('storage/' . ltrim($row->labour_image_thumbnail_path, '/')) : asset('images/user_icon.png') }}"
                                                class="rounded-circle" style="width:30px;height:30px;object-fit:cover;">
                                            <div style="font-size:0.85em;color:#888;">
                                                {{ $row->labourStatus->value ?? '-' }}</div>
                                        </td>
                                        <td>{{ $row->labour_idcard_number }}</td>
                                        <td>{{ $row->labour_prefix }}. {{ $row->labour_firstname }}
                                            {{ $row->labour_lastname }}</td>
                                        <td class="text-center">
                                            @if (!empty($row->api_candidate_id) || !empty($row->api_imported_at) || $row->source_type === 'api')
                                                <div class="source-info">
                                                    <span class="badge bg-primary mb-1 source-filter {{ request('source') == 'api' ? 'active-filter' : '' }}" 
                                                          data-source="api" role="button" tabindex="0" title="คลิกเพื่อกรองข้อมูล API เท่านั้น">
                                                        <i class="fas fa-cloud-download-alt me-1"></i>API Import
                                                    </span>
                                                    <br>
                                                    <small class="text-muted api-id">ID: {{$row->api_candidate_id}}</small>
                                                </div>
                                            @else
                                                <div class="source-info">
                                                    <span class="badge bg-success source-filter {{ request('source') == 'manual' ? 'active-filter' : '' }}" 
                                                          data-source="manual" role="button" tabindex="0" title="คลิกเพื่อกรองข้อมูล Manual เท่านั้น">
                                                        <i class="fas fa-user-plus me-1"></i>Manual Entry
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $row->country->value ?? '-' }}</td>
                                        <td>{{ $row->jobGroup->value ?? '-' }}</td>

                                      

                                        <td>
                                            <div>
                                                @if ($row->listFiles && $row->listFiles->count() > 0)
                                                    @php $hasStep = false; @endphp
                                                    @foreach (['A', 'B'] as $s)
                                                        @if (in_array($s, $row->completed_steps))
                                                            @php $hasStep = true; @endphp
                                                        @endif
                                                        <span
                                                            class="badge bg-{{ in_array($s, $row->completed_steps) ? 'success' : 'secondary' }} rounded-pill me-1">
                                                            Step {{ $s }}
                                                        </span>
                                                    @endforeach
                                                  
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        </td>

                                        <td>{{ $row->labour_phone_one }}</td>
                                        <td class="text-center">
                                            <div class="action-btn-group">
                                                <a href="{{ url('labours/' . $row->labour_id) }}"
                                                   class="action-btn action-btn-view"
                                                   title="ดูข้อมูล">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ url('labours/' . $row->labour_id . '/edit') }}"
                                                   class="action-btn action-btn-edit"
                                                   title="แก้ไขข้อมูล">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @can('delete-labour')
                                                    <form action="{{ url('labours/' . $row->labour_id) }}" method="POST"
                                                          style="display:inline-block;"
                                                          onsubmit="return confirm('ยืนยันการลบข้อมูลคนงานนี้?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="action-btn action-btn-delete"
                                                                title="ลบข้อมูล">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">ไม่มีข้อมูล</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($labours->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $labours->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
