@extends('layouts.template')

@section('content')
<div class="col-sm-12">
   <form action="{{ route('managedocs.store') }}" method="post">
    @csrf
    @method('POST')
  


        <div class="card">
            <div class="card-header">
                <h5>การจัดการเอกสาร</h5>
            </div>

            <div class="card-body">
              
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="managedoc_name" class="col-sm-3 col-form-label">ชื่อระบบเอกสาร</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="managedoc_name" name="managedoc_name"
                                    placeholder="ชื่อระบบเอกสาร">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="managedoc_country" class="col-sm-3 col-form-label">เอกสารประเทศ</label>
                            <div class="col-sm-9">
                                <select name="managedoc_country" class="form-control" id="managedoc_country">
                                    <option value="">--Select--</option>
                                    @forelse ($country as $item)
                                        <option value="{{ $item->country_job_id }}">{{ $item->country_job_name }}</option>
                                    @empty
                                        <option value="">ไม่มีข้อมูลประเทศ</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="managedoc_status" class="col-sm-3 col-form-label">สถานะ</label>
                            <div class="col-sm-9">
                                <select name="managedoc_status" class="form-control" id="managedoc_status">
                                    <option value="Y">เปิดใช้งาน</option>
                                    <option value="N">ปิดใช้งาน</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
   


            <div class="card">
                <div class="card-header">
                    <h5>รายการเอกสาร</h5>
                </div>
                <div class="card-body">
                    <table class="table table-success" id="documentTable">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>Code ย่อ</th>
                                <th>ชื่อเอกสาร</th>
                                <th>Step</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 100px"><input type="number" name="managefile_no[]"
                                        class="form-control form-control-sm" value="1" readonly></td>
                                <td style="width: 300px">
                                    <input type="text" name="managefile_code[]" class="form-control form-control-sm" placeholder="CV" required>
                                <td>
                                    <input type="text" name="managefile_name[]" class="form-control form-control-sm" placeholder="เอกสาร-CV" required>
                                </td>
                                <td>
                                    <select name="managefile_step[]" class="form-control form-control-sm" required>
                                        <option value="A">Step A </option>
                                        <option value="B">Step B </option>
                                    </select>
                               
                                </td>
                                <td><input type="checkbox" name="managefile_status[]" value="Y" checked></td>
                                <td>
                                    <a href="#" class="text-success move-up"><i class="fa fa-arrow-up"></i> Up</a> |
                                    <a href="#" class="text-info move-down"><i class="fa fa-arrow-down"></i> Down</a> |
                                    <a href="#" class="text-danger remove-row"> <i class="fa fa-trash "></i> Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-warning mt-3" id="addRow">เพิ่มรายการ</button>
                    <button type="submit" class="btn btn-primary mt-3 float-right">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>


    <script>
    $(document).ready(function() {
    function updateRowNumbers() {
        $("#documentTable tbody tr").each(function(index) {
            $(this).find('td:first-child input[name="managefile_no[]"]').val(index + 1);
        });
    }

    $("#addRow").click(function() {
        var newRow = `
            <tr>
                <td style="width: 100px"><input type="number" name="managefile_no[]" class="form-control form-control-sm"    value=""     readonly></td>
                <td style="width: 300px"><input type="text" name="managefile_code[]" class="form-control form-control-sm" placeholder=""></td>
                <td><input type="text" name="managefile_name[]" class="form-control form-control-sm" placeholder=""></td>
                <td>
                    <select name="managefile_step[]" class="form-control form-control-sm">
                        <option value="A">Step A </option>
                        <option value="B">Step B </option>
                    </select>
                </td>
                <td><input type="checkbox"     name="managefile_status[]" value="Y" checked></td>
                <td>
                    <a href="#" class="text-success move-up"><i class="fa fa-arrow-up"></i> Up</a> |
                    <a href="#" class="text-info move-down"><i class="fa fa-arrow-down"></i> Down</a> |
                    <a href="#" class="text-danger remove-row"> <i class="fa fa-trash "></i> Delete</a>
                </td>
            </tr>
        `;
        $("#documentTable tbody").append(newRow);
        updateRowNumbers();
        console.log("Row added. Current tbody HTML:", $("#documentTable tbody").html()); // Debugging
    });

    $("#documentTable tbody").on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });

    $("#documentTable tbody").on('click', '.move-up', function() {
        var $row = $(this).closest('tr');
        if ($row.index() > 0) {
            $row.insertBefore($row.prev());
            updateRowNumbers(); // เรียกใช้ updateRowNumbers() หลังจากสลับตำแหน่ง
        }
    });

    $("#documentTable tbody").on('click', '.move-down', function() {
        var $row = $(this).closest('tr');
        if ($row.index() < $row.siblings().length) {
            $row.insertAfter($row.next());
            updateRowNumbers(); // เรียกใช้ updateRowNumbers() หลังจากสลับตำแหน่ง
        }
    });

    updateRowNumbers(); // เรียกใช้ครั้งแรกเพื่อกำหนดลำดับเริ่มต้น
});
    </script>
@endsection