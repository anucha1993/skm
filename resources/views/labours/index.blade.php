@extends('layouts.template')

@section('content')
    @if (session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', function() {
                alert(@json(session('success')));
            });
        </script>
    @endif

    <style>
        /* Badge styles for data source */
        .badge.bg-primary {
            background-color: #0d6efd !important;
        }
        .badge.bg-success {
            background-color: #198754 !important;
        }
        .badge {
            font-size: 0.75em;
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
        }
        .badge i {
            font-size: 0.9em;
        }
        #labours-table td {
            vertical-align: middle;
        }
        #labours-table .badge {
            white-space: nowrap;
        }
        #labours-table td:nth-child(4) {
            min-width: 140px;
            text-align: center;
        }
        #labours-table small.text-muted {
            font-size: 0.7em;
            line-height: 1.2;
            display: block;
            margin-top: 2px;
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
        @media (max-width: 768px) {
            /* Responsive: ซ่อนบางคอลัมน์ */
            #labours-table th:nth-child(2),
            #labours-table td:nth-child(2), /* รูปภาพ */
            #labours-table th:nth-child(6),
            #labours-table td:nth-child(6), /* ประเทศ */
            #labours-table th:nth-child(7),
            #labours-table td:nth-child(7), /* ประเภทงาน */
            #labours-table th:nth-child(8),
            #labours-table td:nth-child(8), /* Steps */
            #labours-table th:nth-child(9),
            #labours-table td:nth-child(9)  /* โทรศัพท์ */
            {
                display: none;
            }
            #labours-table td:nth-child(4) {
                min-width: 100px;
            }
            #labours-table small.text-muted {
                font-size: 0.65em;
            }
            .btn, .btn-sm {
                font-size: 0.85em;
                padding: 0.3em 0.6em;
            }
            .table th, .table td {
                font-size: 0.85em;
                padding: 0.4em 0.3em;
            }
            .card .card-body h3 {
                font-size: 1.2em;
            }
            .card .card-body h6 {
                font-size: 0.9em;
            }
        }
    </style>

    <div class="row flex-wrap">
        <div class="col-12 col-md-3 mb-2">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="text-success">{{ $totalLabours }}</h3>
                            <h6 class="text-muted m-b-0">คนงานทั้งหมด</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($statusCounts as $label => $count)
            <div class="col-6 col-md-2 mb-2">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3>{{ $count }}</h3>
                                <h6 class="text-muted m-b-0">{{ $label }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">ข้อมูลคนงาน</h5>
                    <a href="{{ route('labours.create') }}">เพิ่มข้อมูล</a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">

                            <form class="row g-2 align-items-center flex-wrap" method="get" action="" id="filter-form">
                                <div class="col-12 col-md-6 mb-1 mb-md-0">
                                    <input type="text" name="search" class="form-control form-control-sm" placeholder="ค้นหา: เลขบัตร/ชื่อ-สกุล/ประเทศ/ประเภทงาน/โทรศัพท์" value="{{ request('search') }}">
                                </div>
                                <div class="col-6 col-md-2 mb-1 mb-md-0">
                                    <select name="status" class="form-select form-select-sm" id="status-select">
                                        <option value="all">ทุกสถานะ</option>
                                        @foreach ($statusGlobalSet->values as $status)
                                            <option value="{{ $status->id }}" @if (request('status') == $status->id) selected @endif>{{ $status->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-md-2 d-flex gap-1 mb-1 mb-md-0">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">ค้นหา</button>
                                    <a href="{{ route('labours.index') }}" class="btn btn-outline-secondary btn-sm w-100">ล้าง</a>
                                </div>
                                <div class="col-12 col-md-2 foat-end mt-1 mt-md-0">
                                    <div class="btn-group w-100" role="group" aria-label="Source Filter">
                                        <a href="?status={{ request('status', 'all') }}&source=all" class="btn btn-outline-secondary btn-sm w-100 @if (request('source', 'all') == 'all') active @endif">ทั้งหมด</a>
                                        <a href="?status={{ request('status', 'all') }}&source=api" class="btn btn-outline-primary btn-sm w-100 @if (request('source') == 'api') active @endif">API Import</a>
                                        <a href="?status={{ request('status', 'all') }}&source=manual" class="btn btn-outline-success btn-sm w-100 @if (request('source') == 'manual') active @endif">Manual Entry</a>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var statusSelect = document.getElementById('status-select');
                                    if (statusSelect) {
                                        statusSelect.addEventListener('change', function() {
                                            document.getElementById('filter-form').submit();
                                        });
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="labours-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>รูปภาพ</th>
                                    <th>เลขบัตรประชาชน</th>
                                    <th>ชื่อ-สกุล</th>
                                    <th>แหล่งข้อมูล</th>
                                    <th>ประเทศ</th>
                                    <th>ประเภทงาน</th>
                                    <th>Steps</th>
                                    <th>โทรศัพท์</th>
                                    <th>จัดการ</th>
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
                                                <span class="badge bg-primary"><i
                                                        class="fas fa-cloud-download-alt me-1"></i>API Import</span></br>
                                                        <small style="color:#888;">apiid : {{$row->api_candidate_id}}</small>
                                            @else
                                                <span class="badge bg-success"><i class="fas fa-user-plus me-1"></i>Manual
                                                    Entry</span>
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
                                            <a href="{{ url('labours/' . $row->labour_id) }}"
                                                class="btn btn-sm btn-info me-1">ดู</a>
                                            <a href="{{ url('labours/' . $row->labour_id . '/edit') }}"
                                                class="btn btn-sm btn-warning me-1">แก้ไข</a>
                                            @can('delete-labour')
                                                <form action="{{ url('labours/' . $row->labour_id) }}" method="POST"
                                                    style="display:inline-block;"
                                                    onsubmit="return confirm('ยืนยันการลบข้อมูลคนงานนี้?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                                                </form>
                                            @endcan

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
