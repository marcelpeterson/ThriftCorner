<?php

namespace App\Http\Controllers;

use App\Models\SupportContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SupportContactController extends Controller
{
    /**
     * Display the support contact form
     */
    public function create()
    {
        return view('support.create');
    }

    /**
     * Store a new support contact submission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:report_suspicious,feedback,delete_listing',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // Max 5MB
            'item_id' => 'nullable|exists:items,id',
        ]);

        $data = [
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => Auth::check() ? Auth::user()->full_name : $request->name,
            'email' => Auth::check() ? Auth::user()->email : $request->email,
            'type' => $validated['type'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'item_id' => $validated['item_id'] ?? null,
            'status' => 'pending',
        ];

        // If not authenticated, validate name and email
        if (!Auth::check()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('support-attachments', config('filesystems.default'));
            $data['attachment_path'] = $path;
        }

        SupportContact::create($data);

        return redirect()->route('support.create')->with('success', 'Your message has been submitted successfully. We will get back to you soon.');
    }
}
