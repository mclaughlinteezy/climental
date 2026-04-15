<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reportable_id' => 'required|integer',
            'reportable_type' => 'required|string',
            'reason' => 'required|string|max:1000',
        ]);

        // Prevent duplicate reporting by same user
        $exists = Report::where('user_id', auth()->id())
            ->where('reportable_id', $request->reportable_id)
            ->where('reportable_type', $request->reportable_type)
            ->exists();

        if ($exists) {
            return back()->with('info', 'You have already reported this item.');
        }

        Report::create([
            'user_id' => auth()->id(),
            'reportable_id' => $request->reportable_id,
            'reportable_type' => $request->reportable_type,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Thank you. The report has been sent to our community moderators.');
    }

    public function resolve(Report $report)
    {
        if (!in_array(auth()->user()->role, ['moderator', 'admin'])) {
            return abort(403);
        }

        // Simplest resolution is deleting the report
        $report->delete();

        return back()->with('success', 'Report resolved.');
    }
}
