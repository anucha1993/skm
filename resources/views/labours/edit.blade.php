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
    <form action="{{ route('labours.update', $labour->labour_id) }}" method="POST">
        @csrf
        @method('PUT')
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
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="col-md-12">
                                    <div class="pro-head ">
                                        <a target="_blink"
                                            href="{{ $labour->labour_image_thumbnail_path
                                                ? asset('storage/' . $labour->labour_image_path)
                                                : asset('/template/dist/assets/images/user/avatar-1.jpg') }}">
                                            <img id="thumb-preview"
                                                src="{{ $labour->labour_image_thumbnail_path
                                                    ? asset('storage/' . $labour->labour_image_thumbnail_path)
                                                    : asset('/template/dist/assets/images/user/avatar-1.jpg') }}"
                                                class="img-radius rounded-circle"
                                                style="width:150px;height:150px;object-fit:cover;">
                                        </a>
                                        <br>
                                        <input type="file" name="image_profile" id="image_profile" class="mt-2">
                                    </div>

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
                                                    <select name="labour_prefix" class="form-control form-control-sm"
                                                        required>
                                                        <option value="">---Select--</option>
                                                        <option @if ($labour->labour_prefix === 'Mr') selected @endif
                                                            value="Mr">Mr.</option>
                                                        <option @if ($labour->labour_prefix === 'Ms') selected @endif
                                                            value="Ms">Ms.</option>
                                                        <option @if ($labour->labour_prefix === 'Miss') selected @endif
                                                            value="Miss">Miss.</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-4 col-form-label-sm text-right">เลขบัตร
                                                    13
                                                    หลัก <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="labour_idcard_number"
                                                        value="{{ $labour->labour_idcard_number }}"
                                                        class="form-control form-control-sm" required
                                                        placeholder="เลขบัตรประจำตัวประชาชน 13 หลัก">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row container">

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-4 col-form-label-sm text-right">ชื่อ
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="labour_firstname"
                                                        value="{{ $labour->labour_firstname }}"
                                                        class="form-control form-control-sm" required
                                                        placeholder="Firstname">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-4 col-form-label-sm text-right">นามสกุล
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="labour_lastname"
                                                        value="{{ $labour->labour_lastname }}"
                                                        class="form-control form-control-sm" required
                                                        placeholder="Firstname">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for=""
                                                    class="col-sm-4 col-form-label-sm text-right">วันเกิด
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="date" name="labour_birthday"
                                                        value="{{ $labour->labour_birthday }}"
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
                                                <label for=""
                                                    class="col-sm-4 col-form-label-sm text-right">เบอร์ติดต่อ
                                                    <span class="text-danger">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="labour_phone_one"
                                                        value="{{ $labour->labour_phone_one }}"
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
                                                        value="{{ $labour->labour_phone_two }}"
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
                                                    value="{{ $labour->labour_passport_number }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="เลขที่หนังสือเดินทาง">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for=""
                                                class="col-sm-4 col-form-label-sm text-right">วันที่ออกหนังสือเดินทาง
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="date" name="labour_passport_issue_date"
                                                    value="{{ $labour->labour_passport_issue_date }}"
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
                                                    value="{{ $labour->labour_passport_expiry_date }}"
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
                                                    @if (!empty($hospitalGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $hospitalGlobalSet->values;
                                                            if (
                                                                $hospitalGlobalSet->sort_order_preference ==
                                                                'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->labour_hospital) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}
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
                                                <input type="date" name="labour_disease_receivedate"
                                                    value="{{ $labour->labour_disease_receivedate }}"
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
                                                    value="{{ $labour->labour_disease_issue_date }}"
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
                                                        <option @if ($item->id === $labour->company_id) selected @endif
                                                            value="{{ $item->id }}">{{ $item->name }}
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
                                                <input type="text" name="labour_register_number"
                                                    class="form-control form-control-sm" placeholder="Register Number."
                                                    value="{{ $labour->labour_register_number }}">
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
                                                        <option @if ($item->managedoc_id === $labour->managedoc_id) selected @endif
                                                            value="{{ $item->managedoc_id }}">
                                                            {{ $item->managedoc_name }}</option>
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
                                                    @if (!empty($countryGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $countryGlobalSet->values;
                                                            if (
                                                                $countryGlobalSet->sort_order_preference ==
                                                                'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->country_id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}
                                                            </option>
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
                                                    @if (!empty($jobGroupGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $jobGroupGlobalSet->values;
                                                            if (
                                                                $jobGroupGlobalSet->sort_order_preference ==
                                                                'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->job_group_id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}
                                                            </option>
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
                                                    @if (!empty($positionGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $positionGlobalSet->values;
                                                            if (
                                                                $positionGlobalSet->sort_order_preference ==
                                                                'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->position_id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}
                                                            </option>
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
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">สถานะ
                                                <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <select name="labour_status" class="form-control form-control-sm"
                                                    required>
                                                    <option value="">--Select--</option>
                                                    @if (!empty($statusGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $statusGlobalSet->values;
                                                            if (
                                                                $statusGlobalSet->sort_order_preference ==
                                                                'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->labour_status) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
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
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">ศูนย์สอบ
                                            </label>
                                            <div class="col-sm-8">
                                                <select name="lacation_test_id" class="form-control form-control-sm">
                                                    <option value="">--Select--</option>
                                                    @if (!empty($ExaminationCenterGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $ExaminationCenterGlobalSet->values;
                                                            if (
                                                                $ExaminationCenterGlobalSet->sort_order_preference ==
                                                                'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->lacation_test_id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}</option>
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
                                                <input type="date" class="form-control form-control-sm">
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
                                                <select name="staff_id" class="form-control form-control-sm">
                                                    <option value="">--Select--</option>
                                                    @if (!empty($StaffGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $StaffGlobalSet->values;
                                                            if (
                                                                $StaffGlobalSet->sort_order_preference == 'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->staff_id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}</option>
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
                                                <select name="staff_sub_id" class="form-control form-control-sm">
                                                    <option value="">--Select--</option>
                                                    @if (!empty($StaffsubGlobalSet))
                                                        @php
                                                            // ถ้าต้องการเรียงลำดับแบบ alphabetical
                                                            $values = $StaffsubGlobalSet->values;
                                                            if (
                                                                $StaffsubGlobalSet->sort_order_preference ==
                                                                'alphabetical'
                                                            ) {
                                                                $values = $values->sortBy('value');
                                                            }
                                                        @endphp
                                                        @foreach ($values as $item)
                                                            <option @if ($item->id === $labour->staff_sub_id) selected @endif
                                                                value="{{ $item->id }}">{{ $item->value }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 20px;">#</th>
                                                <th>Code</th>
                                                <th>ชื่อเอกสาร</th>
                                                <th class="text-center" style="width:80px;"> Step</th>
                                                <th style="width:180px;">Action</th>
                                                <th class="text-center" style="width:100px;">Updated</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listFiles as $i => $item)
                                                <tr data-id="{{ $item->list_file_id }}">
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $item->managefile_code }}</td>
                                                    <td>{{ $item->managefile_name }}</td>
                                                    <td class="text-center">
                                                        {{ $item->managefile_step }}

                                                    </td>
                                                    <td>
                                                        @if ($item->file_path)
                                                            <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                target="_blank" class="btn btn-info btn-sm me-1">
                                                                <i class="fa fa-eye"></i>
                                                            </a>

                                                            <a href="{{ route('labours.list-files.download', $item) }}"
                                                                class="btn btn-success btn-sm me-1">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                            <a class="btn btn-danger btn-sm btn-delete"
                                                                data-url="{{ route('labours.list-files.destroy', $item) }}">
                                                                <i class="fa fa-trash text-white"></i>
                                                            </a>
                                                        @else
                                                            <input type="file"
                                                                class="form-control form-control-sm file-input"
                                                                data-upload="{{ route('labours.list-files.upload', [$labour->labour_id, $item->list_file_id]) }}">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $item->file_path ? date('d-m-Y', strtotime($item->updated_at)) : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success text-white float-right"> บันทึกข้อมูล</button>
            </div>
    </form>

    <script>
        $(function() {
            // อัปโหลดไฟล์ (แทนที่ไอคอน + input → ปุ่ม)
            $(document).on('change', '.file-input', function() {
                const $row = $(this).closest('tr');
                const id = $row.data('id');
                const url = $(this).data('upload');
                const fd = new FormData();
                fd.append('file', this.files[0]);

                $.ajax({
                    url,
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success(res) {
                        // แทนที่ cell ไฟล์
                        $row.find('td').eq(3)
                            .html('<i class="fa fa-file-earmark-fill fs-3"></i>');
                        // แทนที่ cell Action
                        const btns = `
                  <a href="${res.url}" target="_blank" class="btn btn-info btn-sm me-1">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="${res.download}" class="btn btn-success btn-sm me-1">
                    <i class="fa fa-download"></i>
                  </a>
                  <button class="btn btn-danger btn-sm btn-delete" data-url="${res.destroy}">
                    <i class="fa fa-trash"></i>
                  </button>`;
                        $row.find('td').eq(4).html(btns);
                        // อัปเดตวันที่
                        $row.find('td').eq(5).text(res.updated);
                    },
                    error(err) {
                        alert(err.responseJSON?.message || 'อัปโหลดไม่สำเร็จ');
                    }
                });
            });

            // ลบไฟล์ (แทนที่กลับเป็น input)
            $(document).on('click', '.btn-delete', function() {
                if (!confirm('ยืนยันการลบไฟล์?')) return;
                const $row = $(this).closest('tr');
                const url = $(this).data('url');

                $.ajax({
                    url,
                    type: 'DELETE',
                    success() {
                        // ไอคอนไฟล์
                        $row.find('td').eq(3)
                            .html('<i class="fa fa-file-earmark-slash fs-3 text-muted"></i>');
                        // คืน input
                        const id = $row.data('id');
                        const inp =
                            `<input type="file" 
                                    class="form-control form-control-sm file-input"
                                    data-upload="{{ route('labours.list-files.upload', [$labour->labour_id, '__ID__']) }}">`
                            .replace('__ID__', id);
                        $row.find('td').eq(4).html(inp);
                        // วันที่
                        $row.find('td').eq(5).text('-');
                    },
                    error(err) {
                        alert(err.responseJSON?.message || 'ลบไม่สำเร็จ');
                    }
                });
            });
        });
    </script>

    <script>
        $(function() {
            $('#image_profile').on('change', function(e) {
                let file = this.files[0];
                if (!file) return;

                let formData = new FormData();
                formData.append('image_profile', file);

                $.ajax({
                    url: '{{ url("/labours/$labour->labour_id/image-profile") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend() {
                        // แสดงโหลดดิ้งถ้าจำเป็น
                    },
                    success(res) {
                        if (res.status) {
                            // เปลี่ยนรูปทันที
                            $('#thumb-preview').attr('src', res.thumbnail_url + '?' + Date.now());
                        } else {
                            alert(res.message || 'Upload failed');
                        }
                    },
                    error(xhr) {
                        alert(xhr.responseJSON?.message || 'เกิดข้อผิดพลาดในการอัปโหลด');
                    }
                });
            });
        });
    </script>



    <script>
        //คำนวนอายุ
        $(document).ready(function() {
            function calculateAge() {
                var birthdayStr = $('input[name="labour_birthday"]').val();
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
                            var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 0).getDate();
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

                    $('#total-birthday').val(ageString);

                } else {
                    $('#total-birthday').val('');
                }
            }
            calculateAge();
            $('input[name="labour_birthday"]').on('change', calculateAge);
        });
        /// ---- ////

        $(document).ready(function() {
            function calculatePassportExpiry() {
                var expiryDateStr = $('input[name="labour_passport_expiry_date"]').val();

                if (expiryDateStr) {
                    var expiryDate = new Date(expiryDateStr);
                    var today = new Date();
                    today.setHours(0, 0, 0, 0); // Reset time to midnight for accurate comparison

                    var timeDiff = expiryDate.getTime() - today.getTime();
                    var daysLeft = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    $('#total-days-expiry').val(daysLeft + ' วัน');
                } else {
                    $('#total-days-expiry').val(''); // Clear the field if no expiry date is selected
                }
            }

            function calculateDiseaseExpiry() {
                var issueDateStr = $('input[name="labour_disease_issue_date"]').val();

                if (issueDateStr) {
                    var issueDate = new Date(issueDateStr);
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);

                    // Calculate the expiry date (issue date + 29 days)
                    var expiryDate = new Date(issueDate.getTime() + (29 * 24 * 60 * 60 * 1000));

                    var timeDiff = expiryDate.getTime() - today.getTime();
                    var daysLeft = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    $('#total-disease-expiry').val(daysLeft + ' วัน');
                } else {
                    $('#total-disease-expiry').val('');
                }
            }

            function calculateAge() {
                var birthdayStr = $('input[name="labour_birthday"]').val();
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
                            var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 0).getDate();
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
            }

            // เรียกฟังก์ชันคำนวณทั้งหมดเมื่อหน้าเว็บโหลด
            calculateAge();
            calculatePassportExpiry();
            calculateDiseaseExpiry();
            // ยังคงให้มีการคำนวณเมื่อมีการเปลี่ยนแปลงค่าใน Input ด้วย
            $('input[name="labour_birthday"]').on('change', calculateAge);
            $('input[name="labour_passport_expiry_date"]').on('change', calculatePassportExpiry);
            $('input[name="labour_disease_issue_date"]').on('change', calculateDiseaseExpiry);
        });
    </script>
@endsection
