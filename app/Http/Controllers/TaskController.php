<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar semua tugas.
     */
    public function index()
    {
        $tasks = Tasks::where('user_id', Auth::id())->orderBy('deadline', 'asc')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Menampilkan form untuk membuat tugas baru.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Menyimpan tugas baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'beban_kognitif' => 'required|in:ringan,sedang,berat',
        ]);

        Auth::user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit tugas.
     */
    public function show(Tasks $task)
    {
        // Pastikan user hanya bisa mengedit tugas miliknya
        // $this->authorize('update', $task);
        return view('tasks.show', compact('task'));
    }
    public function edit(Tasks $task)
    {
        // Pastikan user hanya bisa mengedit tugas miliknya
        // $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Tasks $task)
    {
        // $this->authorize('update', $task);

        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'beban_kognitif' => 'required|in:ringan,sedang,berat',
            'status' => 'required|in:todo,inprogress,done',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Menghapus tugas dari database.
     */
    public function destroy(Tasks $task)
    {
        // $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
