<?php

namespace App\Http\Controllers;

use App\Models\ProcrumentRequest;
use App\Models\Supplier;
use App\Models\SupplierEvaluation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $user_id = Auth::id();

        // Data Dasar
        $data = [
            'role' => $role,
            'total_requests' => ProcrumentRequest::count(),
            // Jika admin/pimpinan lihat semua, jika staff lihat miliknya saja
            'requests' => ($role === 'staf')
                ? ProcrumentRequest::where('user_id', $user_id)->latest()->get()
                : ProcrumentRequest::latest()->get(),
            'suppliers' => Supplier::take(5)->get(),
        ];

        if ($role === 'admin') {
            $data['total_users'] = User::count();
            $data['total_suppliers'] = Supplier::count();
            $data['total_evaluations'] = SupplierEvaluation::count();
        } elseif ($role === 'pimpinan') {
            $data['pending_approvals'] = ProcrumentRequest::where('status', 'menunggu')->count();
            $data['total_budget'] = ProcrumentRequest::where('status', 'disetujui')->sum('total_amount');
        } else { // Staff
            $data['my_pending_count'] = ProcrumentRequest::where('user_id', $user_id)
                ->where('status', 'menunggu')->count();
        }

        return view('pages.dashboard', compact('data'));
    }
}
