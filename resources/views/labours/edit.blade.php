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
            background: linear-gradient(90deg, #4fffb6 60%, #a7d8ff 100%);
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
        <form action="{{ route('labours.update', $labour->labour_id) }}" method="POST" class="needs-validation" novalidate
            id="formUpdate">
            @csrf
            @method('put')
            <div class="row justify-content-center" style="margin-left:0;margin-right:0;">
                <div class="col-12 px-0">
                    <div class="card main-form-card mb-4"
                        style="border-radius:22px; box-shadow:0 4px 24px 0 rgba(80,180,255,0.10);">
                        <div class="card-body p-2 p-md-3">
                            <!-- รูปโปรไฟล์ -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-12 ">
                                    <label class="form-label">รูปโปรไฟล์</label><br>
                                    <a target="_blank"
                                        href="{{ $labour->labour_image_thumbnail_path ? asset('storage/' . $labour->labour_image_path) : asset('/template/dist/assets/images/user/avatar-1.jpg') }}">
                                        <img id="thumb-preview"
                                            src="{{ $labour->labour_image_thumbnail_path ? asset('storage/' . $labour->labour_image_thumbnail_path) : asset('/template/dist/assets/images/user/avatar-1.jpg') }}"
                                            class="img-radius rounded-circle"
                                            style="width:150px;height:150px;object-fit:cover;">
                                    </a>
                                    <br>
                                    <input type="file" name="image_profile" id="image_profile" class="mt-2">
                                </div>
                            </div>

                            <!-- Step เอกสาร -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Step เอกสาร</label>
                                    <div class="d-flex gap-2">
                                        @foreach (['A', 'B'] as $step)
                                            @php $done = in_array($step, $labour->completed_steps ?? []); @endphp
                                            <span class="badge bg-{{ $done ? 'success' : 'secondary' }}">
                                                Step {{ $step }} {{ $done ? 'ครบ' : 'ยังไม่ครบ' }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

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
                                    <a class="nav-link text-uppercase fw-bold" id="finance-tab" data-toggle="tab"
                                        href="#finance" role="tab" aria-controls="finance" aria-selected="false">
                                        <i class="fas fa-coins me-1"></i>การเงินและบัญชี
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
                                                <option value="Mr" @if ($labour->labour_prefix == 'Mr') selected @endif>Mr.
                                                </option>
                                                <option value="Ms" @if ($labour->labour_prefix == 'Ms') selected @endif>Ms.
                                                </option>
                                                <option value="Miss" @if ($labour->labour_prefix == 'Miss') selected @endif>
                                                    Miss.</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ชื่อ <span class="text-danger">*</span></label>
                                            <input type="text" name="labour_firstname"
                                                class="form-control form-control-sm" required placeholder="ชื่อจริง"
                                                value="{{ $labour->labour_firstname }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">นามสกุล <span class="text-danger">*</span></label>
                                            <input type="text" name="labour_lastname"
                                                class="form-control form-control-sm" required placeholder="นามสกุล"
                                                value="{{ $labour->labour_lastname }}">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">เลขบัตร 13 หลัก <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="labour_idcard_number"
                                                class="form-control form-control-sm" required maxlength="13"
                                                placeholder="เลขบัตรประชาชน" value="{{ $labour->labour_idcard_number }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันเกิด <span class="text-danger">*</span></label>
                                            <input type="date" name="labour_birthday"
                                                class="form-control form-control-sm" required
                                                value="{{ $labour->labour_birthday }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">อายุ</label>
                                            <input type="text" class="form-control form-control-sm bg-light"
                                                id="total-birthday" placeholder="0 ปี" readonly
                                                value="{{ $labour->total_birthday ?? '' }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">หนัก </label>
                                            <input type="text" class="form-control form-control-sm bg-light"
                                                name="weight" id="weight" placeholder="ซม."
                                                value="{{ $labour->weight ?? '' }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">ส่วนสูง</label>
                                            <input type="text" class="form-control form-control-sm bg-light"
                                                name="height" id="height" placeholder="กก."
                                                value="{{ $labour->height ?? '' }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">BMI</label>
                                            <input type="text" class="form-control form-control-sm bg-light"
                                                id="height" placeholder="รอคำนวน..." readonly
                                                value="{{ $labour->bmi ?? '' }}">
                                        </div>

                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">เบอร์ติดต่อ <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="labour_phone_one"
                                                class="form-control form-control-sm" required placeholder="เบอร์หลัก"
                                                value="{{ $labour->labour_phone_one }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">เบอร์ติดต่อฉุกเฉิน <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="labour_phone_two"
                                                class="form-control form-control-sm" required placeholder="เบอร์สำรอง"
                                                value="{{ $labour->labour_phone_two }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                                            <input type="email" name="labour_email"
                                                class="form-control form-control-sm" required
                                                placeholder="example@email.com" value="{{ $labour->labour_email }}">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Line ID</label>
                                            <input type="text" name="labour_line_id"
                                                class="form-control form-control-sm" placeholder="Line ID"
                                                value="{{ $labour->labour_line_id }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ชื่อผู้ติดต่อฉุกเฉิน</label>
                                            <input type="text" name="labour_emergency_contact_name"
                                                class="form-control form-control-sm" placeholder="ชื่อผู้ติดต่อฉุกเฉิน"
                                                value="{{ $labour->labour_emergency_contact_name }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ประเภทที่อยู่</label>
                                            <select name="labour_address_type" class="form-select form-select-sm">
                                                <option value="">---เลือก---</option>
                                                <option value="ตามบัตรประชาชน"
                                                    @if ($labour->labour_address_type == 'ตามบัตรประชาชน') selected @endif>ตามบัตรประชาชน
                                                </option>
                                                <option value="ปัจจุบัน" @if ($labour->labour_address_type == 'ปัจจุบัน') selected @endif>
                                                    ที่อยู่ปัจจุบัน</option>
                                                <option value="อื่นๆ" @if ($labour->labour_address_type == 'อื่นๆ') selected @endif>
                                                    อื่นๆ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">ที่อยู่</label>
                                            <textarea name="labour_address" class="form-control form-control-sm" rows="2"
                                                placeholder="บ้านเลขที่ หมู่ ซอย ถนน">{{ $labour->labour_address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">จังหวัด</label>
                                            <input type="text" name="labour_province"
                                                class="form-control form-control-sm" placeholder="จังหวัด"
                                                value="{{ $labour->labour_province }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">เขต/อำเภอ</label>
                                            <input type="text" name="labour_district"
                                                class="form-control form-control-sm" placeholder="เขต/อำเภอ"
                                                value="{{ $labour->labour_district }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">แขวง/ตำบล</label>
                                            <input type="text" name="labour_sub_district"
                                                class="form-control form-control-sm" placeholder="แขวง/ตำบล"
                                                value="{{ $labour->labour_sub_district }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">รหัสไปรษณีย์</label>
                                            <input type="text" name="labour_postcode"
                                                class="form-control form-control-sm" placeholder="รหัสไปรษณีย์"
                                                maxlength="10" value="{{ $labour->labour_postcode }}">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">หมายเหตุ</label>
                                            <textarea name="labour_note" class="form-control form-control-sm" rows="2" placeholder="หมายเหตุเพิ่มเติม">{{ $labour->labour_note }}</textarea>
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
                                                class="form-control form-control-sm" placeholder="เลขที่หนังสือเดินทาง"
                                                value="{{ $labour->labour_passport_number }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่ออกหนังสือเดินทาง</label>
                                            <input type="date" name="labour_passport_issue_date"
                                                class="form-control form-control-sm"
                                                value="{{ $labour->labour_passport_issue_date }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่หมดอายุหนังสือเดินทาง</label>
                                            <input type="date" name="labour_passport_expiry_date"
                                                class="form-control form-control-sm"
                                                value="{{ $labour->labour_passport_expiry_date }}">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">จำนวนวันที่จะหมดอายุ</label>
                                            <input type="text" id="total-days-expiry"
                                                class="form-control form-control-sm bg-light" placeholder="0" readonly
                                                value="{{ old('total_days_expiry', isset($labour->total_days_expiry) ? $labour->total_days_expiry : '') }}">
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
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $labour->labour_hospital) selected @endif>
                                                            {{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันรับผลโรค</label>
                                            <input type="date" name="labour_disease_receive_date"
                                                class="form-control form-control-sm"
                                                value="{{ $labour->labour_disease_receive_date }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันออกผลโรค</label>
                                            <input type="date" name="labour_disease_issue_date"
                                                class="form-control form-control-sm"
                                                value="{{ $labour->labour_disease_issue_date }}">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">ผลโรคอายุ (คำนวน 30 วัน)</label>
                                            <input type="text" id="total-disease-expiry" readonly
                                                class="form-control form-control-sm bg-light" placeholder="0"
                                                value="{{ old('total_disease_expiry', isset($labour->total_disease_expiry) ? $labour->total_disease_expiry : '') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <b class="">ข้อมูล CID</b>
                                        <hr>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">เลขที่ CID</label>
                                            <input type="text" name="labour_cid_number"
                                                class="form-control form-control-sm" placeholder="CID Number"
                                                value="{{ old('labour_cid_number', $labour->labour_cid_number ?? '') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">วันที่ยื่น CID</label>
                                            <input type="date" name="labour_cid_stand_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('labour_cid_stand_date', $labour->labour_cid_stand_date ?? '') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">วันที่ออก CID</label>
                                            <input type="date" name="labour_cid_issue_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('labour_cid_issue_date', $labour->labour_cid_issue_date ?? '') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">วันที่หมดอายุ CID</label>
                                            <input type="date" name="labour_cid_expiry_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('labour_cid_expiry_date', $labour->labour_cid_expiry_date ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <b class="">ข้อมูล Affidavit</b>
                                        <hr>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">เลขที่ Affidavit</label>
                                            <input type="text" name="labour_affidavit_number"
                                                class="form-control form-control-sm" placeholder="Affidavit Number"
                                                value="{{ old('labour_affidavit_number', $labour->labour_affidavit_number ?? '') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่ออก Affidavit</label>
                                            <input type="date" name="labour_affidavit_issue_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('labour_affidavit_issue_date', $labour->labour_affidavit_issue_date ?? '') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่หมดอายุ Affidavit</label>
                                            <input type="date" name="labour_affidavit_expiry_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('labour_affidavit_expiry_date', $labour->labour_affidavit_expiry_date ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <b class="">ข้อมูล VISA</b>
                                        <hr>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">สถานะ VISA</label>
                                            <select name="labour_visa_status" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                <option value="รอดำเนินการ" {{ old('labour_visa_status', $labour->labour_visa_status ?? '') == 'รอดำเนินการ' ? 'selected' : '' }}>รอดำเนินการ</option>
                                                <option value="ยื่นแล้ว" {{ old('labour_visa_status', $labour->labour_visa_status ?? '') == 'ยื่นแล้ว' ? 'selected' : '' }}>ยื่นแล้ว</option>
                                                <option value="อนุมัติ" {{ old('labour_visa_status', $labour->labour_visa_status ?? '') == 'อนุมัติ' ? 'selected' : '' }}>อนุมัติ</option>
                                                <option value="ไม่อนุมัติ" {{ old('labour_visa_status', $labour->labour_visa_status ?? '') == 'ไม่อนุมัติ' ? 'selected' : '' }}>ไม่อนุมัติ</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่ยื่น VISA</label>
                                            <input type="date" name="labour_visa_submission_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('labour_visa_submission_date', $labour->labour_visa_submission_date ?? '') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">วันที่อนุมัติ VISA</label>
                                            <input type="date" name="labour_visa_approval_date"
                                                class="form-control form-control-sm"
                                                value="{{ old('labour_visa_approval_date', $labour->labour_visa_approval_date ?? '') }}">
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
                                                    <option value="{{ $item->id }}"
                                                        @if ($item->id == $labour->company_id) selected @endif>
                                                        {{ $item->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">เลขที่ใบสมัคร</label>
                                            <input type="text" name="labour_register_number"
                                                class="form-control form-control-sm" placeholder="Register Number."
                                                value="{{ $labour->labour_register_number }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">การจัดเก็บเอกสาร</label>
                                            <select name="managedoc_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @forelse ($manageDocs as $item)
                                                    <option value="{{ $item->managedoc_id }}"
                                                        @if ($item->managedoc_id == $labour->managedoc_id) selected @endif>
                                                        {{ $item->managedoc_name }}</option>
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
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $labour->country_id) selected @endif>
                                                            {{ $item->value }}</option>
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
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $labour->job_group_id) selected @endif>
                                                            {{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">ตำแหน่ง</label>
                                            <select name="position_id" class="form-select form-select-sm">
                                                <option value="">--Select--</option>
                                                @if (!empty($positionGlobalSet))
                                                    @php $values = $positionGlobalSet->values; @endphp
                                                    @foreach ($values as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $labour->position_id) selected @endif>
                                                            {{ $item->value }}</option>
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
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $labour->labour_status) selected @endif>
                                                            {{ $item->value }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">บันทึกเพิ่มเติม</label>
                                            <textarea name="labour_note" class="form-control form-control-sm" rows="2" placeholder="Note..">{{ $labour->labour_note }}</textarea>
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
                                            @if (!empty($skillTests) && count($skillTests) > 0)

                                                @foreach ($skillTests as $i => $test)
                                                    <div class="skill-test-item skill-test-modern mb-3 p-3"
                                                        style="background:rgba(255,255,255,0.95); border-radius:18px; box-shadow:0 2px 8px 0 rgba(80,180,255,0.07); border:1.5px solid #e3f0fa;">
                                                        <div class="row align-items-end g-2">
                                                            <div class="col-md-1 col-2 text-center">
                                                                <span
                                                                    class="skill-test-badge bg-success text-white">{{ $i + 1 }}</span>
                                                            </div>
                                                            <div class="col-md-2 col-6 mb-2">
                                                                <label
                                                                    class="form-label mb-1 text-success">วันที่สอบ</label>
                                                                <input type="date"
                                                                    name="skill_tests[{{ $i }}][test_date]"
                                                                    class="form-control form-control-sm border-success"
                                                                    value="{{ $test->test_date ?? '' }}" />
                                                            </div>
                                                            <div class="col-md-3 col-6 mb-2">
                                                                <label class="form-label mb-1 text-success">นายจ้าง</label>
                                                                <select
                                                                    name="skill_tests[{{ $i }}][customer_id]"
                                                                    class="form-select form-select-sm border-success">
                                                                    <option value="">--Select--</option>
                                                                    @forelse ($customers as $item)
                                                                        <option value="{{ $item->id }}"
                                                                            @if ($item->id == $test->customer_id) selected @endif>
                                                                            {{ $item->name }}</option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </div>

                                                            <div class="col-md-3 col-6 mb-2">
                                                                <label
                                                                    class="form-label mb-1 text-success">สถานที่สอบ</label>
                                                                <select
                                                                    name="skill_tests[{{ $i }}][test_location_id]"
                                                                    class="form-select form-select-sm border-success">
                                                                    <option value="">--Select--</option>
                                                                    @if (!empty($ExaminationCenterGlobalSet))
                                                                        @php $values = $ExaminationCenterGlobalSet->values; @endphp
                                                                        @foreach ($values as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                @if ($item->id == $test->test_location_id) selected @endif>
                                                                                {{ $item->value }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 col-6 mb-2">
                                                                <label
                                                                    class="form-label mb-1 text-success">ตำแหน่งที่สอบ</label>
                                                                <select
                                                                    name="skill_tests[{{ $i }}][test_position_id]"
                                                                    class="form-select form-select-sm border-success">
                                                                    <option value="">--Select--</option>
                                                                    @if (!empty($positionGlobalSet))
                                                                        @php $values = $positionGlobalSet->values; @endphp
                                                                        @foreach ($values as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                @if ($item->id == $test->test_position_id) selected @endif>
                                                                                {{ $item->value }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1 col-2 text-center">

                                                            </div>
                                                            <div class="col-md-2 col-6 mb-2">
                                                                <label
                                                                    class="form-label mb-1 text-success">ผลการสอบ</label>
                                                                <select
                                                                    name="skill_tests[{{ $i }}][test_result_id]"
                                                                    class="form-select form-select-sm border-success">
                                                                    <option value="">--Select--</option>
                                                                    @if (!empty($statusTestGlobalSet))
                                                                        @php $values = $statusTestGlobalSet->values; @endphp
                                                                        @foreach ($values as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                @if ($item->id == $test->test_result_id) selected @endif>
                                                                                {{ $item->value }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 col-6 mb-2">
                                                                <label
                                                                    class="form-label mb-1 text-success">หมายเหตุ</label>
                                                                <input type="text"
                                                                    name="skill_tests[{{ $i }}][note]"
                                                                    class="form-control form-control-sm border-success"
                                                                    placeholder="หมายเหตุ"
                                                                    value="{{ $test->note ?? '' }}" />
                                                            </div>
                                                            <div
                                                                class="col-md-1 col-2 d-flex align-items-center justify-content-center mb-2">
                                                                <button type="button"
                                                                    class="btn btn-outline-success btn-sm remove-skill-test"
                                                                    @if (count($skillTests) == 1) style="display:none;" @endif>
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="skill-test-item skill-test-modern mb-3 p-3"
                                                    style="background:rgba(255,255,255,0.95); border-radius:18px; box-shadow:0 2px 8px 0 rgba(80,180,255,0.07); border:1.5px solid #e3f0fa;">
                                                    <div class="row align-items-end g-2">
                                                        <div class="col-md-1 col-2 text-center">
                                                            <span class="skill-test-badge bg-success text-white">1</span>
                                                        </div>
                                                        <div class="col-md-2 col-6 mb-2">
                                                            <label class="form-label mb-1 text-success">วันที่สอบ</label>
                                                            <input type="date" name="skill_tests[0][test_date]"
                                                                class="form-control form-control-sm border-success" />
                                                        </div>
                                                        <div class="col-md-3 col-6 mb-2">
                                                            <label class="form-label mb-1 text-success">สถานที่สอบ</label>
                                                            <select name="skill_tests[0][test_location_id]"
                                                                class="form-select form-select-sm border-success">
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
                                                        <div class="col-md-2 col-6 mb-2">
                                                            <label
                                                                class="form-label mb-1 text-success">ตำแหน่งที่สอบ</label>
                                                            <select name="skill_tests[0][test_position_id]"
                                                                class="form-select form-select-sm border-success">
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
                                                        <div class="col-md-2 col-6 mb-2">
                                                            <label class="form-label mb-1 text-success">ผลการสอบ</label>
                                                            <select name="skill_tests[0][test_result_id]"
                                                                class="form-select form-select-sm border-success">
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
                                                        <div class="col-md-2 col-6 mb-2">
                                                            <label class="form-label mb-1 text-success">หมายเหตุ</label>
                                                            <input type="text" name="skill_tests[0][note]"
                                                                class="form-control form-control-sm border-success"
                                                                placeholder="หมายเหตุ" />
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
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                
                                {{-- Finance & Accounting Tab --}}
                                <div class="tab-pane fade" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                                    @canany(['account-update-labour'])
                                        {{-- มีสิทธิ์แก้ไข --}}
                                        <div class="col-12 mt-2">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>การเงินและบัญชี CID</strong> - จัดการข้อมูลทางการเงินที่เกี่ยวข้องกับกระบวนการ CID (การขอใบอนุญาตทำงาน)
                                            </div>
                                        </div>

                                        {{-- เงินประกัน Section --}}
                                        <div class="col-12 mt-3">
                                            <h5 class="text-primary"><i class="fas fa-shield-alt me-2"></i>เงินประกัน (Deposit)</h5>
                                            <hr>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">วันที่วางเงินประกัน</label>
                                                <input type="date" name="labour_cid_deposit_date"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('labour_cid_deposit_date', $labour->labour_cid_deposit_date ?? '') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">จำนวนเงินประกัน (บาท)</label>
                                                <input type="number" name="labour_cid_deposit_total" step="0.01"
                                                    class="form-control form-control-sm" placeholder="0.00"
                                                    value="{{ old('labour_cid_deposit_total', $labour->labour_cid_deposit_total ?? '') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">วิธีการจ่าย</label>
                                                <select name="payment_type" class="form-select form-select-sm">
                                                    <option value="">--เลือกวิธีการจ่าย--</option>
                                                    <option value="เงินสด" {{ old('payment_type', $labour->payment_type ?? '') == 'เงินสด' ? 'selected' : '' }}>เงินสด</option>
                                                    <option value="SCB" {{ old('payment_type', $labour->payment_type ?? '') == 'SCB' ? 'selected' : '' }}>SCB</option>
                                                    <option value="BBL" {{ old('payment_type', $labour->payment_type ?? '') == 'BBL' ? 'selected' : '' }}>BBL</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- CID-P Section --}}
                                        <div class="col-12 mt-4">
                                            <h5 class="text-success"><i class="fas fa-money-bill-wave me-2"></i>CID-P (CID Payment)</h5>
                                            <hr>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Date CID-P</label>
                                                <input type="date" name="labour_cidp_date"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('labour_cidp_date', $labour->labour_cidp_date ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">CID-P Total (บาท)</label>
                                                <input type="number" name="labour_cidp_total" step="0.01"
                                                    class="form-control form-control-sm" placeholder="0.00"
                                                    value="{{ old('labour_cidp_total', $labour->labour_cidp_total ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">วันที่รับ Date CID-P</label>
                                                <input type="date" name="labour_cidp_in_date"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('labour_cidp_in_date', $labour->labour_cidp_in_date ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">จำนวนเงินรับ CID-P (บาท)</label>
                                                <input type="number" name="labour_cidp_in_total" step="0.01"
                                                    class="form-control form-control-sm" placeholder="0.00"
                                                    value="{{ old('labour_cidp_in_total', $labour->labour_cidp_in_total ?? '') }}">
                                            </div>
                                        </div>

                                        {{-- การคืนเงินประกัน Section --}}
                                        <div class="col-12 mt-4">
                                            <h5 class="text-warning"><i class="fas fa-undo me-2"></i>การคืนเงินประกัน</h5>
                                            <hr>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">สถานะการคืนเงินประกัน</label>
                                                <select name="labour_cid_deposit_status" class="form-select form-select-sm">
                                                    <option value="">--เลือกสถานะ--</option>
                                                    <option value="None" {{ old('labour_cid_deposit_status', $labour->labour_cid_deposit_status ?? '') == 'None' ? 'selected' : '' }}>None</option>
                                                    <option value="ยกเลิก-คืนเงินประกัน" {{ old('labour_cid_deposit_status', $labour->labour_cid_deposit_status ?? '') == 'ยกเลิก-คืนเงินประกัน' ? 'selected' : '' }}>ยกเลิก-คืนเงินประกัน</option>
                                                    <option value="ยกเลิก-ไม่คืนเงินประกัน" {{ old('labour_cid_deposit_status', $labour->labour_cid_deposit_status ?? '') == 'ยกเลิก-ไม่คืนเงินประกัน' ? 'selected' : '' }}>ยกเลิก-ไม่คืนเงินประกัน</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">วันที่คืนเงินประกัน</label>
                                                <input type="date" name="labour_refund_deposit_date"
                                                    class="form-control form-control-sm"
                                                    value="{{ old('labour_refund_deposit_date', $labour->labour_refund_deposit_date ?? '') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">จำนวนเงินคืน (บาท)</label>
                                                <input type="number" name="labour_refund_deposit_total" step="0.01"
                                                    class="form-control form-control-sm" placeholder="0.00"
                                                    value="{{ old('labour_refund_deposit_total', $labour->labour_refund_deposit_total ?? '') }}">
                                            </div>
                                        </div>

                                        {{-- สรุปทางการเงิน --}}
                                        <div class="col-12 mt-4">
                                            <div class="card" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 1px solid #dee2e6;">
                                                <div class="card-header bg-info text-white">
                                                    <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>สรุปทางการเงิน</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row text-center">
                                                        <div class="col-md-3">
                                                            <div class="border-end">
                                                                <h6 class="text-muted">เงินประกัน</h6>
                                                                <h5 class="text-primary" id="summary-deposit">{{ number_format($labour->labour_cid_deposit_total ?? 0, 2) }} บาท</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="border-end">
                                                                <h6 class="text-muted">CID-P จ่าย</h6>
                                                                <h5 class="text-warning" id="summary-cidp-out">{{ number_format($labour->labour_cidp_total ?? 0, 2) }} บาท</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="border-end">
                                                                <h6 class="text-muted">CID-P รับคืน</h6>
                                                                <h5 class="text-success" id="summary-cidp-in">{{ number_format($labour->labour_cidp_in_total ?? 0, 2) }} บาท</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <h6 class="text-muted">เงินคืนประกัน</h6>
                                                            <h5 class="text-info" id="summary-refund">{{ number_format($labour->labour_refund_deposit_total ?? 0, 2) }} บาท</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    @else
                                        {{-- ไม่มีสิทธิ์แก้ไข --}}
                                        <div class="col-12 mt-2">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-lock me-2"></i>
                                                <strong>ไม่มีสิทธิ์เข้าถึง</strong> - คุณไม่มีสิทธิ์ในการดูหรือแก้ไขข้อมูลการเงินและบัญชี
                                            </div>
                                        </div>
                                        
                                        {{-- แสดงข้อมูลแบบ Read-only --}}
                                        <div class="col-12 mt-3">
                                            <h5 class="text-muted"><i class="fas fa-shield-alt me-2"></i>เงินประกัน (Deposit)</h5>
                                            <hr>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">วันที่วางเงินประกัน</label>
                                                <input type="date" class="form-control form-control-sm bg-light" readonly
                                                    value="{{ $labour->labour_cid_deposit_date ?? '' }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">จำนวนเงินประกัน (บาท)</label>
                                                <input type="text" class="form-control form-control-sm bg-light" readonly
                                                    value="{{ $labour->labour_cid_deposit_total ? number_format($labour->labour_cid_deposit_total, 2) : '-' }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">วิธีการจ่าย</label>
                                                <input type="text" class="form-control form-control-sm bg-light" readonly
                                                    value="{{ $labour->payment_type ?? '-' }}">
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <h5 class="text-muted"><i class="fas fa-money-bill-wave me-2"></i>CID-P (CID Payment)</h5>
                                            <hr>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Date CID-P</label>
                                                <input type="date" class="form-control form-control-sm bg-light" readonly
                                                    value="{{ $labour->labour_cidp_date ?? '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">CID-P Total (บาท)</label>
                                                <input type="text" class="form-control form-control-sm bg-light" readonly
                                                    value="{{ $labour->labour_cidp_total ? number_format($labour->labour_cidp_total, 2) : '-' }}">
                                            </div>
                                        </div>
                                    @endcanany
                                </div>
                                
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <br>
                                    <div class="row">
                                        {{-- ปุ่มเพิ่มเอกสาร --}}
                                        <div class="mb-3 text-end">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addFileModal">
                                                <i class="fa fa-plus"></i> เพิ่มรายการเอกสาร
                                            </button>
                                        </div>
                                        @foreach ($listFiles as $i => $item)
                                            <div class="col-md-6 col-lg-4 mb-4 mt-4">
                                                @can('delete-labour')
                                                    <a href="{{ route('labours.list-files.destroy', ['labour' => $labour->labour_id, 'list_file' => $item->list_file_id]) }}"
                                                        onclick="event.preventDefault(); if(confirm('ยืนยันการลบรายการเอกสารนี้?'))"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> ลบรายการเอกสาร
                                                        ({{ $item->managefile_name }})
                                                    </a>
                                                @endcan






                                                <div class="card h-100 shadow-sm border file-card"
                                                    data-id="{{ $item->list_file_id }}">
                                                    <div class="card-body p-3">

                                                        <!-- File Preview/Thumbnail -->
                                                        <div class="text-center mb-3">
                                                            @if ($item->file_path)
                                                                @php
                                                                    $fileExtension = pathinfo(
                                                                        $item->file_path,
                                                                        PATHINFO_EXTENSION,
                                                                    );
                                                                    $fileName = pathinfo(
                                                                        $item->file_path,
                                                                        PATHINFO_FILENAME,
                                                                    );
                                                                    $thumbnailPath =
                                                                        dirname($item->file_path) .
                                                                        '/thumbnails/' .
                                                                        $fileName .
                                                                        '_thumb.jpg';
                                                                    $isImage = in_array(strtolower($fileExtension), [
                                                                        'jpg',
                                                                        'jpeg',
                                                                        'png',
                                                                        'gif',
                                                                        'webp',
                                                                    ]);
                                                                    $isPdf = strtolower($fileExtension) === 'pdf';
                                                                @endphp

                                                                <div class="file-preview-container"
                                                                    style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; position: relative;">
                                                                    @if ($isImage)
                                                                        <!-- แสดงภาพจริง -->
                                                                        <img src="{{ asset('storage/' . $item->file_path) }}"
                                                                            alt="Preview" class="img-fluid rounded"
                                                                            style="max-height: 190px; max-width: 100%; object-fit: cover;">
                                                                    @elseif ($isPdf)
                                                                        <!-- แสดง PDF preview หน้าแรกเท่านั้น -->
                                                                        <div class="pdf-preview-container"
                                                                            style="width: 100%; height: 190px; border-radius: 8px; overflow: hidden; background: #f8f9fa; position: relative;"
                                                                            data-pdf-url="{{ asset('storage/' . $item->file_path) }}">
                                                                            <!-- PDF Viewer with iframe - แสดงแค่หน้าที่ 1 -->
                                                                            <iframe
                                                                                src="{{ asset('storage/' . $item->file_path) }}#page=1&toolbar=0&navpanes=0&scrollbar=0&view=Fit&zoom=85"
                                                                                width="100%" height="110%"
                                                                                style="border: none; pointer-events: none; margin-top: -5px;"
                                                                                class="pdf-iframe"
                                                                                onload="handlePdfLoad(this)"
                                                                                onerror="handlePdfError(this)">
                                                                            </iframe>

                                                                            <!-- Preview overlay -->
                                                                            <div class="pdf-preview-overlay"
                                                                                style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; text-align: center; padding: 10px 5px; font-size: 12px;">
                                                                                <i class="fas fa-file-pdf"></i> หน้าแรก -
                                                                                คลิกเพื่อดูทั้งหมด
                                                                            </div>

                                                                            <!-- Canvas fallback for PDF.js -->
                                                                            <canvas class="pdf-canvas d-none"
                                                                                style="width: 100%; height: 100%; object-fit: cover;">
                                                                            </canvas>

                                                                            <!-- Ultimate fallback -->
                                                                            <div class="pdf-fallback"
                                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none; align-items: center; justify-content: center; background: #f8f9fa; cursor: pointer;">
                                                                                <div class="text-center">
                                                                                    <i class="fas fa-file-pdf text-danger"
                                                                                        style="font-size: 48px;"></i>
                                                                                    <div class="small text-muted mt-2">PDF
                                                                                        Document</div>
                                                                                    <div class="small text-primary mt-1">
                                                                                        {{ basename($item->file_path) }}
                                                                                    </div>
                                                                                    <div class="small text-warning"><i
                                                                                            class="fas fa-eye"></i>
                                                                                        คลิกเพื่อดูทั้งหมด</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- PDF Action Buttons -->
                                                                        <div class="position-absolute"
                                                                            style="top: 8px; right: 8px;">
                                                                            <div class="btn-group">
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-primary pdf-preview-btn"
                                                                                    data-pdf-url="{{ asset('storage/' . $item->file_path) }}"
                                                                                    data-file-name="{{ $item->managefile_name }}"
                                                                                    title="ดู PDF ทั้งหมด">
                                                                                    <i class="fas fa-expand"></i>
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-success"
                                                                                    onclick="window.open('{{ asset('storage/' . $item->file_path) }}', '_blank')"
                                                                                    title="เปิดในแท็บใหม่">
                                                                                    <i
                                                                                        class="fas fa-external-link-alt"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <!-- แสดงไอคอนสำหรับไฟล์อื่นๆ -->
                                                                        @php
                                                                            $iconClass = 'fas fa-file';
                                                                            $iconColor = 'text-secondary';
                                                                            $fileType = 'Document';

                                                                            switch (strtolower($fileExtension)) {
                                                                                case 'doc':
                                                                                case 'docx':
                                                                                    $iconClass = 'fas fa-file-word';
                                                                                    $iconColor = 'text-primary';
                                                                                    $fileType = 'Word Document';
                                                                                    break;
                                                                                case 'xls':
                                                                                case 'xlsx':
                                                                                    $iconClass = 'fas fa-file-excel';
                                                                                    $iconColor = 'text-success';
                                                                                    $fileType = 'Excel Spreadsheet';
                                                                                    break;
                                                                                case 'ppt':
                                                                                case 'pptx':
                                                                                    $iconClass =
                                                                                        'fas fa-file-powerpoint';
                                                                                    $iconColor = 'text-warning';
                                                                                    $fileType = 'PowerPoint';
                                                                                    break;
                                                                                case 'txt':
                                                                                    $iconClass = 'fas fa-file-alt';
                                                                                    $iconColor = 'text-info';
                                                                                    $fileType = 'Text File';
                                                                                    break;
                                                                            }
                                                                        @endphp
                                                                        <div class="text-center">
                                                                            <i class="{{ $iconClass }} {{ $iconColor }}"
                                                                                style="font-size: 64px;"></i>
                                                                            <div class="small text-muted mt-2">
                                                                                {{ $fileType }}</div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <!-- ยังไม่มีไฟล์ - แสดงพื้นที่อัปโหลด -->
                                                                <div class="file-upload-area text-center p-4"
                                                                    style="height: 200px; border: 2px dashed #dee2e6; border-radius: 8px; background: #f8f9fa; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                                    <i class="fas fa-cloud-upload-alt text-muted"
                                                                        style="font-size: 48px;"></i>
                                                                    <div class="small text-muted mt-3">คลิกเพื่อเลือกไฟล์
                                                                    </div>
                                                                    <div class="small text-muted">หรือลากไฟล์มาวางที่นี่
                                                                    </div>
                                                                    <input type="file"
                                                                        class="form-control file-input position-absolute w-100 h-100 opacity-0"
                                                                        style="top: 0; left: 0; cursor: pointer;"
                                                                        data-upload="{{ route('labours.list-files.upload', [$labour->labour_id, $item->list_file_id]) }}"
                                                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif">
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- File Info -->
                                                        <div class="card-text">
                                                            <h6 class="card-title mb-2 text-truncate"
                                                                title="{{ $item->managefile_name }}">
                                                                {{ $item->managefile_name }}
                                                            </h6>
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <small
                                                                    class="text-muted">{{ $item->managefile_code }}</small>
                                                                <span
                                                                    class="badge {{ $item->managefile_step == 'A' ? 'badge-primary' : 'badge-success' }}">
                                                                    Step {{ $item->managefile_step }}
                                                                </span>
                                                            </div>

                                                            @if ($item->file_path)
                                                                <div class="small text-muted mb-2">
                                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                                    {{ date('d/m/Y', strtotime($item->updated_at)) }}
                                                                </div>

                                                                @php
                                                                    $fileSizeBytes = file_exists(
                                                                        storage_path('app/public/' . $item->file_path),
                                                                    )
                                                                        ? filesize(
                                                                            storage_path(
                                                                                'app/public/' . $item->file_path,
                                                                            ),
                                                                        )
                                                                        : 0;
                                                                    $fileSize =
                                                                        $fileSizeBytes > 0
                                                                            ? number_format($fileSizeBytes / 1024, 1) .
                                                                                ' KB'
                                                                            : 'ไม่ทราบขนาด';
                                                                @endphp
                                                                <div class="small text-muted mb-3">
                                                                    <i class="fas fa-file me-1"></i>
                                                                    {{ strtoupper($fileExtension ?? '') }} •
                                                                    {{ $fileSize }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        @if ($item->file_path)
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                @if ($isPdf)
                                                                    {{-- <button type="button" class="btn btn-info btn-sm pdf-viewer-btn"
                                                                        data-pdf-url="{{ asset('storage/' . $item->file_path) }}"
                                                                        data-file-name="{{ $item->managefile_name }}"
                                                                        title="เปิดใน PDF Reader">
                                                                    <i class="fas fa-book-open"></i>
                                                                </button> --}}
                                                                @else
                                                                    <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                        target="_blank" class="btn btn-info btn-sm"
                                                                        title="ดูไฟล์">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @endif

                                                                <a href="{{ route('labours.list-files.download', $item) }}"
                                                                    class="btn btn-success btn-sm" title="ดาวน์โหลด">
                                                                    <i class="fas fa-download"></i>
                                                                </a>

                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-delete"
                                                                    data-url="{{ route('labours.list-files.destroy', ['labour' => $labour->labour_id, 'list_file' => $item->list_file_id]) }}"
                                                                    title="ลบไฟล์">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>


                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>




                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" form="formUpdate" class="btn btn-success px-4 py-2 fw-bold">
                                <i class="fa fa-save me-1"></i> บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Modal เพิ่มรายการเอกสาร -->
        <div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="add-file-form" action="{{ route('labours.list-files.store', $labour->labour_id) }}"
                    method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFileModalLabel">เพิ่มรายการเอกสาร</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label class="form-label">Code ย่อ</label>
                                <input type="text" name="managefile_code" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">ชื่อเอกสาร</label>
                                <input type="text" name="managefile_name" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Step</label>
                                <select name="managefile_step" class="form-select" required>
                                    <option value="A">Step A</option>
                                    <option value="B">Step B</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Active</label>
                                <select name="managefile_status" class="form-select">
                                    <option value="Y">ใช้งาน</option>
                                    <option value="N">ไม่ใช้งาน</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" form="add-file-form" class="btn btn-success">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>

    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

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
                        // $row.find('td').eq(3).html('<i class="fa fa-file-earmark-fill fs-3"></i>');
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
            // $(document).on('click', '.btn-delete', function() {
            //     if (!confirm('ยืนยันการลบไฟล์?')) return;
            //     const $row = $(this).closest('tr');
            //     const url = $(this).data('url');

            //     $.ajax({
            //         url,
            //         type: 'DELETE',
            //         success() {
            //             // ไอคอนไฟล์
            //             // $row.find('td').eq(3).html('<i class="fa fa-file-earmark-slash fs-3 text-muted"></i>');
            //             // คืน input
            //             const id = $row.data('id');
            //             const inp =
            //                 `<input type="file" 
            //                         class="form-control form-control-sm file-input"
            //                         data-upload="{{ route('labours.list-files.upload', [$labour->labour_id, '__ID__']) }}">`
            //                 .replace('__ID__', id);
            //             $row.find('td').eq(4).html(inp);
            //             // วันที่
            //             $row.find('td').eq(5).text('-');
            //         },
            //         error(err) {
            //             alert(err.responseJSON?.message || 'ลบไม่สำเร็จ');
            //         }
            //     });
            // });
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

            // File upload functionality
            $(document).on('change', '.file-input', function() {
                var fileInput = this;
                var uploadUrl = $(this).data('upload');
                var formData = new FormData();

                if (fileInput.files.length > 0) {
                    formData.append('file', fileInput.files[0]);

                    // Show loading state
                    var card = $(this).closest('.card');
                    var previewContainer = card.find('.file-preview-container');

                    previewContainer.html(
                        '<div class="text-center"><i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i><div class="small text-muted mt-2">กำลังอัปโหลด...</div></div>'
                    );

                    $.ajax({
                        url: uploadUrl,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Upload response:', response);

                            // Check multiple response formats
                            if (response.success === true || response.status === 'success' ||
                                response.error === false || (response.data && response.data
                                    .success)) {
                                // Success - show success message and reload
                                var successMessage = response.message || 'อัปโหลดไฟล์สำเร็จ';

                                // Show success notification
                                previewContainer.html(
                                    '<div class="text-center text-success"><i class="fas fa-check-circle" style="font-size: 24px;"></i><div class="small mt-2">' +
                                    successMessage + '</div></div>');

                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else if (response.success === false || response.status ===
                                'error' || response.error === true) {
                                // Explicit error response
                                var errorMessage = response.message || response.error_message ||
                                    response.msg || 'ไม่ทราบสาเหตุ';
                                alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์: ' + errorMessage);
                                // Reset upload area
                                previewContainer.html(
                                    '<div class="file-upload-area text-center p-3"><i class="fas fa-cloud-upload-alt text-muted" style="font-size: 36px;"></i><div class="small text-muted mt-2">คลิกเพื่ือเลือกไฟล์</div></div>'
                                );
                            } else {
                                // Assume success if no explicit error (some servers return 200 with data)
                                console.log('Assuming success due to 200 response');
                                previewContainer.html(
                                    '<div class="text-center text-success"><i class="fas fa-check-circle" style="font-size: 24px;"></i><div class="small mt-2">อัปโหลดไฟล์สำเร็จ</div></div>'


                                );

                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Upload error details:', {
                                status: xhr.status,
                                statusText: xhr.statusText,
                                responseText: xhr.responseText,
                                error: error
                            });

                            var errorMessage = 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์';

                            // Try to parse error response
                            try {
                                var errorResponse = JSON.parse(xhr.responseText);
                                if (errorResponse.message) {
                                    errorMessage += ': ' + errorResponse.message;
                                } else if (errorResponse.error) {
                                    errorMessage += ': ' + errorResponse.error;
                                }
                            } catch (e) {
                                // If response is not JSON, show status
                                if (xhr.status !== 200) {
                                    errorMessage += ' (HTTP ' + xhr.status + ')';
                                }
                            }

                            // For debugging - check if it's actually successful but reported as error
                            if (xhr.status === 200 && xhr.responseText) {
                                console.log(
                                    'Got 200 status but jQuery treated as error, checking response:',
                                    xhr.responseText);
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.success !== false && !response.error) {
                                        console.log(
                                            'Treating as success despite error callback');
                                        setTimeout(function() {
                                            location.reload();
                                        }, 500);
                                        return;
                                    }
                                } catch (e) {
                                    // If it's not JSON but 200, might still be success
                                    console.log('Non-JSON 200 response, assuming success');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 500);
                                    return;
                                }
                            }

                            alert(errorMessage);
                            // Reset upload area
                            previewContainer.html(
                                '<div class="file-upload-area text-center p-3"><i class="fas fa-cloud-upload-alt text-muted" style="font-size: 36px;"></i><div class="small text-muted mt-2">คลิกเพื่ือเลือกไฟล์</div></div>'
                            );
                        }
                    });
                }
            });

            // PDF Loading handlers
            window.handlePdfLoad = function(iframe) {
                console.log('PDF loaded successfully');
                iframe.style.display = 'block';
                var fallback = iframe.parentNode.querySelector('.pdf-fallback');
                if (fallback) {
                    fallback.style.display = 'none';
                }
            };

            window.handlePdfError = function(iframe) {
                console.log('PDF loading failed, trying fallback');
                iframe.style.display = 'none';
                var container = iframe.parentNode;
                var fallback = container.querySelector('.pdf-fallback');

                // Try PDF.js canvas rendering as fallback
                var canvas = container.querySelector('.pdf-canvas');
                var pdfUrl = container.dataset.pdfUrl;

                if (canvas && pdfUrl) {
                    // Try to render first page with PDF.js if available
                    tryRenderPdfCanvas(canvas, pdfUrl, function(success) {
                        if (success) {
                            canvas.style.display = 'block';
                            canvas.classList.remove('d-none');
                        } else {
                            // Show ultimate fallback
                            if (fallback) {
                                fallback.style.display = 'flex';
                            }
                        }
                    });
                } else {
                    // Show ultimate fallback
                    if (fallback) {
                        fallback.style.display = 'flex';
                    }
                }
            };

            window.tryRenderPdfCanvas = function(canvas, pdfUrl, callback) {
                // Check if PDF.js is available
                if (typeof pdfjsLib === 'undefined') {
                    console.log('PDF.js not available');
                    callback(false);
                    return;
                }

                pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                    return pdf.getPage(1); // Get first page
                }).then(function(page) {
                    var context = canvas.getContext('2d');
                    var viewport = page.getViewport({

                        scale: 0.5
                    });

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    return page.render(renderContext).promise;
                }).then(function() {
                    console.log('PDF rendered successfully with PDF.js');
                    callback(true);
                }).catch(function(error) {
                    console.error('PDF.js rendering failed:', error);
                    callback(false);
                });
            };

            // PDF Preview functionality
            $(document).on('click', '.pdf-preview-btn', function(e) {
                e.stopPropagation(); // ป้องกันไม่ให้ event bubble ขึ้นไป
                var pdfUrl = $(this).data('pdf-url');
                var fileName = $(this).data('file-name');

                openPdfModal(pdfUrl, fileName);
            });

            // PDF Container click (เปิด modal เมื่อคลิกที่ PDF preview)
            $(document).on('click', '.pdf-preview-container, .pdf-fallback', function(e) {
                e.stopPropagation();
                var pdfUrl = $(this).data('pdf-url') || $(this).closest('.pdf-preview-container').data(
                    'pdf-url');
                var fileName = $(this).closest('.card').find('.card-title').text().trim();

                if (pdfUrl) {
                    openPdfModal(pdfUrl, fileName);
                }
            });

            // Function to open PDF modal
            function openPdfModal(pdfUrl, fileName) {
                // Set PDF URL and filename in modal
                $('#pdfViewer').attr('src', pdfUrl);
                $('#pdfPreviewModalLabel').text('ดู PDF ทั้งหมด: ' + fileName);
                $('#downloadPdfBtn').attr('href', pdfUrl);

                // Show modal (support both Bootstrap 4 and 5)
                if (typeof bootstrap !== 'undefined') {
                    // Bootstrap 5
                    var modal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
                    modal.show();
                } else {
                    // Bootstrap 4
                    $('#pdfPreviewModal').modal('show');
                }
            }

            // Additional modal close handlers
            $(document).on('click', '[data-bs-dismiss="modal"], [data-dismiss="modal"]', function() {
                var modalId = $(this).closest('.modal').attr('id');
                if (modalId) {
                    if (typeof bootstrap !== 'undefined') {
                        // Bootstrap 5
                        var modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                        if (modal) {
                            modal.hide();
                        }
                    } else {
                        // Bootstrap 4
                        $('#' + modalId).modal('hide');
                    }
                }
            });

            // Close modal when clicking outside or pressing ESC
            $(document).on('click', '.modal', function(e) {
                if (e.target === this) {
                    $(this).modal('hide');
                }
            });

            $(document).keyup(function(e) {
                if (e.keyCode === 27) { // ESC key
                    $('.modal.show').modal('hide');
                }
            });

            // Clean up modal when hidden
            $('#pdfPreviewModal').on('hidden.bs.modal hidden', function() {
                $('#pdfViewer').attr('src', ''); // Clear iframe source
                $('.modal-backdrop').remove(); // Remove any leftover backdrop
            });

            // Ensure modal shows properly
            $('#pdfPreviewModal').on('show.bs.modal show', function() {
                $(this).find('.modal-dialog').css({
                    'margin-top': '20px',
                    'margin-bottom': '20px'
                });
            });

            // PDF Container click (same as preview button)
            $(document).on('click', '.pdf-preview-container', function() {
                var card = $(this).closest('.card');
                var previewBtn = card.find('.pdf-preview-btn');
                if (previewBtn.length) {
                    previewBtn.trigger('click');
                }
            });

            // PDF Viewer functionality (using PDF.js)
            $(document).on('click', '.pdf-viewer-btn', function() {
                var pdfUrl = $(this).data('pdf-url');
                var fileName = $(this).data('file-name');
                var listFileId = $(this).closest('.card').data('id');

                // Open PDF.js viewer in new tab
                var viewerUrl = '/api/list-files/' + listFileId + '/pdf-viewer';
                window.open(viewerUrl, '_blank');
            });

            // Delete file functionality
            $(document).on('click', '.btn-delete', function() {
                if (confirm('คุณต้องการลบไฟล์นี้หรือไม่?')) {
                    var deleteUrl = $(this).data('url');
                    var card = $(this).closest('.card');
                    var _token = {"_token": $('#token').val()};
                    console.log('_token :', _token);

                    $.ajax({
                        url: deleteUrl,
                        type: 'GET',
                          headers: {
        'X-CSRF-TOKEN': $('#token').val()
    },
                        success: function(response) {
                            console.log('Delete response:', response);

                            // Check multiple response formats
                            if (response.success === true || response.status === 'success' ||
                                response.error === false) {
                                // Success - show success message and reload
                                var successMessage = response.message || 'ลบไฟล์สำเร็จ';
                                alert(successMessage);

                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            } else if (response.success === false || response.status ===
                                'error' || response.error === true) {
                                // Explicit error response
                                var errorMessage = response.message || response.error_message ||
                                    response.msg || 'ไม่ทราบสาเหตุ';
                                alert('เกิดข้อผิดพลาดในการลบไฟล์: ' + errorMessage);
                            } else {
                                // Assume success if no explicit error (some servers return 200 with data)
                                console.log('Assuming delete success due to 200 response');
                                alert('ลบไฟล์สำเร็จ');

                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Delete error details:', {
                                status: xhr.status,
                                statusText: xhr.statusText,
                                responseText: xhr.responseText,
                                error: error
                            });

                            var errorMessage = 'เกิดข้อผิดพลาดในการลบไฟล์';

                            // Try to parse error response
                            try {
                                var errorResponse = JSON.parse(xhr.responseText);
                                if (errorResponse.message) {
                                    errorMessage += ': ' + errorResponse.message;
                                } else if (errorResponse.error) {
                                    errorMessage += ': ' + errorResponse.error;
                                }
                            } catch (e) {
                                // If response is not JSON, show status
                                if (xhr.status !== 200) {
                                    errorMessage += ' (HTTP ' + xhr.status + ')';
                                }
                            }

                            alert(errorMessage);
                        }
                    });
                }
            });

            // Financial Summary Update
            function updateFinancialSummary() {
                var depositTotal = parseFloat($('input[name="labour_cid_deposit_total"]').val()) || 0;
                var cidpTotal = parseFloat($('input[name="labour_cidp_total"]').val()) || 0;
                var cidpInTotal = parseFloat($('input[name="labour_cidp_in_total"]').val()) || 0;
                var refundTotal = parseFloat($('input[name="labour_refund_deposit_total"]').val()) || 0;

                $('#summary-deposit').text(depositTotal.toLocaleString('th-TH', {minimumFractionDigits: 2}) + ' บาท');
                $('#summary-cidp-out').text(cidpTotal.toLocaleString('th-TH', {minimumFractionDigits: 2}) + ' บาท');
                $('#summary-cidp-in').text(cidpInTotal.toLocaleString('th-TH', {minimumFractionDigits: 2}) + ' บาท');
                $('#summary-refund').text(refundTotal.toLocaleString('th-TH', {minimumFractionDigits: 2}) + ' บาท');
            }

            // Bind financial fields to update summary
            $(document).on('input', 'input[name="labour_cid_deposit_total"], input[name="labour_cidp_total"], input[name="labour_cidp_in_total"], input[name="labour_refund_deposit_total"]', function() {
                updateFinancialSummary();
            });

            // Check PDF support and show fallback if needed
            $(document).ready(function() { // Initialize existing PDF previews after page load
                setTimeout(function() {
                    // Check Bootstrap version and show appropriate close button
                    if (typeof bootstrap !== 'undefined') {
                        // Bootstrap 5 - show btn-close
                        $('.btn-close').removeClass('d-none');
                        $('.close').addClass('d-none');
                    } else {
                        // Bootstrap 4 - show close
                        $('.btn-close').addClass('d-none');
                        $('.close').removeClass('d-none');
                    }

                    $('.pdf-preview-container').each(function() {
                        var container = $(this);
                        var iframe = container.find('.pdf-iframe');
                        var pdfUrl = container.data('pdf-url');

                        if (iframe.length && pdfUrl) {
                            // Check if iframe loaded successfully
                            var iframeLoaded = false;
                            try {
                                // For same-origin PDFs, we can check content
                                var iframeDoc = iframe[0].contentDocument || iframe[0]
                                    .contentWindow.document;
                                if (iframeDoc && iframeDoc.body && iframeDoc.body.innerHTML
                                    .trim() !== '') {
                                    iframeLoaded = true;
                                }
                            } catch (e) {
                                // Cross-origin or secure content, assume loaded if no error reported
                                if (iframe[0].contentWindow) {
                                    iframeLoaded = true;
                                }
                            }

                            if (!iframeLoaded) {
                                console.log(
                                    'PDF iframe may not have loaded, checking fallback for:',
                                    pdfUrl);
                                // Let the existing error handler manage fallback
                                handlePdfError(iframe[0]);
                            }
                        }
                    });
                }, 3000); // Wait 3 seconds for PDFs to load

                // Check if browser supports PDF viewing
                function checkPDFSupport() {
                    var hasPDFSupport = false;

                    // Check for PDF.js
                    if (typeof window.pdfjsLib !== 'undefined') {
                        hasPDFSupport = true;
                    }

                    // Check for native PDF support
                    var testEmbed = document.createElement('embed');
                    testEmbed.setAttribute('type', 'application/pdf');
                    testEmbed.setAttribute('src', 'data:application/pdf,');
                    testEmbed.style.display = 'none';
                    document.body.appendChild(testEmbed);

                    setTimeout(function() {
                        if (testEmbed.offsetHeight > 0) {
                            hasPDFSupport = true;
                        }
                        document.body.removeChild(testEmbed);

                        // If no PDF support, show fallback
                        if (!hasPDFSupport) {
                            $('.pdf-preview-container embed').addClass('d-none');
                            $('.pdf-fallback').removeClass('d-none');
                        }
                    }, 100);
                }

                // Check PDF support on page load
                checkPDFSupport();
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

        // Document add form submission
        // document.addEventListener('DOMContentLoaded', function() {
        //     const addFileForm = document.getElementById('add-file-form');
        //     if (addFileForm) {
        //         addFileForm.addEventListener('submit', function(e) {
        //             e.preventDefault();
        //             const formData = new FormData(addFileForm);
        //             const submitBtn = addFileForm.querySelector('button[type="submit"]');
        //             submitBtn.disabled = true;
        //             fetch(`{{ route('labours.list-files.store', $labour->labour_id) }}`, {
        //                 method: 'POST',
        //                 headers: {
        //                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //                 },
        //                 body: formData
        //             })
        //             .then(response => response.json())
        //             .then(res => {
        //                 submitBtn.disabled = false;
        //                 if(res.success) {
        //                     var modal = bootstrap.Modal.getInstance(document.getElementById('addFileModal'));
        //                     modal.hide();
        //                     location.reload();
        //                 } else {
        //                     alert(res.message || 'เกิดข้อผิดพลาด');
        //                 }
        //             })
        //             .catch(() => {
        //                 submitBtn.disabled = false;
        //                 alert('เกิดข้อผิดพลาด');
        //             });
        //         });
        //     }
        // });
    </script>

    <!-- PDF Preview Modal -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content pdf-modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="pdfPreviewModalLabel">
                        <i class="fas fa-file-pdf me-2"></i>ดู PDF ทั้งหมด
                    </h5>
                    <div class="d-flex align-items-center">
                        <small class="text-light me-3">
                            <i class="fas fa-info-circle"></i> สามารถเลื่อนดูหน้าต่างๆ ได้
                        </small>
                        <!-- Bootstrap 5 close button -->
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <!-- Bootstrap 4 fallback close button -->
                        <button type="button" class="close text-white d-none" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body p-0" style="height: calc(90vh - 120px);">
                    <iframe id="pdfViewer" class="pdf-viewer-iframe" src=""
                        style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
                <div class="modal-footer bg-light">
                    <div class="d-flex justify-content-between w-100">
                        <div class="text-muted small">
                            <i class="fas fa-lightbulb"></i>
                            เคล็ดลับ: ใช้ Ctrl + Mouse Wheel เพื่อซูมเข้า-ออก
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                data-dismiss="modal">
                                <i class="fas fa-times"></i> ปิด
                            </button>
                            <a href="" class="btn btn-success" id="downloadPdfBtn" target="_blank">
                                <i class="fas fa-download"></i> ดาวน์โหลด
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
