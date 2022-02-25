<?php

namespace App\Domain\Service;

use PhpOffice\PhpSpreadsheet\Reader\Csv as Csv;
use App\Domain\Base\CommonRepository;

class UploadFileService
{
    private $commonRepository;

    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }

    public function loadFile($file) : string{
        $response = '';
        $uploadedFile = $file['file'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

            $filename = $uploadedFile->getClientFilename();

            $directory = '/game/uruk/app/uploads' . DIRECTORY_SEPARATOR . $filename;
            $uploadedFile->moveTo($directory);

            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $tableName = pathinfo($filename, PATHINFO_FILENAME);

            if ($extension == 'csv') {
                $response = $response . $tableName . '<br/>';
                $reader = new Csv();

                $spreadsheet = $reader->load($directory);
                $spreadData = $spreadsheet->getActiveSheet()->toArray();

                $rows = count($spreadData);
                $cols = (count($spreadData, 1) / count($spreadData)) - 1;

                for ($i = 0; $i < $rows; $i++) {
                    for ($j = 0; $j < $cols; $j++) {
                        $response = $response . $spreadData[$i][$j] . ' ';
                    }
                    $response = $response . '<br/>';
                }

                // connecting db
                $this->commonRepository->loadData($directory, $tableName);

            } else {
                $response = $response.'처리할 수 있는 포맷의 파일이 아닙니다.';
            }
        }
        return $response;
    }
}