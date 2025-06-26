<?php
/**
 * ทดสอบการสร้าง thumbnail จากหน้าแรกของ PDF จริง
 */

require_once 'vendor/autoload.php';

function createRealPdfThumbnail($pdfPath, $outputPath)
{
    try {
        echo "Starting PDF thumbnail creation...\n";
        
        // ตรวจสอบว่ามี Imagick extension
        if (!extension_loaded('imagick')) {
            echo "❌ Imagick extension not loaded\n";
            return false;
        }
        echo "✅ Imagick extension is available\n";

        // ตรวจสอบว่าไฟล์ PDF มีอยู่จริง
        if (!file_exists($pdfPath)) {
            echo "❌ PDF file not found: {$pdfPath}\n";
            return false;
        }
        echo "✅ PDF file exists: {$pdfPath}\n";

        // สร้าง Imagick object
        $imagick = new Imagick();
        echo "✅ Imagick object created\n";
        
        // ตั้งค่าความละเอียดก่อนอ่านไฟล์
        $imagick->setResolution(150, 150);
        echo "✅ Resolution set to 150x150\n";
        
        // อ่านหน้าแรกของ PDF เท่านั้น
        $imagick->readImage($pdfPath . '[0]'); // [0] หมายถึงหน้าแรก
        echo "✅ PDF first page loaded\n";
        
        // ตั้งค่าให้เป็นรูปแบบ JPEG
        $imagick->setImageFormat('jpeg');
        echo "✅ Image format set to JPEG\n";
        
        // ปรับขนาดให้เหมาะสม (300x400 พอ)
        $imagick->resizeImage(300, 400, Imagick::FILTER_LANCZOS, 1, true);
        echo "✅ Image resized to 300x400\n";
        
        // ปรับคุณภาพ
        $imagick->setImageCompressionQuality(90);
        echo "✅ Compression quality set to 90\n";
        
        // เพิ่มพื้นหลังสีขาวสำหรับ PDF ที่มีพื้นหลังโปร่งใส
        $imagick->setImageBackgroundColor(new ImagickPixel('white'));
        $imagick = $imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
        echo "✅ Background set to white and layers flattened\n";
        
        // บันทึกไฟล์
        $result = $imagick->writeImage($outputPath);
        echo "✅ Attempting to write image to: {$outputPath}\n";
        
        // ล้างหน่วยความจำ
        $imagick->clear();
        $imagick->destroy();
        
        if ($result && file_exists($outputPath)) {
            $filesize = filesize($outputPath);
            echo "✅ SUCCESS: PDF thumbnail created successfully!\n";
            echo "   Output: {$outputPath}\n";
            echo "   Size: {$filesize} bytes\n";
            return true;
        } else {
            echo "❌ Failed to save PDF thumbnail: {$outputPath}\n";
            return false;
        }
        
    } catch (ImagickException $e) {
        echo "❌ ImagickException: " . $e->getMessage() . "\n";
        return false;
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "\n";
        return false;
    }
}

// Main execution
echo "=== PDF Thumbnail Generation Test ===\n\n";

// สร้างโฟลเดอร์สำหรับทดสอบ
$testDir = __DIR__ . '/test_thumbnails';
if (!is_dir($testDir)) {
    mkdir($testDir, 0777, true);
    echo "✅ Test directory created: {$testDir}\n";
}

// ค้นหาไฟล์ PDF ที่มีอยู่ในระบบ
$foundPdf = null;
$searchPaths = [
    __DIR__ . '/storage/app/public/labours',
    __DIR__ . '/public',
    __DIR__,
];

foreach ($searchPaths as $searchPath) {
    if (is_dir($searchPath)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($searchPath));
        foreach ($iterator as $file) {
            if ($file->isFile() && strtolower($file->getExtension()) === 'pdf') {
                $foundPdf = $file->getPathname();
                break 2;
            }
        }
    }
}

if ($foundPdf) {
    echo "✅ Found existing PDF: {$foundPdf}\n";
    $testPdfPath = $foundPdf;
} else {
    echo "❌ No PDF file found for testing\n";
    echo "Please place a PDF file in the test directory and try again.\n";
    
    // สร้าง PDF อย่างง่ายด้วย content ธรรมดา
    $testPdfPath = $testDir . '/simple_test.pdf';
    $pdfContent = '%PDF-1.4
1 0 obj
<< /Type /Catalog /Pages 2 0 R >>
endobj
2 0 obj
<< /Type /Pages /Kids [3 0 R] /Count 1 >>
endobj
3 0 obj
<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] >>
endobj
xref
0 4
0000000000 65535 f 
0000000015 00000 n 
0000000060 00000 n 
0000000120 00000 n 
trailer
<< /Size 4 /Root 1 0 R >>
startxref
190
%%EOF';
    
    file_put_contents($testPdfPath, $pdfContent);
    echo "✅ Created simple test PDF: {$testPdfPath}\n";
}

// ทดสอบการสร้าง thumbnail
echo "\n--- Testing PDF Thumbnail Creation ---\n";
$thumbnailPath = $testDir . '/thumbnail.jpg';

$success = createRealPdfThumbnail($testPdfPath, $thumbnailPath);

if ($success) {
    echo "\n🎉 SUCCESS! PDF thumbnail has been created.\n";
    echo "📁 Thumbnail location: {$thumbnailPath}\n";
    
    // แสดงข้อมูลไฟล์
    if (file_exists($thumbnailPath)) {
        $imageInfo = getimagesize($thumbnailPath);
        echo "📏 Thumbnail dimensions: {$imageInfo[0]}x{$imageInfo[1]}\n";
        echo "📊 File size: " . filesize($thumbnailPath) . " bytes\n";
        echo "🖼️  MIME type: {$imageInfo['mime']}\n";
    }
} else {
    echo "\n❌ FAILED to create PDF thumbnail.\n";
    echo "Please check the error messages above.\n";
    
    // ตรวจสอบการติดตั้ง
    echo "\n--- System Check ---\n";
    echo "PHP version: " . PHP_VERSION . "\n";
    echo "Imagick extension: " . (extension_loaded('imagick') ? '✅ Loaded' : '❌ Not loaded') . "\n";
    
    if (extension_loaded('imagick')) {
        $imagick = new Imagick();
        $formats = $imagick->queryFormats();
        echo "Supported formats: " . (in_array('PDF', $formats) ? '✅ PDF supported' : '❌ PDF not supported') . "\n";
        
        // ตรวจสอบ Ghostscript
        $version = Imagick::getVersion();
        echo "Imagick version: " . $version['versionString'] . "\n";
    }
}

echo "\n=== Test Complete ===\n";
