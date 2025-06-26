<?php
// Test creating smart PDF thumbnail

// สร้าง smart PDF thumbnail
function createSmartPdfThumbnail($inputFile, $outputFile, $width = 200, $height = 260) {
    try {
        // สร้างภาพพื้นหลังขาว
        $image = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($image, 255, 255, 255);
        $lightGray = imagecolorallocate($image, 240, 240, 240);
        $darkGray = imagecolorallocate($image, 128, 128, 128);
        $blue = imagecolorallocate($image, 50, 120, 200);
        $red = imagecolorallocate($image, 220, 53, 69);
        
        // เติมพื้นหลัง
        imagefill($image, 0, 0, $white);
        
        // วาดเงา
        imagefilledrectangle($image, 5, 5, $width-1, $height-1, $lightGray);
        
        // วาดกรอบเอกสาร
        imagefilledrectangle($image, 0, 0, $width-6, $height-6, $white);
        imagerectangle($image, 0, 0, $width-6, $height-6, $darkGray);
        
        // วาดไอคอน PDF
        $iconSize = 40;
        $iconX = ($width - 6 - $iconSize) / 2;
        $iconY = 20;
        
        // วาดไอคอน PDF แบบง่าย
        imagefilledrectangle($image, $iconX, $iconY, $iconX + $iconSize, $iconY + $iconSize, $red);
        
        // เขียนข้อความ PDF
        if (function_exists('imagettftext')) {
            // ใช้ฟอนต์ built-in
            imagestring($image, 3, $iconX + 8, $iconY + 12, 'PDF', $white);
        } else {
            imagestring($image, 3, $iconX + 8, $iconY + 12, 'PDF', $white);
        }
        
        // เขียนชื่อไฟล์
        $fileName = basename($inputFile, '.pdf');
        $maxLen = 25;
        if (strlen($fileName) > $maxLen) {
            $fileName = substr($fileName, 0, $maxLen) . '...';
        }
        
        imagestring($image, 2, 10, $iconY + $iconSize + 15, $fileName, $darkGray);
        
        // ข้อมูลไฟล์
        if (file_exists($inputFile)) {
            $fileSize = filesize($inputFile);
            $fileSizeText = number_format($fileSize / 1024, 1) . ' KB';
            imagestring($image, 2, 10, $iconY + $iconSize + 35, $fileSizeText, $darkGray);
            
            $modTime = date('d/m/Y', filemtime($inputFile));
            imagestring($image, 2, 10, $iconY + $iconSize + 55, $modTime, $darkGray);
        }
        
        // เขียนเส้นตกแต่ง
        for ($i = 0; $i < 8; $i++) {
            $y = $iconY + $iconSize + 80 + ($i * 12);
            if ($y < $height - 20) {
                imageline($image, 15, $y, $width - 25, $y, $lightGray);
            }
        }
        
        // บันทึกไฟล์
        $result = imagejpeg($image, $outputFile, 85);
        imagedestroy($image);
        
        return $result;
        
    } catch (Exception $e) {
        error_log("Error creating smart PDF thumbnail: " . $e->getMessage());
        return false;
    }
}

// ทดสอบ
echo "=== ทดสอบสร้าง Smart PDF Thumbnail ===\n";

// ใช้ไฟล์ PDF ที่มีอยู่แล้ว (ถ้ามี) หรือสร้างไฟล์ dummy
$testPdfFile = __DIR__ . '/test_document.pdf';
$thumbnailFile = __DIR__ . '/test_document_thumb.jpg';

// สร้างไฟล์ PDF dummy ถ้ายังไม่มี
if (!file_exists($testPdfFile)) {
    echo "กำลังสร้างไฟล์ PDF dummy...\n";
    file_put_contents($testPdfFile, "%PDF-1.4\nThis is a dummy PDF file for testing.\n%%EOF");
    echo "✓ สร้างไฟล์ PDF dummy สำเร็จ: $testPdfFile\n";
}

echo "ขนาดไฟล์ PDF: " . number_format(filesize($testPdfFile) / 1024, 1) . " KB\n";

// สร้าง thumbnail
echo "\nกำลังสร้าง Smart PDF Thumbnail...\n";
if (createSmartPdfThumbnail($testPdfFile, $thumbnailFile)) {
    echo "✓ สร้าง Smart PDF Thumbnail สำเร็จ: $thumbnailFile\n";
    echo "ขนาดไฟล์: " . number_format(filesize($thumbnailFile) / 1024, 1) . " KB\n";
    
    // ตรวจสอบขนาดภาพ
    $imageInfo = getimagesize($thumbnailFile);
    if ($imageInfo) {
        echo "ขนาดภาพ: {$imageInfo[0]} x {$imageInfo[1]} pixels\n";
        echo "ประเภท: {$imageInfo['mime']}\n";
    }
} else {
    echo "✗ ไม่สามารถสร้าง Smart PDF Thumbnail ได้\n";
}

echo "\n=== เสร็จสิ้น ===\n";
echo "ไฟล์ที่สร้าง:\n";
echo "- PDF: $testPdfFile\n";
echo "- Thumbnail: $thumbnailFile\n";
?>
