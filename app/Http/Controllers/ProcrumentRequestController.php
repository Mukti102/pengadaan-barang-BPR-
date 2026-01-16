<?php

namespace App\Http\Controllers;

use App\Models\ProcrumentRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Symfony\Component\Clock\now;

class ProcrumentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        if ($auth->role == 'staf') {
            $procruments = ProcrumentRequest::where('user_id', $auth->id)->get();
        } else {
            $procruments = ProcrumentRequest::with('user')->get();
        }
        return view('pages.procrumentRequest.index', compact('procruments'));
    }

    public function print()
    {
        $procruments = ProcrumentRequest::with('user')->get();
        $pdf =  Pdf::loadView('pages.procrumentRequest.print', [
            'procruments' => $procruments
        ]);
        return $pdf->stream('document.pdf');
    }
// 
    public function cetak($id)
    {
        $procrumentRequest = ProcrumentRequest::find($id);
        $procrumentRequest->load('user', 'items');
        $pdf =  Pdf::loadView('pages.procrumentRequest.cetak', [
            'procrument' => $procrumentRequest
        ]);
        return $pdf->stream('document.pdf');
        // if ($procrumentRequest->status == 'disetujui') {
        //     $pdf =  Pdf::loadView('pages.procrumentRequest.cetak', [
        //         'procrument' => $procrumentRequest
        //     ]);
        //     return $pdf->stream('document.pdf');
        // } else {
        //     toastify()->error('Pengajuan Pengadaan Belum Di setujui');
        //     return redirect()->back();
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.procrumentRequest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['items' => 'required|array']);

        $procurement = ProcrumentRequest::create([
            'code' => $request->code,
            'user_id' => auth()->id(),
            'date' => $request->date,
            'status' => 'menunggu',
            'total_amount' => $request->total_amount,
        ]);

        foreach ($request->items as $item) {
            $procurement->items()->create($item);
        }

        toastify()->success('Pengajuan Berhasil Di Kirim Harap Tunggu untuk di konfirmasi');

        return redirect()->route('procrument-request.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProcrumentRequest $procrumentRequest)
    {
        $procrumentRequest->load('user', 'items');
        return view('pages.procrumentRequest.show', compact('procrumentRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProcrumentRequest $procrumentRequest)
    {
        return view('pages.procrumentRequest.edit', compact('procrumentRequest'));
    }

    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $procrumentRequest = ProcrumentRequest::findOrFail($id);

            // Simpan approval
            $procrumentRequest->approvals()->create([
                'approved_by'   => auth()->id(),
                'approval_date' => now(),
                'status'        => 'disetujui',
                'note'          => null,
            ]);

            // Update status pengajuan
            $procrumentRequest->update([
                'status' => 'disetujui',
            ]);

            DB::commit();

            toastify()->success('Pengajuan berhasil disetujui');
            return back();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            toastify()->error('Data tidak ditemukan');
            return back();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            Log::info('error', $e->getMessage());
            toastify()->error('Terjadi kesalahan sistem');
            return back();
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $procrumentRequest = ProcrumentRequest::findOrFail($id);

            // Simpan approval penolakan
            $procrumentRequest->approvals()->create([
                'approved_by'   => auth()->id(),
                'approval_date' => now(),
                'status'        => 'ditolak',
                'note'          => $request->reason,
            ]);

            // Update status pengajuan
            $procrumentRequest->update([
                'status' => 'ditolak',
            ]);

            DB::commit();

            toastify()->success('Pengajuan berhasil ditolak');
            return back();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            toastify()->error('Data tidak ditemukan');
            return back();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            toastify()->error('Terjadi kesalahan sistem');
            return back();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProcrumentRequest $procrumentRequest)
    {
        // 1. Update Header
        $procrumentRequest->update([
            'date' => $request->date,
            'total_amount' => $request->total_amount,
        ]);

        // 2. Hapus item lama dan masukkan yang baru (Cara termudah)
        $procrumentRequest->items()->delete();

        foreach ($request->items as $item) {
            $procrumentRequest->items()->create($item);
        }

        toastify()->success('Berhasil Di Updated');

        return redirect()->route('procrument-request.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProcrumentRequest $procrumentRequest)
    {
        $procrumentRequest->delete();
        toastify()->success('Berhasil Di Hapus');
        return redirect()->back();
    }
}
