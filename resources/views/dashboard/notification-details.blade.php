@extends('layouts.template')

@section('content')
<style>
    body {
        font-family: 'Inter', 'Prompt', 'Sarabun', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        color: #2d3748;
    }

    .details-container {
        padding: 2rem 1rem;
        min-height: 100vh;
    }

    .details-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .details-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .back-btn {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
        color: white;
    }

    .table-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .table-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-info {
        color: #64748b;
        font-size: 1rem;
        font-weight: 500;
    }

    .export-btn {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .export-btn:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .modern-table thead th {
        padding: 1.25rem 1rem;
        text-align: left;
        font-weight: 600;
        color: white;
        font-size: 0.9rem;
        letter-spacing: 0.025em;
        border: none;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e2e8f0;
    }

    .modern-table tbody tr:hover {
        background: #f8fafc;
        transform: scale(1.01);
    }

    .modern-table tbody tr:last-child {
        border-bottom: none;
    }

    .modern-table tbody td {
        padding: 1rem;
        font-size: 0.9rem;
        color: #4a5568;
        border: none;
        vertical-align: middle;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .days-left {
        font-weight: 600;
        padding: 0.375rem 0.75rem;
        border-radius: 12px;
        text-align: center;
        min-width: 80px;
    }

    .days-left.critical {
        background: #fee2e2;
        color: #dc2626;
    }

    .days-left.warning {
        background: #fef3c7;
        color: #d97706;
    }

    .days-left.expired {
        background: #fecaca;
        color: #b91c1c;
        font-weight: 700;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-view {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        transform: translateY(-1px);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: #4a5568;
    }

    .empty-state p {
        font-size: 1rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .details-container {
            padding: 1rem 0.5rem;
        }
        
        .details-header {
            padding: 1.5rem;
            flex-direction: column;
            text-align: center;
        }
        
        .details-title {
            font-size: 1.5rem;
        }
        
        .table-container {
            padding: 1rem;
            overflow-x: auto;
        }
        
        .modern-table {
            min-width: 800px;
        }
        
        .table-actions {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<div class="details-container">
    <!-- Header -->
    <div class="details-header">
        <h1 class="details-title">
            @switch($type)
                @case('disease_expiring')
                    <i class="fas fa-heartbeat text-danger"></i>
                    {{ $title }}
                    @break
                @case('passport_expiring')
                    <i class="fas fa-passport text-primary"></i>
                    {{ $title }}
                    @break
                @case('cid_expiring')
                    <i class="fas fa-id-card text-warning"></i>
                    {{ $title }}
                    @break
                @case('affidavit_expiring')
                    <i class="fas fa-file-contract text-purple"></i>
                    {{ $title }}
                    @break
            @endswitch
        </h1>
        <a href="{{ route('dashboard.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            กลับหน้า Dashboard
        </a>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-actions">
            <div class="table-info">
                <i class="fas fa-info-circle"></i>
                ทั้งหมด {{ $data->count() }} รายการ
            </div>
            @if($data->count() > 0)
                <a href="{{ route('dashboard.export-notification', ['type' => $type]) }}" class="export-btn">
                    <i class="fas fa-download"></i>
                    Export Excel
                </a>
            @endif
        </div>

        @if($data->count() > 0)
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>เลขบัตรประชาชน</th>
                        <th>บริษัท</th>
                        <th>สถานะ</th>
                        <th>วันที่หมดอายุ</th>
                        <th>จำนวนวันที่เหลือ</th>
                        <th>การติดต่อ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $labour)
                        @php
                            $expiryDate = null;
                            switch($type) {
                                case 'disease_expiring':
                                    $expiryDate = $labour->labour_disease_issue_date ? 
                                                 \Carbon\Carbon::parse($labour->labour_disease_issue_date)->addDays(30) : null;
                                    break;
                                case 'passport_expiring':
                                    $expiryDate = $labour->labour_passport_expiry_date ? 
                                                 \Carbon\Carbon::parse($labour->labour_passport_expiry_date) : null;
                                    break;
                                case 'cid_expiring':
                                    $expiryDate = $labour->labour_cid_expiry_date ? 
                                                 \Carbon\Carbon::parse($labour->labour_cid_expiry_date) : null;
                                    break;
                                case 'affidavit_expiring':
                                    $expiryDate = $labour->labour_affidavit_expiry_date ? 
                                                 \Carbon\Carbon::parse($labour->labour_affidavit_expiry_date) : null;
                                    break;
                            }
                            
                            $daysLeft = $expiryDate ? now()->diffInDays($expiryDate, false) : 0;
                            $daysClass = $daysLeft <= 0 ? 'expired' : ($daysLeft <= 7 ? 'critical' : 'warning');
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">
                                    {{ $labour->labour_prefix }} {{ $labour->labour_firstname }} {{ $labour->labour_lastname }}
                                </div>
                            </td>
                            <td>{{ $labour->labour_idcard_number }}</td>
                            <td>{{ $labour->company->name ?? '-' }}</td>
                            <td>
                                <span class="status-badge bg-primary text-white">
                                    {{ $labour->labourStatus->value ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $expiryDate ? $expiryDate->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="days-left {{ $daysClass }}">
                                    {{ $daysLeft > 0 ? $daysLeft . ' วัน' : 'หมดอายุแล้ว' }}
                                </span>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div><i class="fas fa-phone text-primary"></i> {{ $labour->labour_phone_one }}</div>
                                    @if($labour->labour_email)
                                        <div class="mt-1"><i class="fas fa-envelope text-secondary"></i> {{ $labour->labour_email }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('labours.show', $labour->labour_id) }}" class="btn-sm btn-view">
                                        <i class="fas fa-eye"></i>ดู
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <h3>ไม่มีรายการแจ้งเตือน</h3>
                <p>ไม่พบข้อมูลที่จะหมดอายุในช่วงเวลานี้</p>
            </div>
        @endif
    </div>
</div>
@endsection