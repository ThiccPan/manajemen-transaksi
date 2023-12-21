<?php

namespace App\Services;

use App\Models\ReportOrder;

class ReportOrderService {
    private ReportOrder $reportOrder;
    
    public function __construct(ReportOrder $reportOrder)
    {
        $this->reportOrder = $reportOrder;
    }

    public function add($report_id, $notes, $price)
    {
        $newReportOrder = new ReportOrder();
        $newReportOrder->report_id = $report_id;
        $newReportOrder->notes = $notes;
        $newReportOrder->price = $price;
        $isSaveSuccess = $newReportOrder->saveOrFail();
        if ($isSaveSuccess) {
            return $newReportOrder;
        }
    }
}