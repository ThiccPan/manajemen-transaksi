<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ReportController extends Controller
{
    private ReportService $reportService;
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function addReportPage(Request $request)
    {
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
            $reportData = $this->reportService->getAllReport(5);
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
        $updateReportDTO = array_merge($validatedRequest->all(), [
            "reportId" => $reportId,
            "user" => $validatedRequest->user(),
        ]);

        try {
            $this->reportService
                ->updateReport($updateReportDTO);
        } catch (\Throwable $th) {
            Log::error("failure to update report data", ["error" => $th]);
            return redirect(route('report.detail', $reportId))
                ->with("error", "gagal melakukan update report");
        }

        return redirect(route('report.detail', $reportId))->with("success", "report berhasil di-update");
    }

    function validateRequest(Request $request)
    {
        return $request;
    }
}
