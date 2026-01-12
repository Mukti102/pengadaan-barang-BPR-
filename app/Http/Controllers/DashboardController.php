<?php

namespace App\Http\Controllers;

use App\Models\ProcrumentRequest;
use App\Models\Supplier;
use App\Models\SupplierEvaluation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $requests = ProcrumentRequest::all();
        $suppliers = Supplier::all();
        $evaluations = SupplierEvaluation::all();
        return view('pages.dashboard', compact('users', 'requests', 'suppliers', 'evaluations'));
    }
}
