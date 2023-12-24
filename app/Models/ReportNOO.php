<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property String $report_id
 */
class ReportNOO extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'report_noo';

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
