<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Actions\File\ViewUploadAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv as Csv;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world1');
        return $response;
    });

    $app->get('/db-test', function(Request $request, Response $response) {
        $db = $this->get(PDO::class);
        $tide = 'tide';
        $sth = $db->prepare("desc ".$tide);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/upload', function (Request $request, Response $response) {

        $files = $request->getUploadedFiles();
        $uploadedFile = $files['file'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

            $filename = $uploadedFile->getClientFilename();
            $response->getBody()->write('Uploaded: ' . $filename . '<br/>');

            $directory = __DIR__ . '/uploads' . DIRECTORY_SEPARATOR . $filename;
            $uploadedFile->moveTo($directory);

            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $tablename = pathinfo($filename, PATHINFO_FILENAME);
            $response->getBody()->write('Uploaded: ' . $extension . '<br/>');

            if ($extension == 'csv') {
                $response->getBody()->write($tablename.'<br/>');
                $reader = new Csv();

                $spreadsheet = $reader->load($directory);
                $spreadData = $spreadsheet->getActiveSheet()->toArray();

                $rows=count($spreadData);
                $cols=(count($spreadData,1)/count($spreadData))-1;

                for ($i=0;$i<$rows;$i++) {
                    for ($j=0;$j<$cols;$j++) {
                        $response->getBody()->write($spreadData[$i][$j] . ' ');
                    }
                    $response->getBody()->write('<br/>');
                }

                $db = $this->get(PDO::class);
//                $sth = $db->prepare("select * from tide");
                $sth = $db->prepare("load data local infile '$directory' ignore into table $tablename
                    fields terminated by ',' lines terminated by '\n' ignore 1 lines;");
                $sth->execute();
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                $payload = json_encode($data);
                $response->getBody()->write($payload);
                $response->withHeader('Content-Type', 'application/json');
            } else {
                $response->getBody()->write('처리할 수 있는 포맷의 파일이 아닙니다.');
            }
        }

        return $response;
    });

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory The directory to which the file is moved
     * @param UploadedFileInterface $uploadedFile The file uploaded file to move
     *
     * @return string The filename of moved file
     */
    function moveUploadedFile(string $directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        // see http://php.net/manual/en/function.random-bytes.php
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
    $app->get('/file-upload', ViewUploadAction::class);

    $app->post('/bye', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world42');
        return $response;
    });
    $app->get('/hey', function (Request $request, Response $response) {
        $response->getBody()->write('My Hello world5');
        return $response;
    });
    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};

