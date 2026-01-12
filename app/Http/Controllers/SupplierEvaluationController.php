<?php

namespace App\Http\Controllers;

use App\Models\ProcrumentRequest;
use App\Models\Supplier;
use App\Models\SupplierEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierEvaluationController extends Controller
{

    public function index()
    {
        $evaluations  = SupplierEvaluation::with('procrumentRequest')->get();
        $suppliers = Supplier::all();
        $requests = ProcrumentRequest::all();
        return view('pages.evaluations.index', compact('evaluations', 'suppliers', 'requests'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'procrument_request_id' => 'required|exists:procrument_requests,id',
            'score' => 'required|integer|min:1|max:100',
            'note' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            SupplierEvaluation::create([
                'supplier_id' => $request->supplier_id,
                'procrument_request_id' => $request->procrument_request_id,
                'score' => $request->score,
                'note' => $request->note,
            ]);

            DB::commit();

            toastify()->success('Evaluasi supplier berhasil ditambahkan');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();

            toastify()->error('Gagal menambahkan evaluasi supplier');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:100',
            'note' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $evaluation = SupplierEvaluation::findOrFail($id);

            $evaluation->update([
                'score' => $request->score,
                'note' => $request->note,
            ]);

            DB::commit();

            toastify()->success('Evaluasi supplier berhasil diperbarui');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            toastify()->error('Gagal memperbarui evaluasi supplier');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $evaluation = SupplierEvaluation::findOrFail($id);
            $evaluation->delete();

            DB::commit();

            toastify()->success('Evaluasi supplier berhasil dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            toastify()->error('Gagal menghapus evaluasi supplier');
            return redirect()->back();
        }
    }
}
