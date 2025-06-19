<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MoodLog;

class MoodLogController extends Controller
{
    /**
     * Menyimpan data mood harian baru atau memperbarui yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|in:senang,semangat,biasa,ragu,lelah,stres,sedih',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Gunakan updateOrCreate untuk mencegah duplikat log pada hari yang sama
        MoodLog::updateOrCreate(
            [
                'user_id'   => Auth::id(),
                'created_at' => today(),
            ],
            [
                'mood'      => $request->mood,
                'catatan'   => $request->catatan,
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Mood kamu hari ini berhasil disimpan!');
    }
}
