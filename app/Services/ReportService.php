<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportNOO;
use App\Models\ReportOrder;
use App\Models\ReportStatus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportService
{
    public function getAllReportUser(int $userId, $limit = 5, $filters = [])
    {
        $query = Report::with('user')->where('user_id', '=', $userId);
        if ($filters["startsAt"]) $query = $query->where('updated_at', '>=', $filters["startsAt"]);
        if ($filters["endsAt"]) $query = $query->where('updated_at', '<=', $filters["endsAt"]);
        if ($filters["type"]) $query = $query->where('type', '=', $filters["type"]);
        $data = $query->limit($limit)->orderByDesc('updated_at')->get();

        return $data;
    }

    public function getAllReport($getReportsDTO)
    {
        $query = Report::with('user');
        if ($getReportsDTO->start != null) $query = $query->where('updated_at', '>=', Carbon::parse($getReportsDTO->start)->toDateTimeString());
        if ($getReportsDTO->end != null) $query = $query->where('updated_at', '<=', $getReportsDTO->end);
        if ($getReportsDTO->type != null) $query = $query->where('type', '=', $getReportsDTO->type);
        $data = $query->limit(5)->get();

        return $data;
    }

    public function getReportsWithFilter($userId, $filters = [
        "limit" => 5,
    ])
    {
        $query = Report::with('user')->where('user_id', '=', $userId);
        if ($filters["startsAt"]) $query = $query->where('updated_at', '>=', $filters["startsAt"]);
        if ($filters["endsAt"]) $query = $query->where('updated_at', '<=', $filters["endsAt"]);
        if ($filters["type"]) $query = $query->where('type', '=', $filters["type"]);
        $data = $query->limit($filters["limit"])->get();

        return $data;
    }

    public function checkLastReport($userId)
    {
        $lastReport = Report::with('user')
            ->where('user_id', '=', $userId)
            ->orderByDesc('updated_at')
            ->first();
        return $lastReport;
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
        $newReport->client_name = $request->clientName;
        $newReport->client_domicile = $request->clientDomicile;

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
        $data->type = $updateReportDTO["type"];
        $data->check_out_at = $checkOutTime;
        $data->status = ReportStatus::CHECK_OUT->value;
        $data->saveOrFail();
        Log::info("report " . $data->id . " is updated");
        return $data;
    }

    public function addReportOrderDetail($report_id, $notes, $price)
    {
        $newReportOrder = new ReportOrder();
        $newReportOrder->report_id = $report_id;
        $newReportOrder->notes = $notes;
        $newReportOrder->price = $price;
        $isSaveSuccess = $newReportOrder->saveOrFail();
        if (!$isSaveSuccess) {
            throw new Exception("error saving report order to db", 1);
        }
        return $newReportOrder;
    }

    public function addReportNOODetail($reportId)
    {
        $newReportNOO = new ReportNOO();
        $newReportNOO->report_id = $reportId;
        $isSaveSuccess = $newReportNOO->saveOrFail();
        if (!$isSaveSuccess) {
            throw new Exception("error saving report order to db", 1);
        }
        return $newReportNOO;
    }
}
