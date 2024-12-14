<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PostDownloadController extends ApiController
{
    public function __invoke(Post $post): BinaryFileResponse|JsonResponse
    {
        $localFilePath = urldecode($post->upload);

        // Check if the file exists
        if ( ! file_exists($localFilePath)) {
            return $this->sendErrorResponse('Resource not found.', null, 404);
        }

        $post->update(['downloads' => $post->downloads + 1]);

        $basename = basename($localFilePath);

        // Return the file for download
        return response()->download($localFilePath, $basename);
    }
}
