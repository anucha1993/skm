<?php
// ทดสอบ Imagick กับ PDF อย่างง่าย
echo "Testing Imagick with PDF...\n";

if (!extension_loaded('imagick')) {
    echo "Imagick extension is not loaded!\n";
    exit(1);
}

// ตรวจสอบ delegate ของ Imagick
try {
    $imagick = new Imagick();
    $delegates = $imagick->queryConfigureOptions();
    echo "Imagick delegates available:\n";
    foreach ($delegates as $delegate) {
        if (strpos($delegate, 'DELEGATE') !== false) {
            echo "  $delegate\n";
        }
    }
    
    // ตรวจสอบ policy
    $policies = $imagick->getConfigureOptions();
    if (isset($policies['POLICY'])) {
        echo "Policy path: " . $policies['POLICY'] . "\n";
    }
    
    $imagick->clear();
    $imagick->destroy();
    
} catch (Exception $e) {
    echo "Error checking Imagick configuration: " . $e->getMessage() . "\n";
}

// สร้าง PDF ทดสอบง่ายๆ
echo "\nCreating simple test PDF...\n";

// สร้างเนื้อหา PDF ด้วย HTML เรียบง่าย
$htmlContent = '<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #333; text-align: center; }
.box { border: 2px solid #ccc; padding: 15px; margin: 10px 0; }
</style>
</head>
<body>
<h1>Test PDF Document</h1>
<p>This is a test PDF for thumbnail generation.</p>
<div class="box">
<h3>Sample Content Box</h3>
<p>Date: ' . date('Y-m-d H:i:s') . '</p>
<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 3</li>
</ul>
</div>
<p>End of document.</p>
</body>
</html>';

// บันทึกเป็น HTML
if (!file_exists('storage/app/public')) {
    mkdir('storage/app/public', 0777, true);
}

file_put_contents('storage/app/public/test_content.html', $htmlContent);
echo "HTML content saved to: storage/app/public/test_content.html\n";

// ลองใช้ wkhtmltopdf หากมี
$htmlPath = realpath('storage/app/public/test_content.html');
$pdfPath = 'storage/app/public/test_simple.pdf';

echo "Attempting to convert HTML to PDF...\n";

// Method 1: wkhtmltopdf
$command = "wkhtmltopdf \"$htmlPath\" \"$pdfPath\"";
echo "Trying: $command\n";
exec($command, $output, $returnCode);

if ($returnCode === 0 && file_exists($pdfPath)) {
    echo "SUCCESS: PDF created with wkhtmltopdf\n";
} else {
    echo "wkhtmltopdf failed or not available\n";
    
    // Method 2: Chrome headless (if available)
    $chromeCmd = "chrome --headless --disable-gpu --print-to-pdf=\"$pdfPath\" \"$htmlPath\"";
    echo "Trying Chrome: $chromeCmd\n";
    exec($chromeCmd, $output2, $returnCode2);
    
    if ($returnCode2 === 0 && file_exists($pdfPath)) {
        echo "SUCCESS: PDF created with Chrome\n";
    } else {
        echo "Chrome method also failed\n";
        echo "Please manually create a PDF file at: $pdfPath\n";
        echo "Or place any PDF file there for testing\n";
    }
}

// ทดสอบการอ่าน PDF ที่มีอยู่
$testPaths = [
    'storage/app/public/test_simple.pdf',
    'storage/app/public/test.pdf'
];

foreach ($testPaths as $testPath) {
    if (file_exists($testPath)) {
        echo "\n=== Testing PDF: $testPath ===\n";
        echo "File size: " . filesize($testPath) . " bytes\n";
        
        try {
            $imagick = new Imagick();
            
            // ตั้งค่า policy ให้อ่าน PDF ได้
            $imagick->setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 256);
            $imagick->setResourceLimit(Imagick::RESOURCETYPE_DISK, 1024);
            
            echo "Setting resolution to 150 DPI...\n";
            $imagick->setResolution(150, 150);
            
            echo "Reading PDF page 0...\n";
            $imagick->readImage($testPath . '[0]');
            
            echo "PDF read successfully!\n";
            echo "Original dimensions: " . $imagick->getImageWidth() . "x" . $imagick->getImageHeight() . "\n";
            
            // แปลงเป็น JPEG
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompressionQuality(90);
            
            // ปรับขนาด
            $imagick->thumbnailImage(300, 300, true);
            echo "Resized to: " . $imagick->getImageWidth() . "x" . $imagick->getImageHeight() . "\n";
            
            // บันทึก
            $thumbPath = 'storage/app/public/test_thumb_real.jpg';
            $result = $imagick->writeImage($thumbPath);
            
            if (file_exists($thumbPath)) {
                echo "SUCCESS: Real PDF thumbnail created at: $thumbPath\n";
                echo "Thumbnail size: " . filesize($thumbPath) . " bytes\n";
            } else {
                echo "FAILED: Could not save thumbnail\n";
            }
            
            $imagick->clear();
            $imagick->destroy();
            
            break; // หยุดเมื่อสำเร็จ
            
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
            
            // ตรวจสอบ error ที่เกี่ยวกับ security policy
            if (strpos($e->getMessage(), 'not authorized') !== false || 
                strpos($e->getMessage(), 'policy') !== false) {
                echo "This appears to be a security policy issue.\n";
                echo "Check ImageMagick policy.xml file.\n";
            }
        }
    }
}

echo "\nTest completed.\n";
