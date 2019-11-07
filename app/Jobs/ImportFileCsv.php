<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Batch;
use App\Events\ImportDBComplete;
use App\Models\Employee;
use App\Repo\UnitRepositoryInterface;
use Exception;
// use Illuminate\Support\Facades\Validator;
// use App\Rules\CheckImportFile;
// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Cache;

class ImportFileCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *  
     * @return void
     */
    public function handle()
    {
        $customerArr = $this->validateFileCsv();

        $userInstance = new Employee;
        $batchSize = config('common.import.batch_size');

        Batch::insert($userInstance, config('common.import.column'), $customerArr, $batchSize);
        event(new ImportDBComplete('Import file Csv to Database successfully'));
    }

    public function validateFileCsv()
    {
        $file = fopen($this->filePath, 'r');
        $dataCsv = $this->checkFileCsvAndGetData($file);
        fclose($file);

        return $dataCsv;
    }

    /**
     * Check the file title
     *
     * @param   array $firstLine
     * @return bool
     */
    protected function checkHeaderCsv($firstLine)
    {
        $header = config('common.import.validation.file.header');
        $map = array_map(function ($transHeader) {
            return __($transHeader);
        }, array_values($header));
        
        $firstLine = array_reverse($firstLine);     //always must reverse ???
        $firstLineDecodeToUtf8 = $firstLine;
        if (mb_check_encoding($firstLine,'SJIS')) {
            $firstLineDecodeToUtf8 = mb_convert_encoding($firstLine, 'UTF-8', 'SJIS');
        }

        if ($firstLineDecodeToUtf8 !== $map) {
            $message = __('import.message.error_header');
            
            throw new Exception($message);
        }

        return true;
    }

    /**
     * Check the file content on each line
     *
     * @param   array $nextLine
     * @param   array $totalColumn
     * @param   int $row
     * @return bool
     */
    protected function checkRowAndGetDataCsv($nextLine, $totalColumn, $row)
    {
        if (count($totalColumn) !== count($nextLine)) {
            $message = __('import.message.error_element', ['row' => $row]);

            throw new Exception($message);
        }

        if (mb_check_encoding($nextLine, 'SJIS')) {
            $nextLineAndKey = array_combine(config('common.import.column'), array_reverse($nextLine));
            $nextLineAndKey = mb_convert_encoding($nextLineAndKey, 'UTF-8', 'SJIS');
        } else {
            $nextLineAndKey = array_combine(array_keys(config('common.import.column')), $nextLine);
        }

        $unitRepository = app(UnitRepositoryInterface::class);
        $listUnitAndKey = $unitRepository->fetchAll(['id', 'name'])->pluck('id','name');

        foreach ($nextLineAndKey as $key => $value) {
            $column = (int)$key + 1;
            
            // check max length of data
            if (mb_strlen($value) > config('common.import.validation.name.max')) {
                $message = __('import.message.error_row_name', [
                    'row' => $row,
                    'column' => $column,
                ]);

                throw new Exception($message);
            }

            // check Age
            if ($key == config('common.import.column.age')) {
                if ( ( !(int)$value && (int)$value !== 0 ) || (int)$value > config('common.import.validation.age.max') || (int)$value < config('common.import.validation.age.min') ) {
                    $message = __('import.message.error_age', [
                        'row' => $row,
                        'column' => $column,
                    ]);

                    throw new Exception($message);
                }
            }

            // check Unit exist or not
            if ($key == config('common.import.column.unit_id')) {
                $idOfAgeCell = $listUnitAndKey->get($value);
                if ( !isset($idOfAgeCell)) {
                    $message = __('import.message.error_unit_id', [
                        'row' => $row,
                        'column' => $column,
                    ]);

                    throw new Exception($message);
                }
                $nextLineAndKey[$key] = $idOfAgeCell;
            }
        }

        return $nextLineAndKey;
    }

    /**
     * Check the file before importing
     *
     * @param   array $file
     * @return bool
     */
    protected function checkFileCsvAndGetData($file)
    {
        $firstLine = fgetcsv($file);
        $this->checkHeaderCsv($firstLine);

        $row = 1;
        $result = [];
        $nextLine = fgetcsv($file);
        $totalColumn = config('common.import.column');
        while ($nextLine !== false) {
            $result[] = $this->checkRowAndGetDataCsv($nextLine, $totalColumn, $row);
            $nextLine = fgetcsv($file);
            $row++;
        }

        return $result;
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        event(new ImportDBComplete($exception->getMessage()));
    }

    // function csvToArray($filename = '', $delimiter = ',')
    // {
    //     if (!file_exists($filename) || !is_readable($filename)) {
    //         return false;
    //     }

    //     $index = 0;
    //     $data = [];
    //     $header = config('common.import.column');
    //     if (($handle = fopen($filename, 'r')) !== false)
    //     {
    //         while (($row = fgetcsv($handle, config('common.import.line_max_length'), $delimiter)) !== false)
    //         {
    //             if ($index === 0) { $index++; continue; }

    //             if (mb_check_encoding($row, 'UTF-8') == false) {
    //                 $rowDecodeToUtf8 = mb_convert_encoding($row, "UTF-8", "SJIS");
    //             }
    //             $data[] = array_combine($header, array_reverse($rowDecodeToUtf8));
    //         }
    //         fclose($handle);
    //     }

    //     return $data;
    // }

    // public function validateCsv()
    // {
    //     $uploadedFile = new UploadedFile(
    //         $this->fileParams['path'],
    //         $this->fileParams['originalName'],
    //         $this->fileParams['mimeType'],
    //         $this->fileParams['size']
    //     );

    //     $validator = Validator::make(['file' => $uploadedFile], [
    //         'file' => [
    //             new CheckImportFile($this->fileParams['path']),
    //         ],
    //     ]);

    //     if ($validator->fails()) {
    //         event(new ImportDBComplete($validator->errors()->first('file')));

    //         return false;
    //     }

    //     return true;
    // }
}
