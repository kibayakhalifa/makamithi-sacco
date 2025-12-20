<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberDocumentController extends Controller
{
    /**
     * Store a newly created document.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'type' => 'required|in:national_id,passport_photo,employment_letter,bank_statement,pay_slip,other',
            'name' => 'nullable|required_if:type,other|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);
        
        $user = Auth::user();
        
        // Delete existing document of same type if exists (except for 'other')
        if ($request->type !== 'other') {
            Document::where('user_id', $user->id)
                   ->where('type', $request->type)
                   ->delete();
        }
        
        // Store the document
        $path = $request->file('document')->store('documents/' . $user->id, 'public');
        
        // Get document name
        $name = $request->name ?? ucfirst(str_replace('_', ' ', $request->type));
        
        // Create document record
        $document = Document::create([
            'user_id' => $user->id,
            'name' => $name,
            'type' => $request->type,
            'file_path' => $path,
            'file_name' => $request->file('document')->getClientOriginalName(),
            'file_size' => $request->file('document')->getSize(),
            'mime_type' => $request->file('document')->getMimeType(),
        ]);
        
        return redirect()->route('member.profile')->with('success', 'Document uploaded successfully!');
    }
    
    /**
     * Delete a document.
     */
    public function destroy(Document $document)
    {
        // Check if document belongs to user
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        // Delete record
        $document->delete();
        
        return redirect()->route('member.profile')->with('success', 'Document deleted successfully!');
    }
    
    /**
     * View/download a document.
     */
    public function show(Document $document)
    {
        // Check if document belongs to user
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }
        
        return Storage::disk('public')->response($document->file_path);
    }
}