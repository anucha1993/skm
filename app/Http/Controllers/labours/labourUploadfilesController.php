<?php

namespace App\Http\Controllers\labours;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\labours\labourModel;
use Illuminate\Support\Facades\File;
use App\Models\labours\listfilesModel;
use Illuminate\Support\Facades\Storage;
 use Illuminate\Support\Str;
class labourUploadfilesController extends Controller
{
    //
    /** อัปโหลดไฟล์ */
   

    public function upload(Request $request, $labourId, $listFileId)
{
    /* 1) ตรวจไฟล์ที่ส่งมา */
    $file = $request->validate([
        'file' => 'required|file|max:20480',              // ≤ 20 MB
    ])['file'];

    /* 2) เตรียมข้อมูลโมเดล */
    $labour   = labourModel::findOrFail($labourId);
    $listFile = listfilesModel::findOrFail($listFileId);

    /* 3) ตั้งชื่อ / โฟลเดอร์ปลายทาง */
    $code   = $listFile->managefile_code ?: 'DOC';        // กันว่าง
    $first  = $labour->labour_first_name  ?: 'NA';
    $last   = $labour->labour_lastname    ?: 'NA';
    $ext    = $file->getClientOriginalExtension() ?: 'dat';

    // ใช้ idCard เป็นโฟลเดอร์ (หรือจะใช้ labour_id ก็ได้)
    $idCard = $labour->labour_idcard_number ?: $labour->labour_id;

    $dirRel = "labours/{$idCard}/listfile";                        // relative (เก็บใน public disk)
    $dirAbs = storage_path("app/public/{$dirRel}");
    File::ensureDirectoryExists($dirAbs, 0777, true);

    // slug ให้ปลอดภัย + time() กันชื่อซ้ำ
    $base    = Str::slug("{$code}_{$first}_{$last}", '_')
               .'_'.time().".{$ext}";
    $destAbs = "{$dirAbs}/{$base}";
    $destRel = "{$dirRel}/{$base}";

    /* 4) ลบไฟล์เก่า (ถ้ามี) */
    if ($listFile->file_path) {
        $oldAbs = storage_path("app/public/{$listFile->file_path}");
        if (File::exists($oldAbs)) File::delete($oldAbs);
    }

    /* 5) ย้ายไฟล์ใหม่ */
    $file->move($dirAbs, $base);

    /* 6) อัปเดต DB */
    $listFile->update(['file_path' => $destRel]);

    /* 7) ตอบกลับ */
    return response()->json([
        'id'        => $listFile->list_file_id,
        'url'       => asset("storage/{$destRel}"),                       // เปิดดู
        'download'  => route('labours.list-files.download', $listFile),   // ดาวน์โหลด
        'updated'   => now()->format('d-m-Y'),
    ]);
}

public function destroy($listFileId)
{
    $listFile = listfilesModel::findOrFail($listFileId);

    if ($listFile->file_path) {
        $abs = storage_path("app/public/{$listFile->file_path}");
        File::delete($abs);                      // ไม่ error ถ้าไฟล์ไม่มี
    }

    $listFile->update(['file_path' => null]);

    return response()->json(['message' => 'ลบไฟล์สำเร็จ']);
}


public function download(listfilesModel $listFile)
{
    abort_unless($listFile->file_path, 404);
    $abs = storage_path("app/public/{$listFile->file_path}");
    $name = basename($abs);
    return response()->download($abs, $name);
}

}
