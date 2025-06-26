<?php
// วิธีที่ 2: ใช้ Browser headless เพื่อแปลง PDF เป็นรูปภาพ
echo "Testing PDF to image conversion using browser...\n";

function createPdfThumbnailWithBrowser($pdfPath, $outputPath) {
    try {
        // สร้าง HTML viewer สำหรับ PDF
        $pdfUrl = 'file:///' . str_replace('\\', '/', realpath($pdfPath));
        
        $htmlContent = '<!DOCTYPE html>
<html>
<head>
    <style>
        body { margin: 0; padding: 20px; }
        embed { width: 100%; height: 600px; }
    </style>
</head>
<body>
    <embed src="' . $pdfUrl . '" type="application/pdf" width="100%" height="600px">
</body>
</html>';
        
        $htmlPath = 'storage/app/public/pdf_viewer.html';
        file_put_contents($htmlPath, $htmlContent);
        
        // ลองใช้ Chrome headless
        $htmlUrl = 'file:///' . str_replace('\\', '/', realpath($htmlPath));
        $command = "chrome --headless --disable-gpu --window-size=800,600 --screenshot=\"$outputPath\" \"$htmlUrl\"";
        
        echo "Attempting: $command\n";
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($outputPath)) {
            echo "SUCCESS: PDF screenshot created\n";
            return true;
        } else {
            echo "Chrome method failed\n";
            return false;
        }
        
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        return false;
    }
}

// วิธีที่ 3: สร้าง thumbnail แบบ Smart placeholder
function createSmartPdfThumbnail($pdfPath, $outputPath) {
    try {
        // อ่านข้อมูลพื้นฐานของ PDF
        $fileSize = filesize($pdfPath);
        $fileName = basename($pdfPath);
        $createdDate = date('Y-m-d H:i:s', filemtime($pdfPath));
        
        // สร้างภาพ thumbnail ที่แสดงข้อมูล PDF
        $width = 300;
        $height = 400;
        
        $image = imagecreate($width, $height);
        
        // กำหนดสี
        $white = imagecolorallocate($image, 255, 255, 255);
        $lightGray = imagecolorallocate($image, 248, 248, 248);
        $darkGray = imagecolorallocate($image, 64, 64, 64);
        $blue = imagecolorallocate($image, 59, 130, 246);
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
        
        // วาดเส้นเนื้อหา
        for ($i = 0; $i < 12; $i++) {
            $lineY = $docY + 40 + ($i * 15);
            $lineWidth = ($i % 3 == 2) ? 120 : 160; // บางบรรทัดสั้นกว่า
            imageline($image, $docX + 20, $lineY, $docX + 20 + $lineWidth, $lineY, $border);
        }
        
        // เขียนข้อมูล PDF
        $y = $docY + $docH + 20;
        imagestring($image, 4, 10, $y, 'PDF Document', $red);
        
        $y += 20;
        $fileName = (strlen($fileName) > 35) ? substr($fileName, 0, 32) . '...' : $fileName;
        imagestring($image, 2, 10, $y, $fileName, $darkGray);
        
        $y += 15;
        imagestring($image, 2, 10, $y, 'Size: ' . formatBytes($fileSize), $darkGray);
        
        $y += 15;
        imagestring($image, 2, 10, $y, 'Modified: ' . date('M j, Y', filemtime($pdfPath)), $darkGray);
        
        // บันทึกเป็น JPEG
        $result = imagejpeg($image, $outputPath, 90);
        imagedestroy($image);
        
        if ($result && file_exists($outputPath)) {
            echo "SUCCESS: Smart PDF thumbnail created at: $outputPath\n";
            return true;
        } else {
            echo "FAILED: Could not save thumbnail\n";
            return false;
        }
        
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        return false;
    }
}

function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = ['B', 'KB', 'MB', 'GB'];
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

// สร้าง PDF ทดสอบแบบง่าย
echo "Creating simple test PDF...\n";

$simpleHtml = '<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
h1 { color: #333; text-align: center; border-bottom: 2px solid #ccc; padding-bottom: 10px; }
.content { margin: 20px 0; }
.box { border: 1px solid #ddd; padding: 15px; margin: 10px 0; background: #f9f9f9; }
ul { margin: 10px 0; padding-left: 20px; }
.footer { margin-top: 40px; text-align: center; color: #666; font-size: 12px; }
</style>
</head>
<body>
<h1>Sample PDF Document</h1>
<div class="content">
<p>This is a test PDF document created for thumbnail generation testing.</p>

<div class="box">
<h3>Document Information</h3>
<ul>
<li>Created: ' . date('Y-m-d H:i:s') . '</li>
<li>Purpose: Testing PDF thumbnail generation</li>
<li>Method: HTML to PDF conversion</li>
</ul>
</div>

<p>This document contains sample content to test various PDF processing methods including:</p>
<ul>
<li>Text extraction</li>
<li>Image generation</li>
<li>Thumbnail creation</li>
<li>File information display</li>
</ul>

<div class="box">
<h3>Sample Content Section</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
</div>
</div>

<div class="footer">
<p>End of Document - PDF Thumbnail Test</p>
</div>
</body>
</html>';

file_put_contents('storage/app/public/test_document.html', $simpleHtml);
echo "HTML document created\n";

// ลองใช้ wkhtmltopdf
$htmlPath = realpath('storage/app/public/test_document.html');
$pdfPath = 'storage/app/public/test_document.pdf';

echo "Converting HTML to PDF...\n";
$command = "wkhtmltopdf \"$htmlPath\" \"$pdfPath\"";
exec($command, $output, $returnCode);

if ($returnCode === 0 && file_exists($pdfPath)) {
    echo "SUCCESS: PDF created at: $pdfPath\n";
    
    // สร้าง smart thumbnail
    $thumbPath = 'storage/app/public/smart_pdf_thumb.jpg';
    createSmartPdfThumbnail($pdfPath, $thumbPath);
    
} else {
    echo "wkhtmltopdf failed. Using existing PDF or create manually.\n";
    
    // ใช้ไฟล์ PDF ที่มีอยู่
    $existingPdf = 'storage/app/public/test.pdf';
    if (file_exists($existingPdf)) {
        echo "Using existing PDF: $existingPdf\n";
        $thumbPath = 'storage/app/public/smart_pdf_thumb.jpg';
        createSmartPdfThumbnail($existingPdf, $thumbPath);
    }
}

echo "\nTest completed!\n";
