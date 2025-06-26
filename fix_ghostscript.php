<?php
// แก้ปัญหา Ghostscript path สำหรับ Imagick
echo "Testing Ghostscript path fix...\n";

// ลองค้นหา Ghostscript executable
$possiblePaths = [
    'C:\Program Files\gs\gs10.05.1\bin\gswin64c.exe',
    'C:\Program Files (x86)\gs\gs10.05.1\bin\gswin64c.exe',
    'C:\gs\gs10.05.1\bin\gswin64c.exe',
    // อาจจะต้องแก้เวอร์ชันตามที่ติดตั้ง
];

$ghostscriptPath = null;
foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $ghostscriptPath = $path;
        echo "Found Ghostscript at: $path\n";
        break;
    }
}

if (!$ghostscriptPath) {
    echo "Ghostscript executable not found in common locations.\n";
    echo "Please check your Ghostscript installation.\n";
    
    // ลองใช้ system command
    $output = [];
    $return_var = 0;
    exec('gswin64c -v 2>&1', $output, $return_var);
    
    if ($return_var === 0) {
        echo "Ghostscript is available via system PATH\n";
        echo "Output: " . implode("\n", $output) . "\n";
        
        // ลองตั้งค่า environment variable
        putenv('MAGICK_GHOSTSCRIPT_PATH=gswin64c');
        echo "Set MAGICK_GHOSTSCRIPT_PATH environment variable\n";
    }
} else {
    // ตั้งค่า path ให้ Imagick
    putenv("MAGICK_GHOSTSCRIPT_PATH=$ghostscriptPath");
    echo "Set MAGICK_GHOSTSCRIPT_PATH to: $ghostscriptPath\n";
}

// ทดสอบ PDF อีกครั้ง
if (extension_loaded('imagick') && file_exists('storage/app/public/test.pdf')) {
    echo "\nTesting PDF thumbnail creation...\n";
    
    try {
        $imagick = new Imagick();
        $imagick->setResolution(150, 150);
        $imagick->readImage('storage/app/public/test.pdf[0]');
        $imagick->setImageFormat('jpeg');
        $imagick->setImageCompressionQuality(90);
        
        $imagick->writeImage('storage/app/public/test_thumb_fixed.jpg');
        
        if (file_exists('storage/app/public/test_thumb_fixed.jpg')) {
            echo "SUCCESS: PDF thumbnail created!\n";
        } else {
            echo "FAILED: Thumbnail not created\n";
        }
        
        $imagick->clear();
        $imagick->destroy();
        
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\nDone.\n";
