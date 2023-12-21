<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportStatus;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportService
{
    public function getAllReportUser(int $userId, $limit = 5)
    {
        $query = Report::with('user')->where('user_id', '=', $userId);
        $data = $query->limit($limit)->get();

        return $data;
    }

    public function getAllReport($limit = 5)
    {
        $query = Report::with('user');
        $data = $query->limit($limit)->get();

        return $data;
    }

    public function getReportById(string $reportId)
    {
        $data = Report::with('user')
            ->where('id', '=', $reportId)
            ->first();

        return $data;
    }

    public function addReport(Request $request, int $userId)
    {
        $newReport = new Report();
        $newReport->id = $newReport->newUniqueId();
        $newReport->user_id = $userId;
        $newReport->type = $request->type;

        $inputCoordinate = $request->coordinate;
        $checkInImage = $request->file("checkInImage");
        // TODO: handle multiple mage
        $fileExt = $checkInImage->extension();

        $checkInImage->storeAs('public', "images/{$newReport->id}.{$fileExt}");

        $newReport->coordinate_url = $inputCoordinate;
        $newReport->document = "images/{$newReport->id}.{$fileExt}";

        $newReport->status = ReportStatus::CHECK_IN->value;

        $newReport->save();
        return $newReport;
    }

    public function updateReport($updateReportDTO)
    {
        $checkOutTime = Carbon::now()->toDateTimeString();
        $data = Report::where('id', '=', $updateReportDTO["reportId"])
            ->first();
        Log::info($data->status);
        if ($data->status === ReportStatus::CHECK_OUT->value) {
            Log::error("report " . $data->id . " is already checked out");
            throw new Exception("report already updated", 1);
        }
        $data->check_out_at = $checkOutTime;
        $data->status = ReportStatus::CHECK_OUT->value;
        $data->saveOrFail();
        Log::info("report " . $data->id . " is updated");
        return $data;
    }
}
