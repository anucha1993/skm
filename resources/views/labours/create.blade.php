@extends('layouts.template')




@section('content')
    <style>
        body {
            font-family: 'Prompt', 'Sarabun', 'Kanit', Arial, sans-serif;
            background: #f4f6fb;
            color: #232946;
        }

        .main-form-container {
            background: none;
            min-height: 100vh;
            padding-top: 4px;
            padding-bottom: 40px;
        }

        .main-form-card {
            border-radius: 16px;
            box-shadow: 0 4px 24px 0 rgba(60, 80, 120, 0.10);
            border: none;
            background: #fff;
            overflow: hidden;
        }

        .main-form-card .card-header {
            background: linear-gradient(90deg, #4f8cff 60%, #a7d8ff 100%);
            color: #fff;
            border-radius: 16px 16px 0 0;
            padding: 1.3rem 2rem 1.1rem 2rem;
            border: none;
            box-shadow: 0 2px 8px rgba(79, 140, 255, 0.10);
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .main-form-card .card-body {
            background: #fff;
            padding: 2rem 1.5rem 1.2rem 1.5rem;
        }

        .main-form-card .card-footer {
            background: #f4f6fb;
            border: none;
            border-radius: 0 0 16px 16px;
            padding: 1.1rem 2rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #e3e8ee;
            margin-bottom: 1.2rem;
            gap: 0.5rem;
        }

        .nav-tabs .nav-link {
            color: #4f8cff;
            font-weight: 600;
            border: none;
            border-radius: 14px 14px 0 0;
            background: #eaf1fb;
            transition: background 0.2s, color 0.2s;
            font-size: 1.08rem;
            padding: 0.8rem 2.1rem 0.8rem 2.1rem;
            margin-right: 0.2rem;
            letter-spacing: 0.5px;
        }

        .nav-tabs .nav-link.active {
            background: #4f8cff;
            color: #fff !important;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(79, 140, 255, 0.10);
        }

        .tab-content {
            background: #f8fafc;
            border-radius: 0 0 14px 14px;
            box-shadow: 0 1px 4px rgba(60, 80, 120, 0.04);
            padding: 2rem 1.2rem 1.2rem 1.2rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: 1.01rem;
            font-weight: 500;
            color: #2d3a5a;
            margin-bottom: 0.18rem;
            letter-spacing: 0.1px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            font-size: 1rem;
            background: #fafdff;
            border: 1px solid #c7d7ef;
            transition: border 0.2s, box-shadow 0.2s;
            box-shadow: 0 1px 4px rgba(79, 140, 255, 0.04);
            padding: 0.55rem 1rem;
            min-height: 38px;
            color: #232946;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4f8cff;
            box-shadow: 0 0 0 2px #e3f0ff;
            background: #f0f6ff;
        }

        .btn-success,
        .btn-primary {
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.08rem;
            padding: 0.55rem 2.1rem;
            background: linear-gradient(90deg, #4f8cff 60%, #a7d8ff 100%);
            border: none;
            color: #fff;
            box-shadow: 0 2px 8px rgba(79, 140, 255, 0.10);
            transition: background 0.2s, box-shadow 0.2s;
        }

        .btn-success:hover,
        .btn-primary:hover {
            background: #357ae8;
            color: #fff;
            box-shadow: 0 4px 16px rgba(79, 140, 255, 0.13);
        }

        .btn-outline-primary,
        .btn-outline-danger {
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.45rem 1.2rem;
        }

        .btn-outline-danger {
            border: 1.5px solid #ff6b6b;
            color: #ff6b6b;
            background: #fff;
            transition: background 0.2s, color 0.2s;
        }

        .btn-outline-danger:hover {
            background: #ff6b6b;
            color: #fff;
        }

        .alert-info {
            border-radius: 10px;
            background: #eaf1fb;
            color: #357ae8;
            border: none;
            font-size: 1rem;
            box-shadow: 0 1px 4px #b6e0fe33;
        }

        .section-divider {
            border-top: 2px solid #e3e8ee;
            margin: 2rem 0 1.5rem 0;
        }

        /* Skill Test Section Modern */
        .skill-test-section {
            background: #fafdff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(79, 140, 255, 0.07);
            padding: 1.3rem 1.1rem 1.1rem 1.1rem;
            margin-bottom: 2rem;
            border: 1.5px solid #c7d7ef;
        }

        .skill-test-section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #357ae8;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.1px;
        }

        .skill-test-badge {
            background: linear-gradient(135deg, #4f8cff 60%, #a7d8ff 100%);
            color: #fff;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: bold;
            margin-right: 0.5rem;
            box-shadow: 0 2px 8px #b6e0fe44;
            border: 2px solid #fff;
        }

        .skill-test-item {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(79, 140, 255, 0.08);
            border: 1.5px solid #e3e8ee;
            background: #fff;
            margin-bottom: 1.2rem;
            position: relative;
            padding: 1.2rem 1rem 0.7rem 1rem;
            transition: box-shadow 0.2s;
        }

        .skill-test-item:hover {
            box-shadow: 0 4px 16px rgba(79, 140, 255, 0.13);
            border-color: #4f8cff;
        }

        .skill-test-item .remove-skill-test {
            position: static;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1.5px solid #ff6b6b;
            color: #ff6b6b;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            min-width: 36px;
            min-height: 36px;
            font-size: 1.15rem;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 1px 4px #ff6b6b22;
            padding: 0;
        }

        .skill-test-item .remove-skill-test i {
            font-size: 1.15rem;
            line-height: 1;
            margin: 0;
        }

        .skill-test-item .remove-skill-test:hover {
            background: #ff6b6b;
            color: #fff;
            box-shadow: 0 2px 8px #ff6b6b44;
        }

        @media (max-width: 768px) {
            .skill-test-item .remove-skill-test {
                width: 30px;
                height: 30px;
                min-width: 30px;
                min-height: 30px;
                font-size: 1rem;
            }

            .skill-test-item .remove-skill-test i {
                font-size: 1rem;
            }
        }

        .col-12.mt-4,
        .col-12.mt-4>b {
            margin-top: 2.2rem !important;
            font-size: 1.08rem;
            color: #232946;
            letter-spacing: 0.2px;
        }

        hr {
            border-top: 1.5px dashed #c7d7ef;
            margin: 0.7rem 0 1.2rem 0;
        }

        .add-skill-test-btn {
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.5rem 1.5rem;
            background: linear-gradient(90deg, #4f8cff 60%, #a7d8ff 100%);
            color: #fff;
            border: none;
            box-shadow: 0 2px 8px rgba(79, 140, 255, 0.08);
            transition: background 0.2s, box-shadow 0.2s, color 0.2s;
            outline: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-skill-test-btn:hover,
        .add-skill-test-btn:focus {
            background: #357ae8;
            color: #fff;
            box-shadow: 0 4px 16px rgba(79, 140, 255, 0.13);
        }

        .add-skill-test-btn i {
            font-size: 1.1rem;
            margin-right: 0.3rem;
        }
    </style>

    <div class="main-form-container">
        <form action="{{ route('labours.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="row justify-content-center" style="margin-left:0;margin-right:0;">
                <div class="col-12 px-0">
                    <div class="card main-form-card mb-4"
                        style="border-radius:22px; box-shadow:0 4px 24px 0 rgba(80,180,255,0.10);">
                        <div class="card-body p-2 p-md-3">
                            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-uppercase fw-bold" id="home-tab" data-toggle="tab"
                                        href="#home" role="tab" aria-controls="home" aria-selected="true">
                                        <i class="fa fa-id-card me-1"></i>ข้อมูลส่วนตัว
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase fw-bold" id="profile-tab" data-toggle="tab"
                                        href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                        <i class="fa fa-user-tie me-1"></i>เจ้าหน้าที่สรรหา
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase fw-bold" id="skilltest-tab" data-toggle="tab"
                                        href="#skilltest" role="tab" aria-controls="skilltest" aria-selected="false">
                                        <i class="fa fa-certificate me-1"></i>ทดสอบฝีมือ
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase fw-bold" id="contact-tab" data-toggle="tab"
                                        href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                        <i class="fa fa-file-alt me-1"></i>ไฟล์เอกสาร
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">คำนำหน้า <span class="text-danger">*</span></label>
                                            <select name="labour_prefix" class="form-select form-select-sm" required>
                                                <option value="">---Select--</option>
                                                <option value="Mr">Mr.</option>
                                                <option value="Ms">Ms.</option>
                                                <option value="Miss">Miss.</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ชื่อ <span class="text-danger">*</span></label>
                                            <input type="text" name="labour_firstname"
                                                class="form-control form-control-sm" required placeholder="ชื่อจริง">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">นามสกุล <span class="text-danger">*</span></label>
                                            <input type="text" name="labour_lastname"
                                                class="form-control form-control-sm" required placeholder="นามสกุล">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">เลขบัตร 13 หลัก <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="labour_idcard_number"
                                                class="form-control form-control-sm" required maxlength="13"
                                                placeholder="เลขบัตรประชาชน">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันเกิด <span class="text-danger">*</span></label>
                                            <input type="date" name="labour_birthday"
                                                class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">อายุ</label>
                                            <input type="text" class="form-control form-control-sm bg-light"
                                                id="total-birthday" placeholder="0 ปี" readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">หนัก </label>
                                            <input type="text" class="form-control form-control-sm bg-light" name="weight"
                                                id="weight" placeholder="ซม." 
                                              >
                                        </div>

                                          <div class="col-md-4">
                                            <label class="form-label">ส่วนสูง</label>
                                            <input type="text" class="form-control form-control-sm bg-light" name="height"
                                                id="height" placeholder="กก." 
                                               >
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">BMI</label>
                                            <input type="text" class="form-control form-control-sm bg-light" 
                                                id="height" placeholder="รอคำนวน..." readonly
                                               >
                                        </div>

                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">เบอร์ติดต่อ <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="labour_phone_one"
                                                class="form-control form-control-sm" required placeholder="เบอร์หลัก">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">เบอร์ติดต่อฉุกเฉิน <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="labour_phone_two"
                                                class="form-control form-control-sm" required placeholder="เบอร์สำรอง">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                                            <input type="email" name="labour_email"
                                                class="form-control form-control-sm" required
                                                placeholder="example@email.com">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Line ID</label>
                                            <input type="text" name="labour_line_id"
                                                class="form-control form-control-sm" placeholder="Line ID">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ชื่อผู้ติดต่อฉุกเฉิน</label>
                                            <input type="text" name="labour_emergency_contact_name"
                                                class="form-control form-control-sm" placeholder="ชื่อผู้ติดต่อฉุกเฉิน">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ประเภทที่อยู่</label>
                                            <select name="labour_address_type" class="form-select form-select-sm">
                                                <option value="">---เลือก---</option>
                                                <option value="ตามบัตรประชาชน">ตามบัตรประชาชน</option>
                                                <option value="ปัจจุบัน">ที่อยู่ปัจจุบัน</option>
                                                <option value="อื่นๆ">อื่นๆ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">ที่อยู่</label>
                                            <textarea name="labour_address" class="form-control form-control-sm" rows="2"
                                                placeholder="บ้านเลขที่ หมู่ ซอย ถนน"></textarea>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">จังหวัด</label>
                                            <input type="text" name="labour_province"
                                                class="form-control form-control-sm" placeholder="จังหวัด">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">เขต/อำเภอ</label>
                                            <input type="text" name="labour_district"
                                                class="form-control form-control-sm" placeholder="เขต/อำเภอ">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">แขวง/ตำบล</label>
                                            <input type="text" name="labour_sub_district"
                                                class="form-control form-control-sm" placeholder="แขวง/ตำบล">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">รหัสไปรษณีย์</label>
                                            <input type="text" name="labour_postcode"
                                                class="form-control form-control-sm" placeholder="รหัสไปรษณีย์"
                                                maxlength="10">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">หมายเหตุ</label>
                                            <textarea name="labour_note" class="form-control form-control-sm" rows="2" placeholder="หมายเหตุเพิ่มเติม"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <b class="">ข้อมูลหนังสือเดินทาง</b>
                                        <hr>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">เลขที่หนังสือเดินทาง</label>
                                            <input type="text" name="labour_passport_number"
                                                class="form-control form-control-sm" placeholder="เลขที่หนังสือเดินทาง">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่ออกหนังสือเดินทาง</label>
                                            <input type="date" name="labour_passport_issue_date"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่หมดอายุหนังสือเดินทาง</label>
                                            <input type="date" name="labour_passport_expiry_date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">จำนวนวันที่จะหมดอายุ</label>
                                            <input type="text" id="total-days-expiry"
                                                class="form-control form-control-sm bg-light" placeholder="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <b class="">ข้อมูลผลตรวจโรค & CID</b>
                                        <hr>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">โรงพยาบาลที่ตรวจโรค</label>
                                            <select name="labour_hospital" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @if (!empty($hospitalGlobalSet))
                                                    @php $values = $hospitalGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันรับผลโรค</label>
                                            <input type="date" name="labour_disease_receive_date"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันออกผลโรค</label>
                                            <input type="date" name="labour_disease_issue_date"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">ผลโรคอายุ (คำนวน 30 วัน)</label>
                                            <input type="text" id="total-disease-expiry" readonly
                                                class="form-control form-control-sm bg-light" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <b class="">ข้อมูลรายละเอียดงาน & จัดเก็บเอกสาร</b>
                                        <hr>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">บริษัทนายจ้าง</label>
                                            <select name="company_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @forelse ($customers as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">เลขที่ใบสมัคร</label>
                                            <input type="text" name="labour_register_number"
                                                class="form-control form-control-sm" placeholder="Register Number.">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">การจัดเก็บเอกสาร</label>
                                            <select name="managedoc_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @forelse ($manageDocs as $item)
                                                    <option value="{{ $item->managedoc_id }}">{{ $item->managedoc_name }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">ประเทศสมัครงาน</label>
                                            <select name="country_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @if (!empty($countryGlobalSet))
                                                    @php $values = $countryGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">กลุ่มงาน</label>
                                            <select name="job_group_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @if (!empty($jobGroupGlobalSet))
                                                    @php $values = $jobGroupGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4 ">
                                            <label class="form-label">ตำแหน่ง</label>
                                            <select name="position_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @if (!empty($positionGlobalSet))
                                                    @php $values = $positionGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">สถานะ <span class="text-danger">*</span></label>
                                            <select name="labour_status" class="form-select form-select-sm" required>
                                                <option value="">--Select--</option>
                                                @if (!empty($statusGlobalSet))
                                                    @php $values = $statusGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">บันทึกเพิ่มเติม</label>
                                            <textarea name="labour_note" class="form-control form-control-sm" rows="2" placeholder="Note.."></textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- /// --}}
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby=คำนำหน้า
                                    *"profile-tab">

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">เจ้าหน้าที่สรรหา</label>
                                            <select name="staff_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @if (!empty($StaffGlobalSet))
                                                    @php $values = $StaffGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">ชื่อสาย</label>
                                            <select name="staff_sub_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @if (!empty($StaffsubGlobalSet))
                                                    @php $values = $StaffsubGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}">{{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="skilltest" role="tabpanel"
                                    aria-labelledby="skilltest-tab">
                                    <div class="col-12 mt-4">

                                        <div
                                            class="d-flex justify-content-between align-items-center mb-3 skill-test-section-title">
                                            <span><i class="fa fa-certificate me-1 text-primary"></i> ข้อมูลการทดสอบฝีมือ
                                                (Skill Test)</span>
                                            <button type="button" class="add-skill-test-btn" id="add-skill-test">
                                                <i class="fa fa-plus"></i> เพิ่มรายการทดสอบฝีมือ
                                            </button>
                                        </div>
                                        <hr class="mb-3 mt-0" style="border-top:1.5px dashed #b6e0fe;">
                                        <div id="skill-test-list">
                                            <div class="skill-test-item skill-test-modern mb-3 p-3"
                                                style="background:rgba(255,255,255,0.95); border-radius:18px; box-shadow:0 2px 8px 0 rgba(80,180,255,0.07); border:1.5px solid #e3f0fa;">
                                                <div class="row align-items-end g-2">
                                                    <div class="col-md-1 col-2 text-center">
                                                        <span class="skill-test-badge">1</span>
                                                    </div>
                                                    <div class="col-md-2 col-6 mb-2">
                                                        <label class="form-label mb-1">วันที่สอบ</label>
                                                        <input type="date" name="skill_tests[0][test_date]"
                                                            class="form-control form-control-sm" />
                                                    </div>
                                                    <div class="col-md-3 col-6 mb-2">
                                                        <label class="form-label mb-1">สถานที่สอบ</label>
                                                        <select name="skill_tests[0][test_location_id]"
                                                            class="form-select form-select-sm">
                                                            <option value="">--Select--</option>
                                                            @if (!empty($ExaminationCenterGlobalSet))
                                                                @php $values = $ExaminationCenterGlobalSet->values; @endphp
                                                                @foreach ($values as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-6 mb-2">
                                                        <label class="form-label mb-1">นายจ้าง</label>
                                                        <select name="skill_tests[0][customer_id]"
                                                            class="form-select form-select-sm">
                                                            <option value="">--Select--</option>
                                                            @forelse ($customers as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 col-6 mb-2">
                                                        <label class="form-label mb-1">สถานที่สอบ</label>
                                                        <select name="skill_tests[0][customer_id]"
                                                            class="form-select form-select-sm">
                                                            <option value="">--Select--</option>
                                                            @if (!empty($ExaminationCenterGlobalSet))
                                                                @php $values = $ExaminationCenterGlobalSet->values; @endphp
                                                                @foreach ($values as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1 col-2 text-center">
                                                        
                                                    </div>

                                                    <div class="col-md-2 col-6 mb-2">
                                                        <label class="form-label mb-1">ตำแหน่งที่สอบ</label>
                                                        <select name="skill_tests[0][test_position_id]"
                                                            class="form-select form-select-sm">
                                                            <option value="">--Select--</option>
                                                            @if (!empty($positionGlobalSet))
                                                                @php $values = $positionGlobalSet->values; @endphp
                                                                @foreach ($values as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 col-6 mb-2">
                                                        <label class="form-label mb-1">ผลการสอบ</label>
                                                        <select name="skill_tests[0][test_result_id]"
                                                            class="form-select form-select-sm">
                                                            <option value="">--Select--</option>
                                                            @if (!empty($statusTestGlobalSet))
                                                                @php $values = $statusTestGlobalSet->values; @endphp
                                                                @foreach ($values as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-6 mb-2">
                                                        <label class="form-label mb-1">หมายเหตุ</label>
                                                        <input type="text" name="skill_tests[0][note]"
                                                            class="form-control form-control-sm" placeholder="หมายเหตุ" />
                                                    </div>
                                                    <div
                                                        class="col-md-1 col-2 d-flex align-items-center justify-content-center mb-2">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm remove-skill-test"
                                                            style="display:none;">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="alert alert-info mt-3">คุณจำเป็นต้องบันทึกข้อมูลก่อนจึงจะสามารถ Uploads
                                        ไฟล์เอกสารลงระบบได้</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold">
                                <i class="fa fa-save me-1"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

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

        // Dynamic Skill Test Form (UI modern)
        $(document).ready(function() {
            let skillTestIndex = 1;
            $('#add-skill-test').click(function() {
                let html = $('.skill-test-item:first').clone();
                html.find('input, select').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/, '[' + skillTestIndex + ']');
                        $(this).attr('name', name);
                        $(this).val('');
                    }
                });
                html.find('.remove-skill-test').show();
                $('#skill-test-list').append(html);
                skillTestIndex++;
            });
            $(document).on('click', '.remove-skill-test', function() {
                if ($('.skill-test-item').length > 1) {
                    $(this).closest('.skill-test-item').remove();
                }
            });
        });

        // Dynamic Skill Test Form (UI modern, index update)
        $(document).ready(function() {
            let skillTestIndex = 1;
            $('#add-skill-test').off('click').on('click', function() {
                let html = $('.skill-test-item:first').clone();
                html.find('input, select').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/\[\d+\]/, '[' + skillTestIndex + ']');
                        $(this).attr('name', name);
                        $(this).val('');
                    }
                });
                html.find('.remove-skill-test').show();
                $('#skill-test-list').append(html);
                updateSkillTestIndexes();
                skillTestIndex++;
            });
            $(document).on('click', '.remove-skill-test', function() {
                if ($('.skill-test-item').length > 1) {
                    $(this).closest('.skill-test-item').remove();
                    updateSkillTestIndexes();
                }
            });

            function updateSkillTestIndexes() {
                $('#skill-test-list .skill-test-item').each(function(i) {
                    $(this).find('.skill-test-badge').text(i + 1);
                    $(this).find('input, select').each(function() {
                        let name = $(this).attr('name');
                        if (name) {
                            name = name.replace(/skill_tests\[\d+\]/, 'skill_tests[' + i + ']');
                            $(this).attr('name', name);
                        }
                    });
                });
            }
            updateSkillTestIndexes();
        });
    </script>
@endsection
