<?php
// สร้าง PDF ง่ายๆ สำหรับทดสอบ
require_once 'vendor/autoload.php';

// ใช้ TCPDF หรือ DomPDF หากมี หรือสร้างแบบง่าย
$content = '
<!DOCTYPE html>
<html>
<head>
    <title>Test PDF</title>
</head>
<body>
    <h1>This is a test PDF document</h1>
    <p>This document is created for testing PDF thumbnail generation.</p>
    <p>Date: ' . date('Y-m-d H:i:s') . '</p>
</body>
</html>
';

// สร้างไฟล์ HTML ก่อน
file_put_contents('storage/app/public/test.html', $content);

echo "Test HTML file created at: storage/app/public/test.html\n";
echo "You can convert this to PDF using an online converter or tool, then place it at storage/app/public/test.pdf\n";

// หรือถ้ามี wkhtmltopdf
$command = 'wkhtmltopdf storage/app/public/test.html storage/app/public/test.pdf';
echo "Try running: $command\n";
