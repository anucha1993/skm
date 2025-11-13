@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card fade-in">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0"><i class="fas fa-user-plus me-2 text-primary"></i>เพิ่มนายจ้างใหม่</h4>
                                <small class="text-muted">กรอกข้อมูลนายจ้างใหม่</small>
                            </div>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>กลับ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user me-2"></i>ชื่อนายจ้าง <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required placeholder="กรอกชื่อนายจ้าง">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-flag me-2"></i>ประเทศ <span class="text-danger">*</span>
                                    </label>
                                    <select name="country" class="form-select @error('country') is-invalid @enderror" required>
                                        <option value="">-- เลือกประเทศ --</option>
                                        @if(!empty($countryGlobalSet))
                                            @php
                                                $values = $countryGlobalSet->values;
                                                if($countryGlobalSet->sort_order_preference == 'alphabetical') {
                                                    $values = $values->sortBy('value');
                                                }
                                            @endphp
                                            @foreach($values as $item)
                                                <option value="{{ $item->id }}" {{ old('country') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->value }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-toggle-on me-2"></i>สถานะ <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>ใช้งาน</option>
                                        <option value="disabled" {{ old('status') == 'disabled' ? 'selected' : '' }}>ไม่ใช้งาน</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-paperclip me-2"></i>แนบไฟล์ (ถ้ามี)
                                    </label>
                                    <input type="file" name="files[]" class="form-control @error('files') is-invalid @enderror" 
                                           multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                                    <div class="form-text">รองรับไฟล์: PDF, Word, รูปภาพ (สูงสุด 5 ไฟล์)</div>
                                    @error('files')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-sticky-note me-2"></i>หมายเหตุ
                                    </label>
                                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                              rows="4" placeholder="กรอกหมายเหตุเพิ่มเติม">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>ยกเลิก
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>บันทึกข้อมูล
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.form-select, .form-control {
    padding: 12px 16px;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.form-select:focus, .form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.btn {
    padding: 12px 24px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
}
</style>

<script>
$(document).ready(function() {
    // Initialize Select2 for better dropdowns
    $('.form-select').select2({
        theme: 'bootstrap-5',
        placeholder: 'เลือก...'
    });
});
</script>
@endsection
