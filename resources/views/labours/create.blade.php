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
                        <a class="nav-link active text-uppercase" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ข้อมูลส่วนตัว</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <label for="">คำนำหน้า <span class="text-danger">*</span></label>
                                <select name="labour_prefix" class="form-control form-control-sm" required>
                                    <option value="">---Select---</option>
                                    <option value="MR.">นาย</option>
                                    <option value="MRS.">นาง</option>
                                    <option value="MISS.">นางสาว</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="">ชื่อ <span class="text-danger">*</span></label>
                                <input type="text" name="labour_firstname" class="form-control form-control-sm" placeholder="ชื่อจริง" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="">นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" name="labour_lastname" class="form-control form-control-sm" placeholder="นามสกุล" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="">รหัสบัตรประจำตัวประชาชน </label>
                                <input type="text" name="labour_idcard_number" class="form-control form-control-sm" placeholder="00000000000">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">หมายเลขพาสปอร์ต </label>
                                <input type="text" name="labour_passport_number" class="form-control form-control-sm" placeholder="00000000000">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">วันหมดอายุพาสปอร์ต </label>
                                <input type="date" name="labour_passport_date_expire" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">สัญชาติ </label>
                                  <select name="labour_nationality" class="form-control form-control-sm" required>
                                    <option value="">---Select---</option>
                                   
                                  </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">ศาสนา </label>
                                <select name="labour_religion" class="form-control form-control-sm" required>
                                    <option value="">---Select---</option>
                                   
                                  </select>
                            </div>
                
                            <div class="col-md-6 mb-2">
                                <label for="">วันเกิด </label>
                                <input type="date" name="labour_birthday" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">น้ำหนัก <span class="text-primary">หน่วยเป็น kg.</span></label>
                                <input type="number" name="labour_weight" class="form-control form-control-sm" placeholder="65">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">ส่วนสูง <span class="text-primary">หน่วยเป็น Cm.</span></label>
                                <input type="number" name="labour_height" class="form-control form-control-sm" placeholder="165">
                            </div>
                
                            <div class="col-md-3 mb-2">
                                <label for="">สถานภาพสมรส </label>
                                <select name="labour_marital" class="form-control form-control-sm" required>
                                    <option value="">---Select---</option>
                                   
                                  </select>
                            </div>
                            
                            <div class="col-md-3 mb-2">
                                <label for="">จำนวนบุตร </label>
                                <select name="labour_children" class="form-control form-control-sm" required>
                                    <option value="">---Select---</option>
                                   
                                  </select>
                            </div>
                
                            <div class="col-md-6 mb-2">
                                <label for="">ใบอนุญาตขับขี่ </label>
                                <select name="labour_license" class="form-control form-control-sm" required>
                                    <option value="">---Select---</option>
                                   
                                  </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="">แขนที่ถนัด</label><br>
                                <input type="radio" name="labour_arm" value="right"> <label for="">แขนขวา</label>
                                <input type="radio" name="labour_arm" value="left"> <label for="">แขนซ้าย</label>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="">สูบบุรี่</label><br>
                                <input type="radio" name="labour_smoking" value="Y"> <label for="">สูบ</label>
                                <input type="radio" name="labour_smoking" value="N"> <label for="">ไม่สูบ</label>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="">ดื่มแอลกอฮอล์</label><br>
                                <input type="radio" name="labour_alcohol" value="N"> <label for="">ไม่ดื่ม</label>
                                <input type="radio" name="labour_alcohol" value="A"> <label for="">บางครั้ง</label>
                                <input type="radio" name="labour_alcohol" value="Y"> <label for="">ดื่ม</label>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="">มีรอยสัก (ระบุ)</label><br>
                                <textarea name="labour_tattoo" class="form-control form-control-sm"  rows="2" placeholder="หากมีรอยสักให้ระบุ"></textarea>
                            </div>

                            <div class="col-md-12 mb-2 ">
                                <a  class="btn btn-success float-right text-white" >Next Step</a>
                            </div>

                          
                          
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <p class="mb-0">Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four
                            loko
                            farm-to-table
                            craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. accusamus tattooed echo park.</p>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <p class="mb-0">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed
                            craft beer,
                            iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Lnyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    




@endsection