<?php

namespace App\Http\Controllers\labours;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\labours\labourModel;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class labourUploadImageProfileController extends Controller
{
    //
    public function uploadImage(Request $request, labourModel $labour)
{
    /* 1) ตรวจไฟล์ */
    $file = $request->validate([
        'image_profile' => 'required|image|max:5120',
    ])['image_profile'];

    /* 2) ตั้งชื่อ/โฟลเดอร์ */
    $labourId = $labour->labour_id;
    $idCard   = $labour->labour_idcard_number ?: uniqid();
    $ext      = $file->getClientOriginalExtension() ?: 'jpg';

    $dirRel = "labours/{$idCard}";
    $dirAbs = storage_path("app/public/{$dirRel}");
    File::ensureDirectoryExists($dirAbs, 0777, true);

    $base   = "image_profile_{$idCard}.{$ext}";
    $thumb  = "thumb_{$base}";
    $origAbs  = "{$dirAbs}/{$base}";
    $thumbAbs = "{$dirAbs}/{$thumb}";

    /* 3) ลบไฟล์เดิม */
    foreach ([$labour->labour_image_path, $labour->labour_image_thumbnail_path] as $oldRel) {
        $oldAbs = $oldRel ? storage_path("app/public/{$oldRel}") : null;
        if ($oldAbs && File::exists($oldAbs)) {
            File::delete($oldAbs);
        }
    }

    /* 4) ย้ายไฟล์ต้นฉบับ */
    $file->move($dirAbs, $base);

    /* 5) สร้าง thumbnail */
    $manager = new ImageManager(new GdDriver());
    $manager->read($origAbs)
            ->cover(300, 300)
            ->save($thumbAbs, quality: 90);    // ← save() ใช้ได้ใน v3.11

    /* 6) อัปเดต DB */
    $labour->update([
        'labour_image_path'           => "{$dirRel}/{$base}",
        'labour_image_thumbnail_path' => "{$dirRel}/{$thumb}",
    ]);

    /* 7) ตอบกลับ */
    return response()->json([
        'status'        => true,
        'image_url'     => asset("storage/{$dirRel}/{$base}"),
        'thumbnail_url' => asset("storage/{$dirRel}/{$thumb}"),
        'message'       => 'อัปโหลดรูปสำเร็จ',
    ]);
}

}
