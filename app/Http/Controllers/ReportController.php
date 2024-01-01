<?php

namespace App\Http\Controllers;

use App\Models\ReportStatus;
use App\Services\ReportService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ReportController extends Controller
{
    private ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function dashboard(Authenticatable $user)
    {
        $data = $this->reportService->checkLastReport($user->id);
        return view('dashboard', [
            'last_report' => $data,
        ]);
    }

    public function addReportPage(Authenticatable $user)
    {
        $lastReport = $this->reportService->checkLastReport($user->id);
        if ($lastReport->status == ReportStatus::CHECK_IN->value) {
            return redirect(route('report.list'))->withErrors('terdapat laporan yang masih dalam proses check in');
        }
        return view('add-report');
    }

    public function addReport(Request $request, Authenticatable $user)
    {
        $newReport =
            $this->reportService
            ->addReport($request, $user->id);

        return redirect(route('report.list'));
    }

    public function listReport(Request $request)
    {
        $user = $request->user();
        $reportData = [];
        // TODO: refactor authorization handling
        if ($user->isAdmin()) {
            $reportData = $this->reportService->getAllReport($request);
        } else {
            $reportData = $this->reportService->getAllReportUser($user->id, 5);
        }
        return view('list-report', [
            "list_report" => $reportData,
        ]);
    }

    public function detailReport(
        Request $request,
        string $reportId,
    ) {
        $user = $request->user();
        $dataReport = $this
            ->reportService
            ->getReportById($reportId);

        // TODO: refactor authorization handling
        if (
            $user->id != $dataReport->user_id
            && !$user->isAdmin()
        ) {
            return redirect(route('list-report'));
        }

        return view('detail-report', [
            'report' => $dataReport,
        ]);
    }

    public function updateReport(
        Request $request,
        string $reportId,
    ) {
        $validatedRequest = $this->validateRequest($request);

        try {
            DB::transaction(function () use ($validatedRequest, $reportId) {
                $updatedReport = $this->reportService
                    ->updateReport(array_merge(
                        $validatedRequest->all(),
                        [
                            "reportId" => $reportId,
                            "user" => $validatedRequest->user(),
                        ]
                    ));

                switch ($updatedReport->type) {
                    case 'ORDER':
                        Log::info("ORDER report");
                        $this->reportService
                            ->addReportOrderDetail($updatedReport->id, $validatedRequest->notes, $validatedRequest->price);
                        break;

                    case 'NOO':
                        Log::info("NOO report");
                        $this->reportService
                            ->addReportNOODetail($updatedReport->id);
                        break;

                    case 'VISIT':
                        Log::info("visit report");
                        break;

                    default:
                        Log::error("invalid req type");
                        break;
                }
            });
        } catch (\Throwable $th) {
            Log::error("failure to update report data", ["error" => $th]);
            return redirect(route('report.detail', $reportId))
                ->with("error", "gagal melakukan update report");
        }

        return redirect(route('report.detail', $reportId))->with("success", "report berhasil di-update");
    }

    public function downloadReport(Request $request)
    {
        $user = $request->user();
        $reportData = [];
        // TODO: refactor authorization handling
        if ($user->isAdmin()) {
            $reportData = $this->reportService->getAllReport($request);
        } else {
            $reportData = $this->reportService->getAllReportUser($user->id, 5);
        }

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $reportsLength = count($reportData);

        for ($i = 0; $i < $reportsLength; $i++) {
            $activeWorksheet->setCellValue([1, $i + 1], $reportData[$i]->id);
            $activeWorksheet->setCellValue([2, $i + 1], $reportData[$i]->updated_at);
            $activeWorksheet->setCellValue([3, $i + 1], $reportData[$i]->user->name);
            $activeWorksheet->setCellValue([4, $i + 1], $reportData[$i]->client_name);
            $activeWorksheet->setCellValue([5, $i + 1], $reportData[$i]->client_domicile);
            $activeWorksheet->setCellValue([6, $i + 1], $reportData[$i]->type);
            $activeWorksheet->setCellValue([7, $i + 1], $reportData[$i]->reportOrder?->price);
        }

        $writer = new Xls($spreadsheet);
        $writer->save('storage/report.xls');

        // ddd(file_exists('report.csv'));

        return Storage::download('public/report.xls');
        return redirect(route('report.list'))->with("exported_file");
    }

    function validateRequest(Request $request)
    {
        return $request;
    }
}
