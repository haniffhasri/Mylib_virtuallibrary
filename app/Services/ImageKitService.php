<?php

namespace App\Services;

use ImageKit\ImageKit;
use Illuminate\Support\Facades\Log;

class ImageKitService
{
    protected $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit (
            "public_1BhL8OyknJgFWHFEcSoIe2S+owM=",            
            "private_bGZtmwBpXvv97TRlfHrt5THOiKU=",            
            "https://ik.imagekit.io/jstobplvc"
        )
;
    }

    public function upload($file, $fileName, $folder = 'library')
    {
        try {
            $response = $this->imageKit->upload([
                'file' => fopen($file->getRealPath(), 'r'),
                'fileName' => $fileName,
                'folder' => $folder,
            ]);

            // Check for errors in the response
            if (isset($response->error)) {
                $errorMessage = is_string($response->error) ? $response->error : $response->error->message;
                Log::error('ImageKit Upload Error:', ['error' => $errorMessage]);
                return null;
            }

            // Successful upload returns the file details
            return $response;
        } catch (\Exception $e) {
            Log::error('ImageKit Upload Exception:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function delete($fileId)
    {
        try {
            $response = $this->imageKit->deleteFile($fileId);
            
            // Check for errors in the response
            if (isset($response->error)) {
                $errorMessage = is_string($response->error) ? $response->error : $response->error->message;
                Log::error('ImageKit Delete Error:', ['error' => $errorMessage]);
                return false;
            }

            // Successful deletion returns true
            return true;
        } catch (\Exception $e) {
            Log::error('ImageKit Delete Exception:', ['error' => $e->getMessage()]);
            return false;
        }
    }
}