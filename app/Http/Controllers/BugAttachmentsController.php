<?php

namespace App\Http\Controllers;

use App\Models\Bugs;
use Illuminate\Http\Request;
use App\Models\BugAttachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BugAttachmentsController extends Controller
{
    public function index(Request $request)
    {
        $query = BugAttachments::with(['bugs', 'user']);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->q . '%')
                    ->orWhereHas('bugs', function ($bug) use ($request) {
                        $bug->where('title', 'like', '%' . $request->q . '%');
                    })
                    ->orWhereHas('user', function ($user) use ($request) {
                        $user->where('name', 'like', '%' . $request->q . '%');
                    });
            });
        }

        $attachments = $query->latest()->paginate(10);
        $bugs = Bugs::all();

        return view('bugAttachments.index', compact('attachments', 'bugs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'bug_id' => 'required|exists:bugs,id',
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fileName = $request->file('file')->hashName();
        $request->file('file')->storeAs('foto', $fileName, 'public');

        BugAttachments::create([
            'bug_id' => $request->bug_id,
            'uploaded_by' => Auth::id(),
            'file_path' => $fileName,
        ]);

        return back()->with('success', 'Data added successfully!');
    }


public function update(Request $request, BugAttachments $bugAttachment)
{
    $request->validate([
        'bug_id' => 'required|exists:bugs,id',
        'file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = [
        'bug_id' => $request->bug_id,
    ];

    if ($request->hasFile('file')) {
        // hapus file lama
        Storage::disk('public')->delete('foto/' . $bugAttachment->file_path);

        // simpan file baru
        $fileName = $request->file('file')->hashName();
        $request->file('file')->storeAs('foto', $fileName, 'public');

        $data['file_path'] = $fileName;
    }

    $bugAttachment->update($data);

    return back()->with('success', 'Data updated successfully!');
}


    public function destroy(BugAttachments $bugAttachment)
    {
        Storage::disk('public')->delete('foto/' . $bugAttachment->file_path);
        $bugAttachment->delete();

        return back()->with('success', 'Data has been successfully deleted.');
    }
}
