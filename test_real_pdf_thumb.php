<?php
// ทดสอบการสร้าง thumbnail จาก PDF จริง
if (!extension_loaded('imagick')) {
    echo "Imagick extension is not loaded!\n";
    exit(1);
}

echo "Testing PDF thumbnail creation with real PDF content...\n";

// สร้าง PDF ทดสอบง่ายๆ ด้วย FPDF ถ้ามี
if (class_exists('FPDF') || file_exists('vendor/autoload.php')) {
    echo "Creating test PDF...\n";
    
    // ลองใช้ TCPDF หรือ FPDF
    try {
        require_once 'vendor/autoload.php';
        
        $pdf = new \TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Test PDF Document', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'This is a test PDF for thumbnail generation.', 0, 1);
        $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d H:i:s'), 0, 1);
        
        $pdfPath = 'storage/app/public/test_real.pdf';
        $pdf->Output($pdfPath, 'F');
        
        echo "Test PDF created at: $pdfPath\n";
        
    } catch (Exception $e) {
        echo "Could not create PDF with library: " . $e->getMessage() . "\n";
        
        // สร้าง PDF ง่ายๆ ด้วยเนื้อหา HTML แล้วแปลง
        $htmlContent = '
        <!DOCTYPE html>
        <html>
        <head><title>Test PDF</title></head>
        <body style="font-family: Arial, sans-serif; padding: 20px;">
            <h1 style="color: #333; text-align: center;">Test PDF Document</h1>
            <p>This is a test PDF for thumbnail generation.</p>
            <p><strong>Date:</strong> ' . date('Y-m-d H:i:s') . '</p>
            <div style="border: 1px solid #ccc; padding: 10px; margin: 20px 0;">
                <h3>Sample Content</h3>
                <ul>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                </ul>
            </div>
        </body>
        </html>';
        
        file_put_contents('storage/app/public/test_content.html', $htmlContent);
        echo "HTML content created. Please convert manually to PDF or use wkhtmltopdf\n";
    }
}

// ทดสอบกับไฟล์ PDF ที่มีอยู่
$testFiles = [
    'storage/app/public/test_real.pdf',
    'storage/app/public/test.pdf'
];

foreach ($testFiles as $testPdfPath) {
    if (file_exists($testPdfPath)) {
        echo "\nTesting with PDF file: $testPdfPath\n";
        echo "File size: " . filesize($testPdfPath) . " bytes\n";
        
        try {
            $imagick = new Imagick();
            
            // ตั้งค่า resolution
            $imagick->setResolution(150, 150);
            
            echo "Reading PDF first page...\n";
            $imagick->readImage($testPdfPath . '[0]');
            
            echo "PDF read successfully\n";
            echo "Image dimensions: " . $imagick->getImageWidth() . "x" . $imagick->getImageHeight() . "\n";
            
            // แปลงเป็น JPEG
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompressionQuality(90);
            $imagick->stripImage();
            
            // ปรับขนาด
            $imagick->thumbnailImage(300, 300, true);
            
            // เพิ่มพื้นหลังสีขาว
            $background = new Imagick();
            $background->newImage(300, 300, 'white');
            $background->compositeImage($imagick, Imagick::COMPOSITE_OVER, 0, 0);
            
            $outputPath = 'storage/app/public/test_real_thumb.jpg';
            $result = $background->writeImage($outputPath);
            
            if (file_exists($outputPath)) {
                echo "SUCCESS: Thumbnail created at: $outputPath\n";
                echo "Thumbnail size: " . filesize($outputPath) . " bytes\n";
            } else {
                echo "FAILED: Thumbnail file was not created\n";
            }
            
            $imagick->clear();
            $imagick->destroy();
            $background->clear();
            $background->destroy();
            
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
            echo "Error code: " . $e->getCode() . "\n";
        }
        
        break; // ทดสอบแค่ไฟล์แรกที่เจอ
    }
}

echo "\nDone testing.\n";
