<?php

namespace App\Http\Controllers\labours;

use Imagick;
use ImagickPixel;
use ImagickException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\labours\labourModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Models\labours\listfilesModel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class labourUploadfilesController extends Controller
{
    public function upload(Request $request, $labourId, $listFileId)
    {
        $file = $request->validate([
            'file' => 'required|file|max:20480',
        ])['file'];

        $labour = labourModel::findOrFail($labourId);
        $listFile = listfilesModel::findOrFail($listFileId);

        $code = $listFile->managefile_code ?: 'DOC';
        $first = $labour->labour_first_name ?: 'NA';
        $last = $labour->labour_lastname ?: 'NA';
        $ext = strtolower($file->getClientOriginalExtension()) ?: 'dat';

        $idCard = $labour->labour_idcard_number ?: $labour->labour_id;

        $dirRel = "labours/{$idCard}/listfile";
        $dirAbs = storage_path("app/public/{$dirRel}");
        File::ensureDirectoryExists($dirAbs, 0777, true);

        $base = Str::slug("{$code}_{$first}_{$last}", '_') . '_' . time() . ".{$ext}";
        $destAbs = "{$dirAbs}/{$base}";
        $destRel = "{$dirRel}/{$base}";

        // ลบไฟล์เดิม
        if ($listFile->file_path) {
            $oldAbs = storage_path("app/public/{$listFile->file_path}");
            if (File::exists($oldAbs)) {
                File::delete($oldAbs);
            }
        }
        if ($listFile->thumbnail_path && !str_starts_with($listFile->thumbnail_path, 'placeholders/')) {
            $oldThumbAbs = storage_path("app/public/{$listFile->thumbnail_path}");
            if (File::exists($oldThumbAbs)) {
                File::delete($oldThumbAbs);
            }
        }

        // ย้ายไฟล์ใหม่
        $file->move($dirAbs, $base);

        // thumbnail path
        $thumbnailPath = null;
        
        Log::info("Processing file for thumbnail: {$destAbs}, extension: {$ext}");

        try {
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                // กรณีเป็นภาพ
                $thumbName = 'thumb_' . $base;
                $thumbRel = "{$dirRel}/{$thumbName}";
                $thumbAbs = "{$dirAbs}/{$thumbName}";

                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                $manager->read($destAbs)->cover(300, 300)->save($thumbAbs, quality: 90);

                if (File::exists($thumbAbs)) {
                    $thumbnailPath = $thumbRel;
                    Log::info("Image thumbnail created successfully: {$thumbAbs}");
                } else {
                    Log::error("Image thumbnail file was not created: {$thumbAbs}");
                }
            } elseif ($ext === 'pdf') {
                // กรณีเป็น PDF - ไม่สร้าง thumbnail แล้ว จะใช้ live preview แทน
                Log::info("PDF file uploaded, will use live preview: {$destAbs}");
                // ไม่ต้องสร้าง thumbnail สำหรับ PDF
            } elseif (in_array($ext, ['doc', 'docx'])) {
                // กรณีเป็น Word Document
                $thumbName = 'thumb_' . pathinfo($base, PATHINFO_FILENAME) . '.jpg';
                $thumbRel = "{$dirRel}/{$thumbName}";
                $thumbAbs = "{$dirAbs}/{$thumbName}";
                
                $this->createDocumentIcon($thumbAbs, 'WORD', '#2563eb'); // สีน้ำเงิน
                
                if (File::exists($thumbAbs)) {
                    $thumbnailPath = $thumbRel;
                }
            } elseif (in_array($ext, ['xls', 'xlsx'])) {
                // กรณีเป็น Excel
                $thumbName = 'thumb_' . pathinfo($base, PATHINFO_FILENAME) . '.jpg';
                $thumbRel = "{$dirRel}/{$thumbName}";
                $thumbAbs = "{$dirAbs}/{$thumbName}";
                
                $this->createDocumentIcon($thumbAbs, 'EXCEL', '#16a34a'); // สีเขียว
                
                if (File::exists($thumbAbs)) {
                    $thumbnailPath = $thumbRel;
                }
            } elseif (in_array($ext, ['ppt', 'pptx'])) {
                // กรณีเป็น PowerPoint
                $thumbName = 'thumb_' . pathinfo($base, PATHINFO_FILENAME) . '.jpg';
                $thumbRel = "{$dirRel}/{$thumbName}";
                $thumbAbs = "{$dirAbs}/{$thumbName}";
                
                $this->createDocumentIcon($thumbAbs, 'PPT', '#dc2626'); // สีแดง
                
                if (File::exists($thumbAbs)) {
                    $thumbnailPath = $thumbRel;
                }
            }
        } catch (\Exception $e) {
            Log::error('Thumbnail creation failed: ' . $e->getMessage());
        }

        $listFile->update([
            'file_path' => $destRel,
            'thumbnail_path' => $thumbnailPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ไฟล์ถูกอัปโหลดเรียบร้อยแล้ว',
            'data' => [
                'id' => $listFile->list_file_id,
                'url' => asset("storage/{$destRel}"),
                'download' => route('labours.list-files.download', $listFile),
                'updated' => now()->format('d-m-Y'),
                'thumbnail' => $thumbnailPath ? asset("storage/{$thumbnailPath}") : null,
                // เพิ่ม URL สำหรับดู PDF
                'preview_url' => $ext === 'pdf' ? route('labours.list-files.pdf-viewer', $listFile) : null,
                'view_url' => $ext === 'pdf' ? route('labours.list-files.view-pdf', $listFile) : null,
                'file_type' => $ext,
            ]
        ]);
    }

    public function destroy($listFileId)
    {
        $listFile = listfilesModel::findOrFail($listFileId);

        // ลบไฟล์หลัก
        if ($listFile->file_path) {
            $abs = storage_path("app/public/{$listFile->file_path}");
            if (File::exists($abs)) {
                try {
                    File::delete($abs);
                } catch (\Exception $e) {
                    Log::error('Failed to delete file: ' . $e->getMessage());
                }
            }
        }

        // ลบไฟล์ thumbnail
        if ($listFile->thumbnail_path && !str_starts_with($listFile->thumbnail_path, 'placeholders/')) {
            $thumbAbs = storage_path("app/public/{$listFile->thumbnail_path}");
            if (File::exists($thumbAbs)) {
                try {
                    File::delete($thumbAbs);
                } catch (\Exception $e) {
                    Log::error('Failed to delete thumbnail: ' . $e->getMessage());
                }
            }
        }

        $listFile->update([
            'file_path' => null,
            'thumbnail_path' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ลบไฟล์สำเร็จ'
        ]);
    }

    public function download(listfilesModel $listFile)
    {
        abort_unless($listFile->file_path, 404);
        $abs = storage_path("app/public/{$listFile->file_path}");
        $name = basename($abs);
        return response()->download($abs, $name);
    }

    /**
     * แสดง PDF ใน browser
     */
    public function viewPdf(listfilesModel $listFile)
    {
        abort_unless($listFile->file_path, 404);
        
        $abs = storage_path("app/public/{$listFile->file_path}");
        
        if (!File::exists($abs)) {
            abort(404);
        }
        
        // ตรวจสอบว่าเป็นไฟล์ PDF
        $ext = strtolower(pathinfo($abs, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            abort(400, 'File is not a PDF');
        }
        
        return response()->file($abs, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($abs) . '"'
        ]);
    }
    
    /**
     * สร้างหน้า PDF viewer พร้อม PDF.js
     */
    public function pdfViewer(listfilesModel $listFile)
    {
        abort_unless($listFile->file_path, 404);
        
        $abs = storage_path("app/public/{$listFile->file_path}");
        
        if (!File::exists($abs)) {
            abort(404);
        }
        
        $ext = strtolower(pathinfo($abs, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            abort(400, 'File is not a PDF');
        }
        
        $pdfUrl = asset("storage/{$listFile->file_path}");
        $fileName = basename($abs);
        
        return view('pdf-viewer', compact('pdfUrl', 'fileName', 'listFile'));
    }

    /**
     * สร้าง thumbnail จากหน้าแรกของ PDF จริง
     */
    private function createRealPdfThumbnail($pdfPath, $outputPath)
    {
        try {
            // ตรวจสอบว่ามี Imagick extension
            if (!extension_loaded('imagick')) {
                Log::error('Imagick extension not loaded');
                return false;
            }

            // ตรวจสอบว่าไฟล์ PDF มีอยู่จริง
            if (!File::exists($pdfPath)) {
                Log::error("PDF file not found: {$pdfPath}");
                return false;
            }

            // สร้าง Imagick object
            $imagick = new \Imagick();
            
            // ตั้งค่าความละเอียดก่อนอ่านไฟล์
            $imagick->setResolution(150, 150);
            
            // อ่านหน้าแรกของ PDF เท่านั้น
            $imagick->readImage($pdfPath . '[0]'); // [0] หมายถึงหน้าแรก
            
            // ตั้งค่าให้เป็นรูปแบบ JPEG
            $imagick->setImageFormat('jpeg');
            
            // ปรับขนาดให้เหมาะสม (300x400 พอ)
            $imagick->resizeImage(300, 400, \Imagick::FILTER_LANCZOS, 1, true);
            
            // ปรับคุณภาพ
            $imagick->setImageCompressionQuality(90);
            
            // เพิ่มพื้นหลังสีขาวสำหรับ PDF ที่มีพื้นหลังโปร่งใส
            $imagick->setImageBackgroundColor(new \ImagickPixel('white'));
            $imagick = $imagick->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
            
            // บันทึกไฟล์
            $result = $imagick->writeImage($outputPath);
            
            // ล้างหน่วยความจำ
            $imagick->clear();
            $imagick->destroy();
            
            if ($result && File::exists($outputPath)) {
                Log::info("Real PDF thumbnail created successfully: {$outputPath}");
                return true;
            } else {
                Log::error("Failed to save PDF thumbnail: {$outputPath}");
                return false;
            }
            
        } catch (\ImagickException $e) {
            Log::error('ImagickException when creating PDF thumbnail: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('Exception when creating PDF thumbnail: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * สร้าง Smart PDF thumbnail ที่แสดงข้อมูลไฟล์และรูปแบบเอกสาร
     */
    private function createSmartPdfThumbnail($pdfPath, $outputPath)
    {
        try {
            // อ่านข้อมูลพื้นฐานของ PDF
            $fileSize = filesize($pdfPath);
            $fileName = basename($pdfPath);
            
            // สร้างภาพ thumbnail ที่แสดงข้อมูล PDF
            $width = 300;
            $height = 400;
            
            $image = imagecreate($width, $height);
            
            // กำหนดสี
            $white = imagecolorallocate($image, 255, 255, 255);
            $lightGray = imagecolorallocate($image, 248, 248, 248);
            $darkGray = imagecolorallocate($image, 64, 64, 64);
            $red = imagecolorallocate($image, 220, 38, 38);
            $border = imagecolorallocate($image, 200, 200, 200);
            
            // เติมพื้นหลัง
            imagefill($image, 0, 0, $lightGray);
            
            // วาดรูปเอกสาร
            $docX = 50;
            $docY = 30;
            $docW = 200;
            $docH = 260;
            
            // เงา
            imagefilledrectangle($image, $docX + 5, $docY + 5, $docX + $docW + 5, $docY + $docH + 5, $border);
            
            // ตัวเอกสาร
            imagefilledrectangle($image, $docX, $docY, $docX + $docW, $docY + $docH, $white);
            imagerectangle($image, $docX, $docY, $docX + $docW, $docY + $docH, $border);
            
            // วาดมุมพับ
            $foldSize = 25;
            imagefilledpolygon($image, [
                $docX + $docW - $foldSize, $docY,
                $docX + $docW, $docY,
                $docX + $docW, $docY + $foldSize,
                $docX + $docW - $foldSize, $docY + $foldSize
            ], 4, $lightGray);
            
            // วาดเส้นเนื้อหา (จำลองข้อความในเอกสาร)
            for ($i = 0; $i < 12; $i++) {
                $lineY = $docY + 40 + ($i * 15);
                $lineWidth = ($i % 3 == 2) ? 120 : 160; // บางบรรทัดสั้นกว่า
                imageline($image, $docX + 20, $lineY, $docX + 20 + $lineWidth, $lineY, $border);
            }
            
            // เขียนข้อมูล PDF
            $y = $docY + $docH + 20;
            imagestring($image, 4, 10, $y, 'PDF Document', $red);
            
            $y += 20;
            $displayName = (strlen($fileName) > 35) ? substr($fileName, 0, 32) . '...' : $fileName;
            imagestring($image, 2, 10, $y, $displayName, $darkGray);
            
            $y += 15;
            imagestring($image, 2, 10, $y, 'Size: ' . $this->formatFileSize($fileSize), $darkGray);
            
            $y += 15;
            imagestring($image, 2, 10, $y, 'Modified: ' . date('M j, Y', filemtime($pdfPath)), $darkGray);
            
            // บันทึกเป็น JPEG
            $result = imagejpeg($image, $outputPath, 90);
            imagedestroy($image);
            
            if ($result && File::exists($outputPath)) {
                Log::info("Smart PDF thumbnail created at: {$outputPath}");
                return true;
            } else {
                Log::error("Failed to save smart PDF thumbnail: {$outputPath}");
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to create smart PDF thumbnail: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * แปลงขนาดไฟล์เป็นรูปแบบที่อ่านง่าย
     */
    private function formatFileSize($size, $precision = 1)
    {
        if ($size === 0) return '0 B';
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
    
    /**
     * สร้างไอคอนสำหรับเอกสารประเภทอื่นๆ (Word, Excel, PowerPoint)
     */
    private function createDocumentIcon($outputPath, $text, $color)
    {
        try {
            // สร้างภาพไอคอน 300x300
            $width = 300;
            $height = 300;
            
            // สร้าง image resource
            $image = imagecreate($width, $height);
            
            // กำหนดสี
            $white = imagecolorallocate($image, 255, 255, 255);
            $lightGray = imagecolorallocate($image, 248, 250, 252);
            $border = imagecolorallocate($image, 209, 213, 219);
            
            // แปลง hex color เป็น RGB
            $colorRGB = $this->hexToRgb($color);
            $textColor = imagecolorallocate($image, $colorRGB[0], $colorRGB[1], $colorRGB[2]);
            
            // เติมสีพื้นหลัง
            imagefill($image, 0, 0, $lightGray);
            
            // วาดรูปสี่เหลี่ยมแทนเอกสาร
            $docX = 75;
            $docY = 50;
            $docW = 150;
            $docH = 200;
            
            // เงาของเอกสาร
            imagefilledrectangle($image, $docX + 5, $docY + 5, $docX + $docW + 5, $docY + $docH + 5, $border);
            
            // ตัวเอกสาร
            imagefilledrectangle($image, $docX, $docY, $docX + $docW, $docY + $docH, $white);
            imagerectangle($image, $docX, $docY, $docX + $docW, $docY + $docH, $border);
            
            // วาดมุมพับ
            $foldSize = 20;
            imagefilledpolygon($image, [
                $docX + $docW - $foldSize, $docY,
                $docX + $docW, $docY,
                $docX + $docW, $docY + $foldSize,
                $docX + $docW - $foldSize, $docY + $foldSize
            ], 4, $lightGray);
            
            // เส้นในเอกสาร
            for ($i = 0; $i < 8; $i++) {
                $lineY = $docY + 40 + ($i * 15);
                imageline($image, $docX + 15, $lineY, $docX + $docW - 15, $lineY, $border);
            }
            
            // เขียนข้อความ
            $font_size = 4;
            $text_width = strlen($text) * imagefontwidth($font_size);
            $text_x = ($width - $text_width) / 2;
            $text_y = $docY + $docH + 20;
            
            imagestring($image, $font_size, $text_x, $text_y, $text, $textColor);
            
            // บันทึกเป็น JPEG
            imagejpeg($image, $outputPath, 90);
            
            // ล้างหน่วยความจำ
            imagedestroy($image);
            
            Log::info("Document icon created at: {$outputPath}");
            
        } catch (\Exception $e) {
            Log::error('Failed to create document icon: ' . $e->getMessage());
        }
    }
    
    /**
     * แปลง hex color เป็น RGB array
     */
    private function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        ];
    }
}
