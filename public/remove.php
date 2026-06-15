<?php
// Path to the directory containing the images
$directory = 'product_images/';
$output_directory = 'output/';

// Create output directory if it doesn't exist
if (!is_dir($output_directory)) {
    mkdir($output_directory, 0755, true);
}

// Function to remove background
function removeBackground($imagePath, $outputPath)
{
    try {
        $imagick = new Imagick($imagePath);

        // Set the color you want to remove (example: white background)
        $background = new ImagickPixel('white');

        // Remove the background by making the specified color transparent
        $imagick->transparentPaintImage($background, 0.1, 10000, false);

        // Set the format to PNG to maintain transparency
        $imagick->setImageFormat('png');

        // Save the output with the same original filename
        $imagick->writeImage($outputPath);
        $imagick->clear();
        $imagick->destroy();

        echo "Processed: $imagePath\n";
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage() . "\n";
    }
}

// Process all images in the directory
$images = glob($directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

foreach ($images as $image) {
    // Get original filename and extension
    $filename = pathinfo($image, PATHINFO_FILENAME);
    $extension = pathinfo($image, PATHINFO_EXTENSION);

    // Define output file name with original name and new extension (PNG)
    $output_image = $output_directory . $filename . '.png'; // Change extension to PNG

    removeBackground($image, $output_image);
}

echo "Background removal completed for all images.\n";
