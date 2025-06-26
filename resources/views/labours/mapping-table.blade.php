@extends('layouts.template')

@section('content')
<div class="container">
    <h4 class="mb-4">🧩 Mapping ข้อมูลแรงงานจาก API</h4>

    <form action="{{ route('labour.import.convert') }}" method="POST">
        @csrf

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ฟิลด์ระบบ</th>
                    <th>เลือกฟิลด์จาก API</th>
                    <th>Preview ข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($internalFields as $internal => $apiFieldDefault)
                    <tr>
                        <td><strong>{{ $internal }}</strong></td>
                        <td>
                            <select name="mapped[{{ $internal }}]" class="form-control form-control-sm" required>
                                @foreach (array_keys($apiData[0]) as $apiField)
                                    <option value="{{ $apiField }}" {{ $apiField == $apiFieldDefault ? 'selected' : '' }}>
                                        {{ $apiField }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            @php $value = $apiData[0][$apiFieldDefault] ?? null; @endphp

                            @if(in_array($internal, ['labour_nationality', 'labour_status', 'lacation_test_id', 'staff_id', 'staff_sub_id', 'company_id', 'managedoc_id']))
                                <select name="preview[{{ $internal }}]" class="form-control form-control-sm select2">
                                    <option value="">-- เลือก --</option>

                                    @php
                                        $set = null;
                                        if ($internal === 'labour_nationality') $set = $countryGlobalSet;
                                        elseif ($internal === 'labour_status') $set = $statusGlobalSet;
                                        elseif ($internal === 'lacation_test_id') $set = $ExaminationCenterGlobalSet;
                                        elseif ($internal === 'staff_id') $set = $StaffGlobalSet;
                                        elseif ($internal === 'staff_sub_id') $set = $StaffsubGlobalSet;
                                        elseif ($internal === 'managedoc_id') $set = $manageDocs;
                                        elseif ($internal === 'company_id') $set = $customers;

                                        $options = isset($set->values) ? $set->values : $set;
                                    @endphp

                                    @foreach ($options as $item)
                                        <option value="{{ $item->id }}" {{ ($item->value ?? $item->name) == $value ? 'selected' : '' }}>
                                            {{ $item->value ?? $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" name="preview[{{ $internal }}]" value="{{ $value }}" class="form-control form-control-sm">
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <input type="hidden" name="data" value="{{ json_encode($apiData) }}">

        <button type="submit" class="btn btn-success mt-3">✅ ยืนยันนำเข้าข้อมูล</button>
        <a href="{{ route('labour.import.index') }}" class="btn btn-secondary mt-3">🔙 กลับ</a>
    </form>
</div>

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'ค้นหา...',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
@endsection
