@extends('layouts.template')

@section('content')
<style>
    body {
        font-family: 'Inter', 'Prompt', 'Sarabun', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        color: #2d3748;
    }

  
    .dashboard-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dashboard-title {
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.25rem;
        letter-spacing: -0.01em;
    }

    .dashboard-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 10px;
        padding: 0.9rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.16);
        transition: all 0.22s ease;
        position: relative;
        overflow: hidden;
        min-height: 90px;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-gradient);
        border-radius: 20px 20px 0 0;
    }

    .stat-card:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    /* Clickable stat cards */
    a.stat-card:hover {
        cursor: pointer;
    }
    
    a.stat-card:active {
        transform: translateY(-4px) scale(1.01);
    }

    .stat-card.total { --card-gradient: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .stat-card.working { --card-gradient: linear-gradient(135deg, #10b981, #059669); }
    .stat-card.cancelled { --card-gradient: linear-gradient(135deg, #ef4444, #dc2626); }
    .stat-card.visa-approved { --card-gradient: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .stat-card.visa-rejected { --card-gradient: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-card.visa-no-update { --card-gradient: linear-gradient(135deg, #6b7280, #4b5563); }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        font-size: 1.05rem;
        color: white;
        background: var(--card-gradient);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
    }

    .stat-number {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.15rem;
        line-height: 1.05;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.025em;
    }

    .notifications-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Chart card styling */
    .chart-card {
        background: rgba(255,255,255,0.98);
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        margin-bottom: 1.25rem;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #ef4444;
        font-size: 1.2rem;
    }

    .notifications-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .notification-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e2e8f0;
        position: relative;
        transition: all 0.3s ease;
    }

    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .notification-header {
        display: flex;
        align-items: center;
        justify-content: between;
        margin-bottom: 0.75rem;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
        margin-right: 0.75rem;
    }

    .notification-card.disease .notification-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .notification-card.passport .notification-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .notification-card.cid .notification-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .notification-card.affidavit .notification-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .notification-card.unpaid-deposits .notification-icon { background: linear-gradient(135deg, #dc2626, #991b1b); }

    .notification-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 0.25rem;
    }

    .notification-count {
        font-size: 2rem;
        font-weight: 800;
        color: #ef4444;
        margin-bottom: 1rem;
    }

    .notification-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .btn-modern {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-view {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-export {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-export:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #64748b;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem 0.5rem;
        }
        
        .dashboard-header {
            padding: 1.5rem;
        }
        
        .dashboard-title {
            font-size: 2rem;
        }
        
        .stats-grid,
        .notifications-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .stat-card,
        .notification-card {
            padding: 1rem;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard การแจ้งเตือน
        </h1>
        <p class="dashboard-subtitle">ระบบติดตามและแจ้งเตือนข้อมูลคนงาน</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ number_format($statistics['total_labours']) }}</div>
            <div class="stat-label">ข้อมูลคนงานทั้งหมด</div>
        </div>

        <a href="{{ route('dashboard.statistic-details', ['type' => 'working']) }}" class="stat-card working" style="text-decoration: none; color: inherit;">
            <div class="stat-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-number">{{ number_format($statistics['working_labours']) }}</div>
            <div class="stat-label">ไปทำงานแล้ว</div>
        </a>

        <a href="{{ route('dashboard.statistic-details', ['type' => 'cancelled']) }}" class="stat-card cancelled" style="text-decoration: none; color: inherit;">
            <div class="stat-icon">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stat-number">{{ number_format($statistics['cancelled_labours']) }}</div>
            <div class="stat-label">จำนวนคนงานยกเลิก</div>
        </a>

        <a href="{{ route('dashboard.statistic-details', ['type' => 'visa_approved']) }}" class="stat-card visa-approved" style="text-decoration: none; color: inherit;">
            <div class="stat-icon">
                <i class="fas fa-passport"></i>
            </div>
            <div class="stat-number">{{ number_format($statistics['visa_approved']) }}</div>
            <div class="stat-label">VISA อนุมัติแล้ว</div>
        </a>

        <a href="{{ route('dashboard.statistic-details', ['type' => 'visa_rejected']) }}" class="stat-card visa-rejected" style="text-decoration: none; color: inherit;">
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-number">{{ number_format($statistics['visa_rejected']) }}</div>
            <div class="stat-label">VISA ไม่อนุมัติ</div>
        </a>

        <a href="{{ route('dashboard.statistic-details', ['type' => 'visa_no_update']) }}" class="stat-card visa-no-update" style="text-decoration: none; color: inherit;">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-number">{{ number_format($statistics['visa_no_update']) }}</div>
            <div class="stat-label">VISA ไม่ Update (75+ วัน)</div>
        </a>
    </div>

   

    <!-- Notifications Section -->
    <div class="notifications-section">
        <h2 class="section-title">
            <i class="fas fa-bell"></i>
            การแจ้งเตือนหมดอายุและการเงิน (15 วันก่อนหมดอายุ / เงินมัดจำค้างชำระ)
        </h2>

        <div class="notifications-grid">
            <!-- Disease Expiring -->
            <div class="notification-card disease">
                <div class="notification-header">
                    <div class="notification-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">ผลโรคหมดอายุ</div>
                        <div class="notification-count">{{ $notifications['disease_expiring']->count() }}</div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('dashboard.notification-details', ['type' => 'disease_expiring']) }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-eye"></i>ดูรายละเอียด
                    </a>
                    @if($notifications['disease_expiring']->count() > 0)
                        <a href="{{ route('dashboard.export-notification', ['type' => 'disease_expiring']) }}" 
                           class="btn-modern btn-export">
                            <i class="fas fa-download"></i>Export Excel
                        </a>
                    @endif
                </div>
                @if($notifications['disease_expiring']->count() == 0)
                    <div class="empty-state">ไม่มีรายการแจ้งเตือน</div>
                @endif
            </div>

            <!-- Passport Expiring -->
            <div class="notification-card passport">
                <div class="notification-header">
                    <div class="notification-icon">
                        <i class="fas fa-passport"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">พาสปอร์ตหมดอายุ</div>
                        <div class="notification-count">{{ $notifications['passport_expiring']->count() }}</div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('dashboard.notification-details', ['type' => 'passport_expiring']) }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-eye"></i>ดูรายละเอียด
                    </a>
                    @if($notifications['passport_expiring']->count() > 0)
                        <a href="{{ route('dashboard.export-notification', ['type' => 'passport_expiring']) }}" 
                           class="btn-modern btn-export">
                            <i class="fas fa-download"></i>Export Excel
                        </a>
                    @endif
                </div>
                @if($notifications['passport_expiring']->count() == 0)
                    <div class="empty-state">ไม่มีรายการแจ้งเตือน</div>
                @endif
            </div>

            <!-- CID Expiring -->
            <div class="notification-card cid">
                <div class="notification-header">
                    <div class="notification-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">CID หมดอายุ</div>
                        <div class="notification-count">{{ $notifications['cid_expiring']->count() }}</div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('dashboard.notification-details', ['type' => 'cid_expiring']) }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-eye"></i>ดูรายละเอียด
                    </a>
                    @if($notifications['cid_expiring']->count() > 0)
                        <a href="{{ route('dashboard.export-notification', ['type' => 'cid_expiring']) }}" 
                           class="btn-modern btn-export">
                            <i class="fas fa-download"></i>Export Excel
                        </a>
                    @endif
                </div>
                @if($notifications['cid_expiring']->count() == 0)
                    <div class="empty-state">ไม่มีรายการแจ้งเตือน</div>
                @endif
            </div>

            <!-- Affidavit Expiring -->
            <div class="notification-card affidavit">
                <div class="notification-header">
                    <div class="notification-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">Affidavit หมดอายุ</div>
                        <div class="notification-count">{{ $notifications['affidavit_expiring']->count() }}</div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('dashboard.notification-details', ['type' => 'affidavit_expiring']) }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-eye"></i>ดูรายละเอียด
                    </a>
                    @if($notifications['affidavit_expiring']->count() > 0)
                        <a href="{{ route('dashboard.export-notification', ['type' => 'affidavit_expiring']) }}" 
                           class="btn-modern btn-export">
                            <i class="fas fa-download"></i>Export Excel
                        </a>
                    @endif
                </div>
                @if($notifications['affidavit_expiring']->count() == 0)
                    <div class="empty-state">ไม่มีรายการแจ้งเตือน</div>
                @endif
            </div>

            <!-- Unpaid Deposits -->
            @canany(['account-update-labour'])
            <div class="notification-card unpaid-deposits">
                <div class="notification-header">
                    <div class="notification-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">เงินมัดจำ CID ค้างชำระ</div>
                        <div class="notification-count">{{ $notifications['unpaid_deposits']->count() }}</div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('dashboard.notification-details', ['type' => 'unpaid_deposits']) }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-eye"></i>ดูรายละเอียด
                    </a>
                    @if($notifications['unpaid_deposits']->count() > 0)
                        <a href="{{ route('dashboard.export-notification', ['type' => 'unpaid_deposits']) }}" 
                           class="btn-modern btn-export">
                            <i class="fas fa-download"></i>Export Excel
                        </a>
                    @endif
                </div>
                @if($notifications['unpaid_deposits']->count() == 0)
                    <div class="empty-state">ไม่มีรายการแจ้งเตือน</div>
                @endif
            </div>
            @endcanany
        </div>
        
        <!-- Documentation Section -->
        <h2 class="section-title">
            <i class="fas fa-book-open"></i>
            คู่มือการใช้งานระบบ
        </h2>
        <div class="notifications-grid">
            <div class="notification-card" style="border-left: 4px solid #667eea;">
                <div class="notification-header">
                    <div class="notification-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">คู่มือผู้ใช้งาน</div>
                        <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem;">
                            วิธีการใช้งานสำหรับผู้ใช้ทั่วไป
                        </div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('documentation.user-manual') }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-book-reader"></i>อ่านคู่มือ
                    </a>
                </div>
            </div>

            <div class="notification-card" style="border-left: 4px solid #e53e3e;">
                <div class="notification-header">
                    <div class="notification-icon" style="background: linear-gradient(135deg, #e53e3e, #dd6b20);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">คู่มือผู้ดูแลระบบ</div>
                        <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem;">
                            สำหรับผู้ดูแลและจัดการระบบ
                        </div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('documentation.admin-guide') }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-cog"></i>เข้าดูคู่มือ
                    </a>
                </div>
            </div>

            <div class="notification-card" style="border-left: 4px solid #4299e1;">
                <div class="notification-header">
                    <div class="notification-icon" style="background: linear-gradient(135deg, #4299e1, #3182ce);">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="flex-1">
                        <div class="notification-title">ภาพรวมระบบ</div>
                        <div style="font-size: 0.85rem; color: #6b7280; margin-top: 0.25rem;">
                            สถิติ คุณสมบัติ และแผนงาน
                        </div>
                    </div>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ route('documentation.system-overview') }}" 
                       class="btn-modern btn-view">
                        <i class="fas fa-chart-line"></i>ดูภาพรวม
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
     <!-- Chart -->
    <div class="chart-card">
        <h3 class="section-title" style="margin-bottom:0.75rem; font-size:1.05rem;">
            <i class="fas fa-chart-bar" style="color:#4f46e5; font-size:1rem;"></i>
            สถิติภาพรวม
        </h3>
        <div style="height:320px; width:100%;">
            <canvas id="dashboardStatsChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            var stats = @json($statistics);
            var labels = ['ทั้งหมด', 'ไปทำงานแล้ว', 'ยกเลิก', 'VISA อนุมัติ', 'VISA ไม่อนุมัติ', 'VISA ไม่อัพเดต'];
            var data = [
                stats.total_labours || 0,
                stats.working_labours || 0,
                stats.cancelled_labours || 0,
                stats.visa_approved || 0,
                stats.visa_rejected || 0,
                stats.visa_no_update || 0
            ];

            var colors = [
                'rgba(59,130,246,0.85)',
                'rgba(16,185,129,0.85)',
                'rgba(239,68,68,0.85)',
                'rgba(139,92,246,0.85)',
                'rgba(245,158,11,0.85)',
                'rgba(107,114,128,0.85)'
            ];

            var ctx = document.getElementById('dashboardStatsChart');
            if (ctx) {
                // ensure canvas has a rendering context
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'จำนวน',
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors.map(c => c.replace('0.85', '1')),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { mode: 'index', intersect: false }
                        },
                        scales: {
                            x: { stacked: false, grid: { display: false } },
                            y: { beginAtZero: true, ticks: { precision:0 } }
                        }
                    }
                });
            }
        } catch (e) {
            console.error('Chart init error', e);
        }
    });

    // Auto refresh every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
</script>
@endsection