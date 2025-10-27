@extends('layouts.template')
@section('content')

    <h4 class="mb-3">รายงานข้อมูลคนงาน</h4>

    <div class="row">
        <div class="card">
            <div class="card-body">



                <form method="GET" action="{{ route('report.labours.index') }}" class="row g-3">
                    {{-- บริษัท --}}


                    <div class="col-md-3">
                        <label class="form-label">บริษัท</label>
                        <select name="company_id" class="form-select">
                            <option value="">-- ทั้งหมด --</option>
                            @foreach ($companies as $c)
                                <option value="{{ $c->id }}" {{ request('company_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- สถานะคนงาน --}}
                    <div class="col-md-2">
                        <label class="form-label">สถานะ</label>
                        <select name="labour_status" class="form-select ">
                            <option value="">-- ทั้งหมด --</option>
                            @foreach ($statuses as $st)
                                <option value="{{ $st->id }}" {{ request('labour_status') == $st->id ? 'selected' : '' }}>
                                    {{ $st->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                   

                    {{-- สัญชาติ --}}
                    <div class="col-md-2">
                        <label class="form-label">สัญชาติ</label>
                        <select name="country_id" class="form-select">
                            <option value="">-- ทั้งหมด --</option>
                            @foreach ($countries as $ct)
                                <option value="{{ $ct->id }}" {{ request('country_id') == $ct->id ? 'selected' : '' }}>
                                    {{ $ct->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                   

                    {{-- วันที่สร้าง --}}
                    <div class="col-md-2">
                        <label class="form-label">วันที่เริ่ม</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">ถึงวันที่</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Step เอกสาร</label>
                        <select name="steps[]" class="form-select select2" multiple data-placeholder="-- ทั้งหมด --">
                            @foreach($allSteps as $s)
                            <option value="{{ $s }}" {{ collect(request('steps'))->contains($s)?'selected':'' }}>
                               Step {{ $s }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ปุ่ม --}}
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary me-2"><i class="fa fa-search"></i> ค้นหา</button>
                        <a href="{{ route('report.labours.export', request()->query()) }}" class="btn btn-success">
                            <i class="fa fa-file-excel"></i> ส่งออก Excel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Preview ตารางเล็ก ๆ ดูก่อน (ไม่จำเป็นตัดออกได้) --}}

        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>เลขสมัคร</th>
                        <th>ชื่อ</th>
                        <th>บริษัท</th>
                        <th>สัญชาติ</th>
                        <th>สถานะ</th>
                        <th>บันทึกเมื่อ</th>
                    </tr>
                </thead>
                @if ($preview->count())
                    <tbody>
                        @foreach ($preview as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->labour_register_number }}</td>
                                <td>{{ $row->labour_prefix }} {{ $row->labour_firstname }} {{ $row->labour_lastname }}
                                </td>
                                <td>{{ $row->company?->name }}</td>
                                <td>{{ $row->country?->value }}</td>
                                <td>{{ $row->labourStatus?->value }}</td>
                                <td>{{ $row->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>

    </div>



<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- ทั้งหมด --",
            allowClear: true,
            width: '100%',
            theme: 'default',
            language: {
                noResults: function() {
                    return "ไม่พบข้อมูล";
                }
            }
        });
        
        // Force refresh styling after initialization and on change
        function fixSelect2Styling() {
            setTimeout(function() {
                $('.select2-selection__rendered').css('color', '#495057');
                $('.select2-selection__choice').css({
                    'color': '#ffffff !important',
                    'background-color': '#0d6efd !important',
                    'border': '1px solid #0d6efd !important',
                    'display': 'inline-block !important'
                });
                $('.select2-selection__choice span, .select2-selection__choice .select2-selection__choice__display').css({
                    'color': '#ffffff !important',
                    'font-weight': '500 !important',
                    'display': 'inline !important',
                    'visibility': 'visible !important'
                });
            }, 50);
        }
        
        // Apply styling on load and change events
        fixSelect2Styling();
        $('.select2').on('select2:select select2:unselect', fixSelect2Styling);
    });
</script>
@endsection
