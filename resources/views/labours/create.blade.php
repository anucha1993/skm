@extends('layouts.template')

@section('content')
    {{-- <div class="col-md-12">
 <div class="card">
    <div class="card-header">
            <h4>เพิ่มข้อมูลคนงาน</h2>
    </div>
    <form action="{{route('labours.store')}}" method="post">
        @csrf
        @method('POST')
    <div class="card-body">
        <h5 class="text-success">ข้อมูลส่วนตัว</h5>
        
       <br>
        <button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-save"></i> ยืนยันการเพิ่ม</button>
    </div>
   
    
</form>
 </div>
</div> --}}
<form action="{{ route('labours.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- [ tabs ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>เพิ่มข้อมูลคนงาน</h5>
                </div>
                
                <div class="card-body">
                    
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-uppercase" id="home-tab" data-toggle="tab" href="#home"
                                role="tab" aria-controls="home" aria-selected="true">ข้อมูลส่วนตัว</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link text-uppercase" id="profile-tab" data-toggle="tab" href="#profile"
                                role="tab" aria-controls="profile" aria-selected="false">ข้อมูลเจ้าหน้าที่สรรหา</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link text-uppercase" id="contact-tab" data-toggle="tab" href="#contact"
                                role="tab" aria-controls="contact" aria-selected="false">ไฟล์เอกสาร</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">

                        {{-- ข้อมูลส่วนตัว --}}
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="col-md-12">
                                {{-- <div class="row">
                                    <div class="col-md-4">
                                        <label for="">คำนำหน้า</label>
                                        <select name="labour_prefix" class="form-control form-control-sm">
                                            <option value="">---Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">ชื่อ</label>
                                        <input type="text" name="labour_firstname" class="form-control form-control-sm"
                                            placeholder="Firstname">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">นามสกุล</label>
                                        <input type="text" name="labour_lastname" class="form-control form-control-sm"
                                            placeholder="Lastname">
                                    </div>
                                </div> --}}
                                <br>

                                <div class="row container">

                                    <div class="col-md-12">
                                        <b class="">รายละเอียดที่วไป</b>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">

                                            <label for="" class="col-sm-4 col-form-label-sm text-right">คำนำหน้า
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select name="labour_prefix" class="form-control form-control-sm" required>
                                                    <option value="">---Select--</option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Ms">Ms.</option>
                                                    <option value="Miss">Miss.</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">เลขบัตร 13
                                                หลัก <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_idcard_number"
                                                    class="form-control form-control-sm" required
                                                    placeholder="เลขบัตรประจำตัวประชาชน 13 หลัก">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row container">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">ชื่อ <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_firstname"
                                                    class="form-control form-control-sm" required placeholder="Firstname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">นามสกุล
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_lastname"
                                                    class="form-control form-control-sm" required placeholder="Firstname">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">วันเกิด
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="date" name="labour_birthday"
                                                    class="form-control form-control-sm" required placeholder="++66">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">อายุ
                                                <span class="text-success">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="total-birthday" placeholder="0 ปี" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">เบอร์ติดต่อ
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_phone_one"
                                                    class="form-control form-control-sm" required placeholder="++66">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for=""
                                                class="col-sm-4 col-form-label-sm text-right">เบอร์ติดต่อบุคคลฉุกเฉิน
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_phone_two"
                                                    class="form-control form-control-sm" required placeholder="++66">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 ">
                                <b class="">ข้อมูลหนังสือเดินทาง</b>
                                <hr>
                            </div>

                            <div class="row container">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">เลขที่หนังสือเดินทาง </label>
                                        <div class="col-sm-8">
                                            <input type="text" name="labour_passport_number"
                                                class="form-control form-control-sm" placeholder="เลขที่หนังสือเดินทาง">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">วันที่ออกหนังสือเดินทาง </label>
                                        <div class="col-sm-8">
                                            <input type="date" name="labour_passport_issue_date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">วันที่หมดอายุหนังสือเดินทาง
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="date" name="labour_passport_expiry_date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">จำนวนวันที่จะหมดอายุ </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="total-days-expiry"
                                                class="form-control form-control-sm" placeholder="0" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <b class="">ข้อมูลผลตรวจโรค & CID</b>
                                <hr>
                            </div>

                            <div class="row container">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">โรงพยาบาลที่ตรวจโรค</label>
                                        <div class="col-sm-8">
                                            <select name="labour_hospital" class="form-control form-control-sm">
                                                <option value="">--Select--</option>
                                                @if(!empty($hospitalGlobalSet))
                                                    @php
                                                        // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                        $values = $hospitalGlobalSet->values;
                                                        if($hospitalGlobalSet->sort_order_preference == 'alphabetical') {
                                                            $values = $values->sortBy('value');
                                                        }
                                                    @endphp
                                                    @foreach($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">วันรับผลโรค</label>
                                        <div class="col-sm-8">
                                            <input type="date" name="labour_disease_receive_date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">วันออกผลโรค</label>
                                        <div class="col-sm-8">
                                            <input type="date" name="labour_disease_issue_date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-4 col-form-label-sm text-right">ผลโรคอายุ
                                            คำนวน 30 วัน</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="total-disease-expiry" readonly
                                                class="form-control form-control-sm" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <b class="">ข้อมูลรายละเอียดงาน & จัดเก็บเอกสาร</b>
                                <hr>
                            </div>
                            <div class="row container">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">บริษัทนายจ้าง</label>
                                        <div class="col-sm-8">
                                            <select name="company_id" class="form-control form-control-sm">
                                                <option value="">--Select--</option>
                                                @forelse ($customers as $item)
                                                    <option  value="{{ $item->id }}">{{ $item->name }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">เลขที่ใบสมัคร</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="labour_register_number" class="form-control form-control-sm" placeholder="Register Number.">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">การจัดเก็บเอกสาร</label>
                                        <div class="col-sm-8">
                                            <select name="managedoc_id" class="form-control form-control-sm">
                                                <option value="">--Select--</option>
                                                @forelse ($manageDocs as $item)
                                                <option value="{{$item->managedoc_id}}">{{$item->managedoc_name}}</option>
                                                @empty
                                                    
                                                @endforelse
                
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">ประเทศสมัครงาน</label>
                                        <div class="col-sm-8">
                                            <select name="country_id" class="form-control form-control-sm">
                                                <option value="">--Select--</option>
                                                @if(!empty($countryGlobalSet))
                                                    @php
                                                        // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                        $values = $countryGlobalSet->values;
                                                        if($countryGlobalSet->sort_order_preference == 'alphabetical') {
                                                            $values = $values->sortBy('value');
                                                        }
                                                    @endphp
                                                    @foreach($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">กลุ่มงาน</label>
                                        <div class="col-sm-8">
                                            <select name="job_group_id" class="form-control form-control-sm">
                                                <option value="">--Select--</option>
                                                @if(!empty($jobGroupGlobalSet))
                                                    @php
                                                        // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                        $values = $jobGroupGlobalSet->values;
                                                        if($jobGroupGlobalSet->sort_order_preference == 'alphabetical') {
                                                            $values = $values->sortBy('value');
                                                        }
                                                    @endphp
                                                    @foreach($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">ตำแหน่ง</label>
                                        <div class="col-sm-8">
                                            <select name="position_id" class="form-control form-control-sm">
                                                <option value="">--Select--</option>
                                                @if(!empty($positionGlobalSet))
                                                @php
                                                    // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                    $values = $positionGlobalSet->values;
                                                    if($positionGlobalSet->sort_order_preference == 'alphabetical') {
                                                        $values = $values->sortBy('value');
                                                    }
                                                @endphp
                                                @foreach($values as $item)
                                                    <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <b class="">สถานะคนงาน</b>
                                <hr>
                            </div>
                            <div class="row container">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label-sm text-right">สถานะ <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="labour_status" class="form-control form-control-sm" required>
                                            <option value="">--Select--</option>
                                            @if(!empty($statusGlobalSet))
                                            @php
                                                // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                $values = $statusGlobalSet->values;
                                                if($statusGlobalSet->sort_order_preference == 'alphabetical') {
                                                    $values = $values->sortBy('value');
                                                }
                                            @endphp
                                            @foreach($values as $item)
                                                <option value="{{ $item->id }}">{{ $item->value }}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-sm-4 col-form-label-sm text-right">บันทึกเพิ่มเติม </label>
                                    <div class="col-sm-8">
                                        <textarea name="labour_note" class="form-control" cols="30" rows="2" placeholder="Note.."></textarea>
                                    </div>
                                </div>
                            </div>
                            </div>
                         



                            
                            {{-- <a class="btn btn-success text-white float-right" data-toggle="tab" href="#profile"
                                role="tab" aria-controls="profile" aria-selected="false">Next Step</a> --}}
                        </div>


                        {{-- /// --}}


                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <div class="col-md-12 ">
                                <b class="">ข้อมูลเจ้าหน้าที่สรรหา</b>
                                <hr>
                            </div>

                            <div class="row container">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">ศูนย์สอบ </label>
                                        <div class="col-sm-8">
                                            <select name="lacation_test_id" class="form-control form-control-sm" >
                                                <option value="">--Select--</option>
                                                @if(!empty($ExaminationCenterGlobalSet))
                                                @php
                                                    // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                    $values = $ExaminationCenterGlobalSet->values;
                                                    if($ExaminationCenterGlobalSet->sort_order_preference == 'alphabetical') {
                                                        $values = $values->sortBy('value');
                                                    }
                                                @endphp
                                                @foreach($values as $item)
                                                    <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">รอบสอบวันที่ </label>
                                        <div class="col-sm-8">
                                            <input type="date" name="lacation_test_date" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                             </div>


                             <div class="col-md-12 ">
                                <b class="">ข้อมูลสถานะ</b>
                                <hr>
                            </div>

                            <div class="row container">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">เจ้าหน้าที่สรรหา</label>
                                        <div class="col-sm-8">
                                            <select name="staff_id" class="form-control form-control-sm" >
                                                <option value="">--Select--</option>
                                                @if(!empty($StaffGlobalSet))
                                                @php
                                                    // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                    $values = $StaffGlobalSet->values;
                                                    if($StaffGlobalSet->sort_order_preference == 'alphabetical') {
                                                        $values = $values->sortBy('value');
                                                    }
                                                @endphp
                                                @foreach($values as $item)
                                                    <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-sm-4 col-form-label-sm text-right">ชื่อสาย</label>
                                        <div class="col-sm-8">
                                            <select name="staff_sub_id" class="form-control form-control-sm" >
                                                <option value="">--Select--</option>
                                                @if(!empty($StaffsubGlobalSet))
                                                @php
                                                    // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                    $values = $StaffsubGlobalSet->values;
                                                    if($StaffsubGlobalSet->sort_order_preference == 'alphabetical') {
                                                        $values = $values->sortBy('value');
                                                    }
                                                @endphp
                                                @foreach($values as $item)
                                                    <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            คุณจำเป็นต้องบันทึกข้อมูลก่อนจึงจะสามารถ Uploads ไฟล์เอกสารลงระบบได้
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success text-white float-right"> บันทึกข้อมูล</button>
        </div>
    </form>
        

        <script>
            //คำนวนอายุ
            $(document).ready(function() {
                $('input[name="labour_birthday"]').on('change', function() {
                    var birthdayStr = $(this).val();
                    var ageString = ''; // Initialize ageString

                    if (birthdayStr) {
                        var birthday = new Date(birthdayStr);
                        var today = new Date();
                        var ageYears = today.getFullYear() - birthday.getFullYear();
                        var ageMonths = today.getMonth() - birthday.getMonth();
                        var ageDays = today.getDate() - birthday.getDate();

                        if (ageMonths < 0 || (ageMonths === 0 && ageDays < 0)) {
                            ageYears--;
                            ageMonths += 12;
                            if (ageDays < 0) {
                                var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 0)
                                .getDate();
                                ageDays += lastDayOfMonth;
                                ageMonths--;
                                if (ageMonths < 0) {
                                    ageMonths = 11;
                                }
                            }
                        }

                        ageString = ageYears + ' ปี';
                        if (ageMonths > 0) {
                            ageString += ' ' + ageMonths + ' เดือน';
                        }
                        if (ageDays > 0) {
                            ageString += ' ' + ageDays + ' วัน';
                        }

                        $('#total-birthday').val(ageString); // เลือก Element ด้วย ID โดยตรง

                    } else {
                        $('#total-birthday').val(''); // เลือก Element ด้วย ID โดยตรง
                    }
                });
            });
            /// ---- ////

            $(document).ready(function() {
                $('input[name="labour_passport_expiry_date"]').on('change', function() {
                    var expiryDateStr = $(this).val();

                    if (expiryDateStr) {
                        var expiryDate = new Date(expiryDateStr);
                        var today = new Date();
                        today.setHours(0, 0, 0, 0); // Reset time to midnight for accurate comparison

                        // Calculate the difference in milliseconds
                        var timeDiff = expiryDate.getTime() - today.getTime();

                        // Convert milliseconds to days
                        var daysLeft = Math.ceil(timeDiff / (1000 * 3600 * 24));

                        $('#total-days-expiry').val(daysLeft + ' วัน');
                    } else {
                        $('#total-days-expiry').val(''); // Clear the field if no expiry date is selected
                    }
                });
            });

            // ปุ่ม Next Step
            // $(document).ready(function() {
            //     $('.btn-success.float-right[data-toggle="tab"]').on('click', function(e) {
            //         e.preventDefault(); // ป้องกันการทำงานเริ่มต้นของลิงก์

            //         var target = $(this).attr('href'); // ดึงค่า href (#profile)

            //         // ทำให้ Tab ที่ถูกคลิก Active
            //         $('#profile-tab').tab('show');

            //         // คุณสามารถเพิ่ม Action อื่นๆ ที่ต้องการให้เกิดขึ้นเมื่อคลิก "Next Step" ที่นี่
            //         console.log('Next Step ถูกคลิก และ Profile Tab ถูกทำให้ Active');
            //     });
            // });


            //คำนวนวันหมดผลโรค 
            $(document).ready(function() {
                $('input[name="labour_disease_issue_date"]').on('change', function() {
                    var issueDateStr = $(this).val();

                    if (issueDateStr) {
                        var issueDate = new Date(issueDateStr);
                        var today = new Date();
                        today.setHours(0, 0, 0, 0);

                        // Calculate the expiry date (issue date + 3 days)
                        var expiryDate = new Date(issueDate.getTime() + (29 * 24 * 60 * 60 * 1000));

                        // Calculate the difference in milliseconds
                        var timeDiff = expiryDate.getTime() - today.getTime();

                        // Convert milliseconds to days
                        var daysLeft = Math.ceil(timeDiff / (1000 * 3600 * 24));

                        $('#total-disease-expiry').val(daysLeft + ' วัน');
                    } else {
                        $('#total-disease-expiry').val('');
                    }
                });
            });
        </script>
    @endsection
