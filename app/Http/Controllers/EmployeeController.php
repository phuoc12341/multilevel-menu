<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportFileCsv;
use App\Http\Requests\ImportEmployeeRequest;
use App\Http\Requests\ExportEmployeeRequest;
use App\Http\Controllers\Controller;
use App\Services\EmployeeService;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function importExportView()
    {
        $types = array_keys(config('common.export.types'));
        $separations = config('common.export.types.csv.separation');
        $encodings = config('common.export.encoding');
        $exportColumns = config('common.export.export_column');

        $compacts = [
            'types' => $types,
            'separations' => $separations,
            'encodings' => $encodings,
            'types' => $types,
            'exportColumns' => $exportColumns,
        ];

        return view('imports.index', $compacts);
    }

    public function import(ImportEmployeeRequest $request)
    {
        $file = $request->file;
        if ($file->isValid()) {
            $relativePathFromStorage = $file->store(config('common.import.path'));
            $path = storage_path('app/' . $relativePathFromStorage);
            ImportFileCsv::dispatch($path);
        }

        return back();
    }

    public function export(ExportEmployeeRequest $request)
    {
        $fileType = $request->file_type;
        $fileName = $this->employeeService->makeFilename($fileType);

        $data = $this->employeeService->getData($fileType, $request);

        $types = config('common.export.types.' . $fileType . '.mime');

        if ($request->expectsJson()) {
            return new EmployeeResource([
                'fileName' => $fileName,
                'fileMime' => $types,
                'fileDataBase64' => base64_encode($data['encoded']),
                'fileData' => $data['raw'],
            ]);
        }

        return response()->streamDownload(function () use ($data) {
            echo $data['encoded'];
        }, $fileName);
    }
}
