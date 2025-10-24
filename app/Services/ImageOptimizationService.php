<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\ImageOptimizer\OptimizerChain;

class ImageOptimizationService
{
    protected ImageManager $imageManager;
    protected OptimizerChain $optimizer;

    public function __construct(OptimizerChain $optimizer)
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->optimizer = $optimizer;
        
        // Configure optimizers from config
        $this->configureOptimizers();
    }
    
    /**
     * Configure optimizers from config file
     */
    protected function configureOptimizers(): void
    {
        $config = config('image-optimizer.optimizers', []);
        
        foreach ($config as $optimizerClass => $options) {
            if (class_exists($optimizerClass)) {
                $optimizer = new $optimizerClass();
                if (method_exists($optimizer, 'setOptions')) {
                    $optimizer->setOptions($options);
                }
                $this->optimizer->addOptimizer($optimizer);
            }
        }
        
        // Set timeout from config
        $timeout = config('image-optimizer.timeout', 60);
        $this->optimizer->setTimeout($timeout);
    }

    /**
     * Optimize and store an image
     *
     * @param UploadedFile $image
     * @param string $directory
     * @param string $disk
     * @return string The path to the optimized image
     */
    public function optimizeAndStore(UploadedFile $image, string $directory = 'images/items', string $disk = 'r2'): string
    {
        // Generate a unique filename
        $filename = $this->generateUniqueFilename($image);
        $tempPath = sys_get_temp_dir() . '/' . $filename;

        try {
            // Process the image
            $processedImage = $this->processImage($image);
            
            // Save the processed image to temporary location
            $processedImage->save($tempPath);
            
            // Optimize the image
            $this->optimizer->optimize($tempPath);
            
            // Store the optimized image to the specified disk
            $path = Storage::disk($disk)->putFileAs($directory, $tempPath, $filename);
            
            // Clean up temporary file
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            return $path;
        } catch (\Exception $e) {
            // Clean up temporary file if it exists
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            // Fallback to storing the original image if optimization fails
            \Log::error('Image optimization failed: ' . $e->getMessage());
            return $image->store($directory, $disk);
        }
    }

    /**
     * Process the image (resize, compress, etc.)
     *
     * @param UploadedFile $image
     * @return \Intervention\Image\Image
     */
    protected function processImage(UploadedFile $image)
    {
        $image = $this->imageManager->read($image->getPathname());
        
        // Get original dimensions
        $width = $image->width();
        $height = $image->height();
        
        // Define maximum dimensions
        $maxWidth = 1920;
        $maxHeight = 1080;
        
        // Resize if necessary while maintaining aspect ratio
        if ($width > $maxWidth || $height > $maxHeight) {
            $image = $image->scaleDown($maxWidth, $maxHeight);
        }
        
        // Convert to JPEG with 85% quality for better compression
        // Only convert if it's not already a JPEG
        $mimeType = $image->toPng()->toDataUri();
        if (!str_contains($mimeType, 'image/jpeg')) {
            $image = $image->toJpeg(85);
        }
        
        return $image;
    }

    /**
     * Generate a unique filename for the image
     *
     * @param UploadedFile $image
     * @return string
     */
    protected function generateUniqueFilename(UploadedFile $image): string
    {
        $extension = 'jpg'; // We'll convert everything to JPEG for consistency
        return Str::random(40) . '.' . $extension;
    }

    /**
     * Get image size before and after optimization
     *
     * @param string $imagePath
     * @return array
     */
    public function getImageSizeInfo(string $imagePath): array
    {
        $originalSize = 0;
        $optimizedSize = 0;
        
        if (Storage::exists($imagePath)) {
            $optimizedSize = Storage::size($imagePath);
        }
        
        return [
            'original_size' => $originalSize,
            'optimized_size' => $optimizedSize,
            'compression_ratio' => $originalSize > 0 ? round((1 - $optimizedSize / $originalSize) * 100, 2) : 0,
        ];
    }
}