<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BypassWorkorder;
use Illuminate\Http\Request;

class BypassWorkorderController extends Controller
{
    public function index()
    {
        return view('user.bypass.index', [
            'title' => 'Bypass Workorder',
        ]);
    }

    public function initiated()
    {
        $initiatedForceClose = BypassWorkorder::where('initiated_by', '!=', null)->where('approved_by', null)->get();

        return datatables()->of($initiatedForceClose)
            ->addColumn('wo_number', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->wo_number;
            })
            ->addColumn('bb_supplier', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->bb_supplier;
            })
            ->addColumn('fg_customer', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->fg_customer;
            })
            ->addColumn('status_wo', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->status_wo;
            })
            ->addColumn('machine', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->machine->name;
            })
            ->addColumn('processed_by', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->processedBy->name;
            })
            ->addColumn('process_start', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->process_start;
            })
            ->addColumn('initiated_by', function ($initiatedForceClose) {
                return $initiatedForceClose->initiatedBy->name;
            })
            ->addColumn('remarks', function ($initiatedForceClose) {
                return $initiatedForceClose->remarks;
            })
            ->addColumn('action', function ($initiatedForceClose) {
                return '<a href="' . route('operator.production.show', $initiatedForceClose->workorder->id) . '" class="btn btn-sm btn-primary">Show</a>';
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function history()
    {
        $initiatedForceClose = BypassWorkorder::where('initiated_by', '!=', null)->where('approved_by', '!=', null)->get();

        return datatables()->of($initiatedForceClose)
            ->addColumn('wo_number', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->wo_number;
            })
            ->addColumn('bb_supplier', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->bb_supplier;
            })
            ->addColumn('fg_customer', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->fg_customer;
            })
            ->addColumn('status_wo', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->status_wo;
            })
            ->addColumn('machine', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->machine->name;
            })
            ->addColumn('processed_by', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->processedBy->name;
            })
            ->addColumn('process_start', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->process_start;
            })
            ->addColumn('process_end', function ($initiatedForceClose) {
                return $initiatedForceClose->workorder->process_end;
            })
            ->addColumn('initiated_by', function ($initiatedForceClose) {
                return $initiatedForceClose->initiatedBy->name;
            })
            ->addColumn('approved_by', function ($initiatedForceClose) {
                return $initiatedForceClose->approvedBy->name;
            })
            ->addColumn('remarks', function ($initiatedForceClose) {
                return $initiatedForceClose->remarks;
            })
            ->addColumn('action', function ($initiatedForceClose) {
                return '<a href="' . route('workorder.show', $initiatedForceClose->workorder->id) . '" class="btn btn-sm btn-primary">Show</a>';
            })
            ->addIndexColumn()
            ->toJson();
    }
}
