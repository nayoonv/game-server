<?php

namespace App\Application\Actions\Common;

use App\Domain\Service\UploadFileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadFileAction
{
    private $uploadFileService;

    public function __construct(UploadFileService $uploadFileService)
    {
        $this->uploadFileService = $uploadFileService;
    }

    public function __invoke(Request $request, Response $response): Response {
        $file = $request->getUploadedFiles();

        $filename = $this->uploadFileService->loadFile($file);

        return $this->response->getBody()->write($filename . '<br/>');
    }
}