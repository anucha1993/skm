<?php
// Test PDF thumbnail generation
if (!extension_loaded('imagick')) {
    echo "Imagick extension is not loaded!\n";
    exit(1);
}

echo "Imagick extension is loaded.\n";

// Check if we can create an Imagick instance
try {
    $imagick = new Imagick();
    echo "Imagick instance created successfully.\n";
    
    // Check supported formats
    $formats = $imagick->queryFormats();
    echo "Supported formats: " . implode(', ', array_slice($formats, 0, 10)) . "...\n";
    
    // Check if PDF is supported
    if (in_array('PDF', $formats)) {
        echo "PDF format is supported.\n";
    } else {
        echo "PDF format is NOT supported.\n";
    }
    
    // Check if JPEG is supported
    if (in_array('JPEG', $formats)) {
        echo "JPEG format is supported.\n";
    } else {
        echo "JPEG format is NOT supported.\n";
    }
    
    $imagick->clear();
    $imagick->destroy();
    
} catch (Exception $e) {
    echo "Error creating Imagick instance: " . $e->getMessage() . "\n";
}

// Test with a dummy PDF file if exists
$testPdfPath = 'storage/app/public/test.pdf';
if (file_exists($testPdfPath)) {
    echo "\nTesting with actual PDF file: $testPdfPath\n";
    
    try {
        $imagick = new Imagick();
        $imagick->setResolution(150, 150);
        $imagick->readImage($testPdfPath . '[0]');
        $imagick->setImageFormat('jpeg');
        $imagick->setImageCompressionQuality(90);
        
        $outputPath = 'storage/app/public/test_thumb.jpg';
        $imagick->writeImage($outputPath);
        
        if (file_exists($outputPath)) {
            echo "Thumbnail created successfully at: $outputPath\n";
        } else {
            echo "Thumbnail file was not created.\n";
        }
        
        $imagick->clear();
        $imagick->destroy();
        
    } catch (Exception $e) {
        echo "Error processing PDF: " . $e->getMessage() . "\n";
    }
} else {
    echo "\nNo test PDF file found at: $testPdfPath\n";
}
