@extends('layouts.template')

@section('styles')
<!-- PDF.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
if (typeof pdfjsLib !== 'undefined') {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
}
</script>

<style>
    /* File card styles */
    .file-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .file-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
    
    .file-preview-container {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
    }
    
    .file-upload-area {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .file-upload-area:hover {
        background: #e3f2fd !important;
        border-color: #2196f3 !important;
    }
    
    .file-upload-area:hover i {
        color: #2196f3 !important;
    }
    
    /* PDF preview button styles */
    .pdf-preview-btn, .pdf-viewer-btn {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .pdf-preview-btn:hover, .pdf-viewer-btn:hover {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.1);
    }
    
    /* PDF preview container */
    .pdf-preview-container {
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        border: 1px solid #e0e0e0;
    }
    
    .pdf-preview-container:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transform: scale(1.01);
        border-color: #007bff;
    }

    .pdf-preview-container:hover .pdf-preview-overlay {
        background: linear-gradient(transparent, rgba(0,123,255,0.8));
    }

    .pdf-preview-overlay {
        transition: all 0.3s ease;
        pointer-events: none;
        border-radius: 0 0 8px 8px;
    }

    .pdf-iframe {
        transition: opacity 0.3s ease;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
    }
    
    .pdf-fallback {
        transition: opacity 0.3s ease;
        cursor: pointer;
    }
    
    .pdf-canvas {
        border-radius: 8px;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* File preview container */
    .file-preview-container {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .file-preview-container:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: scale(1.01);
        border-color: #007bff;
    }
    
    /* PDF modal styles */
    .pdf-modal-content {
        height: 90vh;
        max-height: 90vh;
    }
    
    .pdf-viewer-iframe {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 0 0 8px 8px;
    }

    /* Modal close button styles */
    .btn-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        font-weight: bold;
        color: #000;
        opacity: 0.5;
        cursor: pointer;
        padding: 0.5rem;
    }

    .btn-close:hover {
        opacity: 0.75;
    }

    .btn-close:before {
        content: "×";
    }

    /* Ensure modal backdrop works */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: #000;
        opacity: 0.5;
    }
        border-radius: 8px;
    }
    
    /* File type badges */
    .badge-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
    }
    
    .badge-success {
        background: linear-gradient(45deg, #28a745, #1e7e34);
    }
    
    /* Action buttons */
    .btn-sm {
        border-radius: 6px;
        font-size: 12px;
        padding: 4px 8px;
        margin: 0 2px;
    }
    
    .d-flex.gap-2 > * {
        margin: 0 2px;
    }
    
    /* File info text */
    .card-title {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
    
    /* Loading animation */
    .fa-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Modal styles for PDF preview */
    .modal-xl {
        max-width: 90%;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col-md-4 {
            margin-bottom: 1rem;
        }
        
        .file-preview-container {
            height: 100px !important;
        }
    }
</style>
@endsection

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
                        <h5>แก้ไขข้อมูลคนงาน</h5>
                        <div class="">
                            @foreach (['A', 'B'] as $step)
                                @php $done = in_array($step, $labour->completed_steps); @endphp
                                <span class="badge bg-{{ $done ? 'success' : 'secondary' }}">
                                    Step {{ $step }} {{ $done ? 'ครบ' : 'ยังไม่ครบ' }}
                                </span>
                            @endforeach
                        </div>
                        
                        
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

                                        <!-- ฟิลด์ข้อมูลการติดต่อเพิ่มเติม -->
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-4 col-form-label-sm text-right">อีเมล</label>
                                                <div class="col-sm-8">
                                                    <input type="email" name="labour_email"
                                                        value="{{ $labour->labour_email }}"
                                                        class="form-control form-control-sm" placeholder="example@email.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-4 col-form-label-sm text-right">Line ID</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="labour_line_id"
                                                        value="{{ $labour->labour_line_id }}"
                                                        class="form-control form-control-sm" placeholder="Line ID">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-4 col-form-label-sm text-right">ชื่อผู้ติดต่อฉุกเฉิน</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="labour_emergency_contact_name"
                                                        value="{{ $labour->labour_emergency_contact_name }}"
                                                        class="form-control form-control-sm" placeholder="ชื่อผู้ติดต่อฉุกเฉิน">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ข้อมูลที่อยู่ -->
                                    <div class="col-md-12">
                                        <b class="">ข้อมูลที่อยู่</b>
                                        <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">ประเภทที่อยู่</label>
                                            <div class="col-sm-8">
                                                <select name="labour_address_type" class="form-control form-control-sm">
                                                    <option value="">---เลือก---</option>
                                                    <option value="ตามบัตรประชาชน" {{ $labour->labour_address_type == 'ตามบัตรประชาชน' ? 'selected' : '' }}>ตามบัตรประชาชน</option>
                                                    <option value="ปัจจุบัน" {{ $labour->labour_address_type == 'ปัจจุบัน' ? 'selected' : '' }}>ที่อยู่ปัจจุบัน</option>
                                                    <option value="อื่นๆ" {{ $labour->labour_address_type == 'อื่นๆ' ? 'selected' : '' }}>อื่นๆ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label-sm text-right">ที่อยู่</label>
                                            <div class="col-sm-10">
                                                <textarea name="labour_address" class="form-control form-control-sm" 
                                                    rows="2" placeholder="บ้านเลขที่ หมู่ ซอย ถนน">{{ $labour->labour_address }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">จังหวัด</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_province"
                                                    value="{{ $labour->labour_province }}"
                                                    class="form-control form-control-sm" placeholder="จังหวัด">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">เขต/อำเภอ</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_district"
                                                    value="{{ $labour->labour_district }}"
                                                    class="form-control form-control-sm" placeholder="เขต/อำเภอ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">แขวง/ตำบล</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_sub_district"
                                                    value="{{ $labour->labour_sub_district }}"
                                                    class="form-control form-control-sm" placeholder="แขวง/ตำบล">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">รหัสไปรษณีย์</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="labour_postcode"
                                                    value="{{ $labour->labour_postcode }}"
                                                    class="form-control form-control-sm" placeholder="รหัสไปรษณีย์" maxlength="10">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- เพิ่มฟิลด์ Note -->
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label-sm text-right">หมายเหตุ</label>
                                            <div class="col-sm-10">
                                                <textarea name="labour_note" class="form-control form-control-sm" 
                                                    rows="3" placeholder="หมายเหตุเพิ่มเติม">{{ $labour->labour_note }}</textarea>
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
                                                <input type="date" name="labour_disease_receive_date"
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
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label-sm text-right">บันทึกเพิ่มเติม </label>
                                            <div class="col-sm-8">
                                                <textarea name="labour_note" class="form-control" cols="30" rows="2" placeholder="Note..">{{$labour->labour_note}}</textarea>
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
                                                <input type="date" name="lacation_test_date" value="{{$labour->lacation_test_date}}" class="form-control form-control-sm">
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
                                <div class="row">
                                    @foreach ($listFiles as $i => $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card h-100 shadow-sm border file-card" data-id="{{ $item->list_file_id }}">
                                                <div class="card-body p-3">
                                                    <!-- File Preview/Thumbnail -->
                                                    <div class="text-center mb-3">
                                                        @if ($item->file_path)
                                                            @php
                                                                $fileExtension = pathinfo($item->file_path, PATHINFO_EXTENSION);
                                                                $fileName = pathinfo($item->file_path, PATHINFO_FILENAME);
                                                                $thumbnailPath = dirname($item->file_path) . '/thumbnails/' . $fileName . '_thumb.jpg';
                                                                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                                $isPdf = strtolower($fileExtension) === 'pdf';
                                                            @endphp
                                                            
                                                            <div class="file-preview-container" style="height: 200px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; position: relative;">
                                                                @if ($isImage)
                                                                    <!-- แสดงภาพจริง -->
                                                                    <img src="{{ asset('storage/' . $item->file_path) }}" 
                                                                         alt="Preview" 
                                                                         class="img-fluid rounded"
                                                                         style="max-height: 190px; max-width: 100%; object-fit: cover;">                                                @elseif ($isPdf)
                                                    <!-- แสดง PDF preview หน้าแรกเท่านั้น -->
                                                    <div class="pdf-preview-container" style="width: 100%; height: 190px; border-radius: 8px; overflow: hidden; background: #f8f9fa; position: relative;"
                                                         data-pdf-url="{{ asset('storage/' . $item->file_path) }}">
                                                        <!-- PDF Viewer with iframe - แสดงแค่หน้าที่ 1 -->
                                                        <iframe src="{{ asset('storage/' . $item->file_path) }}#page=1&toolbar=0&navpanes=0&scrollbar=0&view=Fit&zoom=85" 
                                                                width="100%" 
                                                                height="110%"
                                                                style="border: none; pointer-events: none; margin-top: -5px;"
                                                                class="pdf-iframe"
                                                                onload="handlePdfLoad(this)"
                                                                onerror="handlePdfError(this)">
                                                        </iframe>
                                                        
                                                        <!-- Preview overlay -->
                                                        <div class="pdf-preview-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; text-align: center; padding: 10px 5px; font-size: 12px;">
                                                            <i class="fas fa-file-pdf"></i> หน้าแรก - คลิกเพื่อดูทั้งหมด
                                                        </div>
                                                        
                                                        <!-- Canvas fallback for PDF.js -->
                                                        <canvas class="pdf-canvas d-none" 
                                                                style="width: 100%; height: 100%; object-fit: cover;">
                                                        </canvas>
                                                        
                                                        <!-- Ultimate fallback -->
                                                        <div class="pdf-fallback" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none; align-items: center; justify-content: center; background: #f8f9fa; cursor: pointer;">
                                                            <div class="text-center">
                                                                <i class="fas fa-file-pdf text-danger" style="font-size: 48px;"></i>
                                                                <div class="small text-muted mt-2">PDF Document</div>
                                                                <div class="small text-primary mt-1">{{ basename($item->file_path) }}</div>
                                                                <div class="small text-warning"><i class="fas fa-eye"></i> คลิกเพื่อดูทั้งหมด</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- PDF Action Buttons -->
                                                    <div class="position-absolute" style="top: 8px; right: 8px;">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-sm btn-primary pdf-preview-btn"
                                                                    data-pdf-url="{{ asset('storage/' . $item->file_path) }}"
                                                                    data-file-name="{{ $item->managefile_name }}"
                                                                    title="ดู PDF ทั้งหมด">
                                                                <i class="fas fa-expand"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-success" 
                                                                    onclick="window.open('{{ asset('storage/' . $item->file_path) }}', '_blank')"
                                                                    title="เปิดในแท็บใหม่">
                                                                <i class="fas fa-external-link-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                                @else
                                                                    <!-- แสดงไอคอนสำหรับไฟล์อื่นๆ -->
                                                                    @php
                                                                        $iconClass = 'fas fa-file';
                                                                        $iconColor = 'text-secondary';
                                                                        $fileType = 'Document';
                                                                        
                                                                        switch(strtolower($fileExtension)) {
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
                                                                                $iconClass = 'fas fa-file-powerpoint';
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
                                                                        <i class="{{ $iconClass }} {{ $iconColor }}" style="font-size: 64px;"></i>
                                                                        <div class="small text-muted mt-2">{{ $fileType }}</div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <!-- ยังไม่มีไฟล์ - แสดงพื้นที่อัปโหลด -->
                                                            <div class="file-upload-area text-center p-4" 
                                                                 style="height: 200px; border: 2px dashed #dee2e6; border-radius: 8px; background: #f8f9fa; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                                <i class="fas fa-cloud-upload-alt text-muted" style="font-size: 48px;"></i>
                                                                <div class="small text-muted mt-3">คลิกเพื่อเลือกไฟล์</div>
                                                                <div class="small text-muted">หรือลากไฟล์มาวางที่นี่</div>
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
                                                        <h6 class="card-title mb-2 text-truncate" title="{{ $item->managefile_name }}">
                                                            {{ $item->managefile_name }}
                                                        </h6>
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <small class="text-muted">{{ $item->managefile_code }}</small>
                                                            <span class="badge {{ $item->managefile_step == 'A' ? 'badge-primary' : 'badge-success' }}">
                                                                Step {{ $item->managefile_step }}
                                                            </span>
                                                        </div>
                                                        
                                                        @if ($item->file_path)
                                                            <div class="small text-muted mb-2">
                                                                <i class="fas fa-calendar-alt me-1"></i>
                                                                {{ date('d/m/Y', strtotime($item->updated_at)) }}
                                                            </div>
                                                            
                                                            @php
                                                                $fileSizeBytes = file_exists(storage_path('app/public/' . $item->file_path)) 
                                                                    ? filesize(storage_path('app/public/' . $item->file_path)) 
                                                                    : 0;
                                                                $fileSize = $fileSizeBytes > 0 ? number_format($fileSizeBytes / 1024, 1) . ' KB' : 'ไม่ทราบขนาด';
                                                            @endphp
                                                            <div class="small text-muted mb-3">
                                                                <i class="fas fa-file me-1"></i>
                                                                {{ strtoupper($fileExtension ?? '') }} • {{ $fileSize }}
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
                                                                   target="_blank" 
                                                                   class="btn btn-info btn-sm"
                                                                   title="ดูไฟล์">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @endif
                                                            
                                                            <a href="{{ route('labours.list-files.download', $item) }}" 
                                                               class="btn btn-success btn-sm"
                                                               title="ดาวน์โหลด">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-sm btn-delete"
                                                                    data-url="{{ route('labours.list-files.destroy', $item) }}"
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
            $(document).on('click', '.btn-delete', function() {
                if (!confirm('ยืนยันการลบไฟล์?')) return;
                const $row = $(this).closest('tr');
                const url = $(this).data('url');

                $.ajax({
                    url,
                    type: 'DELETE',
                    success() {
                        // ไอคอนไฟล์
                       // $row.find('td').eq(3).html('<i class="fa fa-file-earmark-slash fs-3 text-muted"></i>');
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
                    
                    previewContainer.html('<div class="text-center"><i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i><div class="small text-muted mt-2">กำลังอัปโหลด...</div></div>');
                    
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
                            if (response.success === true || response.status === 'success' || response.error === false || (response.data && response.data.success)) {
                                // Success - show success message and reload
                                var successMessage = response.message || 'อัปโหลดไฟล์สำเร็จ';
                                
                                // Show success notification
                                previewContainer.html('<div class="text-center text-success"><i class="fas fa-check-circle" style="font-size: 24px;"></i><div class="small mt-2">' + successMessage + '</div></div>');
                                
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else if (response.success === false || response.status === 'error' || response.error === true) {
                                // Explicit error response
                                var errorMessage = response.message || response.error_message || response.msg || 'ไม่ทราบสาเหตุ';
                                alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์: ' + errorMessage);
                                // Reset upload area
                                previewContainer.html('<div class="file-upload-area text-center p-3"><i class="fas fa-cloud-upload-alt text-muted" style="font-size: 36px;"></i><div class="small text-muted mt-2">คลิกเพื่ือเลือกไฟล์</div></div>');
                            } else {
                                // Assume success if no explicit error (some servers return 200 with data)
                                console.log('Assuming success due to 200 response');
                                previewContainer.html('<div class="text-center text-success"><i class="fas fa-check-circle" style="font-size: 24px;"></i><div class="small mt-2">อัปโหลดไฟล์สำเร็จ</div></div>');
                                
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
                                console.log('Got 200 status but jQuery treated as error, checking response:', xhr.responseText);
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.success !== false && !response.error) {
                                        console.log('Treating as success despite error callback');
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
                            previewContainer.html('<div class="file-upload-area text-center p-3"><i class="fas fa-cloud-upload-alt text-muted" style="font-size: 36px;"></i><div class="small text-muted mt-2">คลิกเพื่ือเลือกไฟล์</div></div>');
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
                    return pdf.getPage(1);  // Get first page
                }).then(function(page) {
                    var context = canvas.getContext('2d');
                    var viewport = page.getViewport({ scale: 0.5 });
                    
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
                var pdfUrl = $(this).data('pdf-url') || $(this).closest('.pdf-preview-container').data('pdf-url');
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
            $('#pdfPreviewModal').on('hidden.bs.modal hidden', function () {
                $('#pdfViewer').attr('src', ''); // Clear iframe source
                $('.modal-backdrop').remove(); // Remove any leftover backdrop
            });

            // Ensure modal shows properly
            $('#pdfPreviewModal').on('show.bs.modal show', function () {
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
                    
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Delete response:', response);
                            
                            // Check multiple response formats
                            if (response.success === true || response.status === 'success' || response.error === false) {
                                // Success - show success message and reload
                                var successMessage = response.message || 'ลบไฟล์สำเร็จ';
                                alert(successMessage);
                                
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            } else if (response.success === false || response.status === 'error' || response.error === true) {
                                // Explicit error response
                                var errorMessage = response.message || response.error_message || response.msg || 'ไม่ทราบสาเหตุ';
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

            // Check PDF support and show fallback if needed
            $(document).ready(function() {            // Initialize existing PDF previews after page load
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
                                var iframeDoc = iframe[0].contentDocument || iframe[0].contentWindow.document;
                                if (iframeDoc && iframeDoc.body && iframeDoc.body.innerHTML.trim() !== '') {
                                    iframeLoaded = true;
                                }
                            } catch (e) {
                                // Cross-origin or secure content, assume loaded if no error reported
                                if (iframe[0].contentWindow) {
                                    iframeLoaded = true;
                                }
                            }
                            
                            if (!iframeLoaded) {
                                console.log('PDF iframe may not have loaded, checking fallback for:', pdfUrl);
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
    </script>

    <!-- PDF Preview Modal -->
    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
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
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        <!-- Bootstrap 4 fallback close button -->
                        <button type="button" class="close text-white d-none" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body p-0" style="height: calc(90vh - 120px);">
                    <iframe id="pdfViewer" class="pdf-viewer-iframe" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
                <div class="modal-footer bg-light">
                    <div class="d-flex justify-content-between w-100">
                        <div class="text-muted small">
                            <i class="fas fa-lightbulb"></i> 
                            เคล็ดลับ: ใช้ Ctrl + Mouse Wheel เพื่อซูมเข้า-ออก
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">
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
