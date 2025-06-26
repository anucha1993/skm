<?php
// สร้างไอคอน PDF สวยๆ
$width = 300;
$height = 300;

// สร้าง image resource
$image = imagecreate($width, $height);

// กำหนดสี
$white = imagecolorallocate($image, 255, 255, 255);
$lightGray = imagecolorallocate($image, 248, 250, 252);
$red = imagecolorallocate($image, 220, 38, 38);
$darkGray = imagecolorallocate($image, 75, 85, 99);
$border = imagecolorallocate($image, 209, 213, 219);

// เติมสีพื้นหลัง
imagefill($image, 0, 0, $lightGray);

// วาดรูปสี่เหลี่ยมแทน PDF (เอกสาร)
$docX = 75;
$docY = 50;
$docW = 150;
$docH = 200;

// เงาของเอกสาร
imagefilledrectangle($image, $docX + 5, $docY + 5, $docX + $docW + 5, $docY + $docH + 5, $border);

// ตัวเอกสาร
imagefilledrectangle($image, $docX, $docY, $docX + $docW, $docY + $docH, $white);
imagerectangle($image, $docX, $docY, $docX + $docW, $docY + $docH, $border);

// วาดมุมพับ (corner fold)
$foldSize = 20;
imagefilledpolygon($image, [
    $docX + $docW - $foldSize, $docY,
    $docX + $docW, $docY,
    $docX + $docW, $docY + $foldSize,
    $docX + $docW - $foldSize, $docY + $foldSize
], 4, $lightGray);

// เส้นใน PDF
for ($i = 0; $i < 8; $i++) {
    $lineY = $docY + 40 + ($i * 15);
    imageline($image, $docX + 15, $lineY, $docX + $docW - 15, $lineY, $border);
}

// เขียนข้อความ "PDF"
$font_size = 5;
$text = 'PDF';
$text_width = strlen($text) * imagefontwidth($font_size);
$text_x = ($width - $text_width) / 2;
$text_y = $docY + $docH + 20;

imagestring($image, $font_size, $text_x, $text_y, $text, $red);

// สร้างโฟลเดอร์หากไม่มี
if (!file_exists('public/images')) {
    mkdir('public/images', 0777, true);
}

// บันทึกเป็น JPEG
imagejpeg($image, 'public/images/pdf-icon.jpg', 90);

// ล้างหน่วยความจำ
imagedestroy($image);

echo "PDF icon created at: public/images/pdf-icon.jpg\n";
