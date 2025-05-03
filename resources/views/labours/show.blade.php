@extends('layouts.template')

@section('content')
@php
    use Carbon\Carbon;
    $thai = fn($d)=> $d ? Carbon::parse($d)->format('d/m/Y') : '–';
    $left = fn($d)=> $d ? now()->diffInDays(Carbon::parse($d),false).' วัน' : '–';
@endphp

<div class="container-xl">
  <div class="row justify-content-center">
    <div class="col-lg-10">

      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

          {{-- HEADER ------------------------------------------------------- --}}
          <div class="d-flex flex-column flex-md-row align-items-center gap-4 mb-4">
            <div class="position-relative">
              <img  src="{{ $labour->labour_image_thumbnail_path
                               ? asset('storage/'.$labour->labour_image_thumbnail_path)
                               : asset('/template/dist/assets/images/user/avatar-1.jpg') }}"
                    class="rounded-circle border border-2"
                    style="width:160px;height:160px;object-fit:cover;">
              <div class="position-absolute bottom-0 end-0 translate-middle">
                @foreach(['A','B'] as $s)
                  <span class="badge bg-{{ in_array($s,$labour->completed_steps)?'success':'secondary' }} rounded-pill me-1">
                    Step {{ $s }}
                  </span>
                @endforeach
              </div>
            </div>

            <div class="flex-fill">
              <h3 class="fw-bold mb-1">
                {{ $labour->labour_prefix }}
                {{ $labour->labour_firstname }}
                {{ $labour->labour_lastname }}
              </h3>
              <p class="text-muted mb-2"><i class="fa fa-id-card-alt me-1"></i>{{ $labour->labour_idcard_number }}</p>
              <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-primary">อายุ {{ Carbon::parse($labour->labour_birthday)->age }} ปี</span>
                <span class="badge bg-info text-dark">{{ optional($labour->labourStatus)->value ?? '–' }}</span>
                @if($labour->company)
                  <span class="badge bg-warning text-dark">{{ $labour->company->name }}</span>
                @endif
              </div>
            </div>
          </div>

          {{-- NAV --------------------------------------------------------- --}}
          <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-bs-toggle="tab" href="#all" role="tab">ข้อมูลทั้งหมด</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"       data-bs-toggle="tab" href="#docs" role="tab">ไฟล์เอกสาร</a>
            </li>
          </ul>

          <div class="tab-content">

            {{-- TAB : ข้อมูลทั้งหมด -------------------------------------- --}}
            <div class="tab-pane fade show active" id="all" role="tabpanel">
              {{-- ───────── ข้อมูลส่วนตัว ───────── --}}
              <h6 class="fw-semibold mt-2">ข้อมูลส่วนตัว</h6><hr class="mt-1 mb-3">
              <div class="row gy-3">
                @foreach([
                  'คำนำหน้า'          => $labour->labour_prefix,
                  'ชื่อ'               => $labour->labour_firstname.' '.$labour->labour_lastname,
                
                  'วันเกิด'           => $thai($labour->labour_birthday),
                  'เบอร์ติดต่อ'       => $labour->labour_phone_one,
                  'เบอร์ติดต่อฉุกเฉิน'=> $labour->labour_phone_two,
                  'สถานะคนงาน'        => $labour->labourStatus->value,
                ] as $label=>$val)
                  <div class="col-md-6"><div class="d-flex">
                    <span class="fw-semibold text-secondary flex-shrink-0" style="min-width:140px;">{{ $label }}</span>
                    <span class="ms-2">{{ $val ?: '–' }}</span>
                  </div></div>
                @endforeach
              </div>

              {{-- ───────── หนังสือเดินทาง ───────── --}}
              <h6 class="fw-semibold mt-4">ข้อมูลหนังสือเดินทาง</h6><hr class="mt-1 mb-3">
              <div class="row gy-3">
                @foreach([
                  'เลขหนังสือเดินทาง' => $labour->labour_passport_number,
                  'วันออก'            => $thai($labour->labour_passport_issue_date),
                  'วันหมดอายุ'        => $thai($labour->labour_passport_expiry_date),
                  'วันคงเหลือ'        => $left($labour->labour_passport_expiry_date),
                ] as $label=>$val)
                  <div class="col-md-6"><div class="d-flex">
                    <span class="fw-semibold text-secondary flex-shrink-0" style="min-width:140px;">{{ $label }}</span>
                    <span class="ms-2">{{ $val ?: '–' }}</span>
                  </div></div>
                @endforeach
              </div>

              {{-- ───────── ผลตรวจ / CID ───────── --}}
              <h6 class="fw-semibold mt-4">ผลตรวจ / CID</h6><hr class="mt-1 mb-3">
              <div class="row gy-3">
                @foreach([
                  'โรงพยาบาล'      => optional($labour->hospital)->value,
                  'วันออกผล'       => $thai($labour->labour_disease_issue_date),
                  'วันรับผล'       => $thai($labour->labour_disease_receive_date),
                  'ผลโรคหมดอายุ'  => $left(
                    $labour->labour_disease_issue_date
                      ? Carbon::parse($labour->labour_disease_issue_date)->addDays(30)
                      : null
                  ),
                ] as $label=>$val)
                  <div class="col-md-6"><div class="d-flex">
                    <span class="fw-semibold text-secondary flex-shrink-0" style="min-width:140px;">{{ $label }}</span>
                    <span class="ms-2">{{ $val ?: '–' }}</span>
                  </div></div>
                @endforeach
              </div>

              {{-- ───────── งาน / สถานะ ───────── --}}
              <h6 class="fw-semibold mt-4">รายละเอียดงาน & การจัดเก็บเอกสาร</h6><hr class="mt-1 mb-3">
              <div class="row gy-3">
                @foreach([
                  'บริษัทนายจ้าง'     => optional($labour->company)->name,
                  'ใบสมัครเลขที่'    => $labour->labour_register_number,
                  'การจัดเก็บเอกสาร'=> optional($labour->manageDoc)->managedoc_name,
                  'ประเทศ'          => optional($labour->country)->value,
                  'กลุ่มงาน'         => optional($labour->jobGroup)->value,
                  'ตำแหน่ง'         => optional($labour->position)->value,
                ] as $label=>$val)
                  <div class="col-md-6"><div class="d-flex">
                    <span class="fw-semibold text-secondary flex-shrink-0" style="min-width:140px;">{{ $label }}</span>
                    <span class="ms-2">{{ $val ?: '–' }}</span>
                  </div></div>
                @endforeach
              </div>

              {{-- ───────── เจ้าหน้าที่สรรหา ───────── --}}
              <h6 class="fw-semibold mt-4">ข้อมูลเจ้าหน้าที่สรรหา</h6><hr class="mt-1 mb-3">
              <div class="row gy-3">
                @foreach([
                  'ศูนย์สอบ'   => optional($labour->examinationCenter)->value,
                  'รอบสอบวันที่'=> $thai($labour->lacation_test_date),
                  'เจ้าหน้าที่' => optional($labour->staff)->value,
                  'ชื่อสาย'    => optional($labour->staffSub)->value,
                ] as $label=>$val)
                  <div class="col-md-6"><div class="d-flex">
                    <span class="fw-semibold text-secondary flex-shrink-0" style="min-width:140px;">{{ $label }}</span>
                    <span class="ms-2">{{ $val ?: '–' }}</span>
                  </div></div>
                @endforeach
              </div>
              <h6 class="fw-semibold mt-4">บันทึกเพิ่มเติม</h6><hr class="mt-1 mb-3">
              <div class="row gy-3">
               <div class="col-md-6"> <div class="d-flex">
                {{$labour->labour_note}}
                </div>
                </div>
              </div>

            </div><!-- /tab all -->

            {{-- TAB : ไฟล์เอกสาร ---------------------------------------- --}}
            <div class="tab-pane fade" id="docs" role="tabpanel">
              <h6 class="fw-bold"><i class="fa fa-paperclip me-1"></i>ไฟล์เอกสาร</h6><hr class="mt-1 mb-3">
              <div class="table-responsive">
                <table class="table table-striped align-middle">
                  <thead class="table-light">
                    <tr>
                      <th style="width:36px;">#</th>
                      <th>Code</th>
                      <th>ชื่อไฟล์</th>
                      <th class="text-center">Step</th>
                      <th class="text-center">อัปเดตล่าสุด</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($listFiles as $i=>$f)
                      <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $f->managefile_code }}</td>
                        <td>
                          @if($f->file_path)
                            <a href="{{ asset('storage/'.$f->file_path) }}" target="_blank">
                              {{ $f->managefile_name }}
                              
                            </a>
                            {!!$f->file_path ? '<i class="fa fa-paperclip me-1 text-danger">' : ''!!}
                          @else
                            {{ $f->managefile_name }}
                          @endif
                        </td>
                        <td class="text-center">{{ $f->managefile_step }}</td>
                        <td class="text-center">{{ $f->file_path ? $thai($f->updated_at) : '-' }}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div><!-- /tab docs -->

          </div><!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div><!-- /.card -->

    </div>
  </div>
</div>
@endsection
