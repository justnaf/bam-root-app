<?php

namespace App\Http\Controllers;

use App\Models\Majelis;
use App\Models\PresenceMajelis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajelisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kajian = Majelis::all();
        return view('majelis.index', compact('kajian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('majelis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $majelis = new Majelis();
        $majelis->user_id = Auth::id();
        $majelis->code = uniqid();
        $majelis->name = $request->name;
        $majelis->desc = $request->desc;
        $majelis->loc_name = $request->location;
        $majelis->loc_link = $request->location_url;
        $majelis->category = $request->category;
        $majelis->start_date = $request->start_date;
        $majelis->end_date = $request->end_date;
        $majelis->save();
        if ($majelis->wasRecentlyCreated) {
            return redirect()->route('majelis.index')->with('success', 'Berhasil Menambahkan Kajian');
        }
        return redirect()->route('majelis.index')->with('error', 'Gagal Menambahkan Kajian');
    }

    /**
     * Display the specified resource.
     */
    public function show(Majelis $majeli)
    {
        return view('majelis.show', compact('majeli'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Majelis $majeli)
    {
        return view('majelis.edit', compact('majeli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Majelis $majeli)
    {
        $majeli->name = $request->name;
        $majeli->category = $request->category;
        $majeli->loc_name = $request->location;
        $majeli->loc_link = $request->location_url;
        $majeli->start_date = $request->start_date;
        $majeli->end_date = $request->end_date;
        $majeli->desc = $request->desc;
        if ($majeli->save()) {
            return redirect()->route('majelis.index')->with('success', 'Berhasil Update Kajian');
        }
        return redirect()->route('majelis.index')->with('error', 'Gagal Update Kajian');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Majelis $majeli)
    {
        if ($majeli->delete()) {
            return redirect()->route('majelis.index')->with('success', 'Kajian Berhasil Dihapus.');
        }
    }

    public function changeStatus(Majelis $majelis)
    {
        $statusOrder = ['draft', 'up-coming', 'on-going', 'done'];

        $currentStatusIndex = array_search($majelis->status, $statusOrder);

        $nextStatusIndex = ($currentStatusIndex + 1) % count($statusOrder);

        $majelis->status = $statusOrder[$nextStatusIndex];
        $majelis->save();

        return redirect()->back()->with('success', 'Status changed to ' . $majelis->status);
    }

    public function indexPresences()
    {
        $kajian = Majelis::all()->sortByDesc('created_at');
        return view('majelis.presences.index', compact('kajian'));
    }

    public function getPresencesData(Request $request)
    {
        $data = PresenceMajelis::where('majelis_id', $request->majelis_id)->with(['presencedUser.dataDiri', 'presencerUser.dataDiri'])->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function showPresencesUser($userId)
    {
        $user = User::find($userId);
        $data = PresenceMajelis::where('user_id_presenced', $userId)->with(['presencedUser.dataDiri', 'presencerUser.dataDiri', 'majelis'])->get();
        return view('majelis.presences.show', compact(['data', 'user']));
    }

    public function destroyPresence(PresenceMajelis $presence) // Use route model binding
    {
        try {
            if ($presence->delete()) {
                return response()->json(['message' => 'Presensi berhasil dihapus.'], 200);
            } else {
                return response()->json(['message' => 'Presensi gagal dihapus.'], 500);
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus presensi.'], 500);
        }
    }
}
