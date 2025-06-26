<?php
// ทดสอบการสร้าง PDF thumbnail ด้วย PDF Parser
require_once 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

echo "Testing PDF thumbnail creation without Ghostscript...\n";

function createPdfThumbnailFromText($pdfPath, $outputPath) {
    try {
        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        
        // ดึงข้อความจากหน้าแรก
        $pages = $pdf->getPages();
        if (empty($pages)) {
            throw new Exception("No pages found in PDF");
        }
        
        $firstPage = $pages[0];
        $text = $firstPage->getText();
        
        echo "Extracted text from PDF (first 200 chars):\n";
        echo substr($text, 0, 200) . "...\n\n";
        
        // สร้างภาพ thumbnail จากข้อความ
        $width = 300;
        $height = 400; // สูงกว่าเพื่อใส่ข้อความได้เยอะ
        
        $image = imagecreate($width, $height);
        
        // กำหนดสี
        $white = imagecolorallocate($image, 255, 255, 255);
        $lightGray = imagecolorallocate($image, 248, 248, 248);
        $darkGray = imagecolorallocate($image, 64, 64, 64);
        $border = imagecolorallocate($image, 200, 200, 200);
        $red = imagecolorallocate($image, 220, 38, 38);
        
        // เติมพื้นหลัง
        imagefill($image, 0, 0, $white);
        
        // วาดกรอบ
        imagerectangle($image, 5, 5, $width-6, $height-6, $border);
        imagerectangle($image, 6, 6, $width-7, $height-7, $border);
        
        // แบ่งข้อความเป็นบรรทัด
        $lines = [];
        $words = explode(' ', $text);
        $currentLine = '';
        $maxCharsPerLine = 35; // จำนวนตัวอักษรต่อบรรทัด
        
        foreach ($words as $word) {
            if (strlen($currentLine . ' ' . $word) <= $maxCharsPerLine) {
                $currentLine .= ($currentLine ? ' ' : '') . $word;
            } else {
                if ($currentLine) {
                    $lines[] = $currentLine;
                    $currentLine = $word;
                } else {
                    $lines[] = substr($word, 0, $maxCharsPerLine);
                    $currentLine = '';
                }
            }
            
            // จำกัดจำนวนบรรทัด
            if (count($lines) >= 25) break;
        }
        
        if ($currentLine) {
            $lines[] = $currentLine;
        }
        
        // เขียนข้อความลงในภาพ
        $y = 15;
        $lineHeight = 12;
        $font = 2; // ใช้ฟอนต์ built-in ขนาด 2
        
        foreach ($lines as $i => $line) {
            if ($y > $height - 50) break; // เว้นที่ด้านล่างสำหรับ "PDF"
            
            // ตัดข้อความที่ยาวเกินไป
            if (strlen($line) > $maxCharsPerLine) {
                $line = substr($line, 0, $maxCharsPerLine - 3) . '...';
            }
            
            imagestring($image, $font, 10, $y, $line, $darkGray);
            $y += $lineHeight;
        }
        
        // เขียน "PDF" ที่ด้านล่าง
        $pdfText = 'PDF Document';
        $textWidth = strlen($pdfText) * imagefontwidth(3);
        $textX = ($width - $textWidth) / 2;
        imagestring($image, 3, $textX, $height - 25, $pdfText, $red);
        
        // บันทึกเป็น JPEG
        $result = imagejpeg($image, $outputPath, 90);
        imagedestroy($image);
        
        if ($result && file_exists($outputPath)) {
            echo "SUCCESS: PDF thumbnail with text content created at: $outputPath\n";
            echo "File size: " . filesize($outputPath) . " bytes\n";
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

// สร้าง PDF ทดสอบ
echo "Creating test PDF...\n";
$testPdfContent = '%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj

2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj

3 0 obj
<<
/Type /Page
/Parent 2 0 R
/MediaBox [0 0 612 792]
/Contents 4 0 R
/Resources <<
/Font <<
/F1 5 0 R
>>
>>
>>
endobj

4 0 obj
<<
/Length 200
>>
stream
BT
/F1 12 Tf
50 750 Td
(Test PDF Document) Tj
0 -20 Td
(This is a sample PDF for testing thumbnail generation.) Tj
0 -20 Td
(Date: ' . date('Y-m-d H:i:s') . ') Tj
0 -20 Td
(Line 1: Sample content for testing) Tj
0 -20 Td
(Line 2: More sample content) Tj
0 -20 Td
(Line 3: Additional text content) Tj
ET
endstream
endobj

5 0 obj
<<
/Type /Font
/Subtype /Type1
/BaseFont /Helvetica
>>
endobj

xref
0 6
0000000000 65535 f 
0000000015 00000 n 
0000000068 00000 n 
0000000125 00000 n 
0000000270 00000 n 
0000000524 00000 n 
trailer
<<
/Size 6
/Root 1 0 R
>>
startxref
593
%%EOF';

// สร้างโฟลเดอร์
if (!file_exists('storage/app/public')) {
    mkdir('storage/app/public', 0777, true);
}

// บันทึก PDF ทดสอบ
file_put_contents('storage/app/public/test_simple.pdf', $testPdfContent);
echo "Test PDF created at: storage/app/public/test_simple.pdf\n";

// ทดสอบการสร้าง thumbnail
$pdfPath = 'storage/app/public/test_simple.pdf';
$thumbPath = 'storage/app/public/test_text_thumb.jpg';

if (file_exists($pdfPath)) {
    createPdfThumbnailFromText($pdfPath, $thumbPath);
} else {
    echo "Test PDF not found\n";
}

echo "\nDone!\n";
