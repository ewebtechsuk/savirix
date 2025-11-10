<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\ESignatureService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct(private ESignatureService $signatures)
    {
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'documentable_type' => 'required|string',
            'documentable_id' => 'required|integer',
            'file' => 'required|file',
            'name' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'documentable_type' => $validated['documentable_type'],
            'documentable_id' => $validated['documentable_id'],
            'name' => $validated['name'] ?? $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Document uploaded.');
    }

    public function sign(Request $request, int $document)
    {
        $persistedDocument = Document::query()->findOrFail($document);

        $filePath = $persistedDocument->file_path
            ?? $persistedDocument->getRawOriginal('file_path')
            ?? $request->input('file_path');

        if (! $filePath) {
            abort(422, 'Document is missing a source file.');
        }

        $persistedDocument->file_path = $filePath;

        $signatureRequestId = $this->signatures->createSignatureRequest($persistedDocument);

        $persistedDocument->forceFill([
            'signature_request_id' => $signatureRequestId,
            'signed_at' => null,
        ])->save();

        return redirect()->back()->with('success', 'Document sent for signature.');
    }

    public function download(int $document)
    {
        $persistedDocument = Document::query()->findOrFail($document);

        $filePath = $persistedDocument->file_path ?? $persistedDocument->getRawOriginal('file_path');

        if (! $filePath) {
            $filePath = Document::query()->whereKey($persistedDocument->getKey())->value('file_path');
        }

        if (! $filePath) {
            abort(404);
        }

        $persistedDocument->file_path = $filePath;

        return Storage::disk('public')->download($persistedDocument->file_path, $persistedDocument->name);
    }

    public function downloadSigned(int $document)
    {
        $persistedDocument = Document::query()->findOrFail($document);

        $filePath = $persistedDocument->file_path ?? $persistedDocument->getRawOriginal('file_path');

        if (! $filePath) {
            $filePath = Document::query()->whereKey($persistedDocument->getKey())->value('file_path');
        }

        if (! $filePath) {
            abort(404);
        }

        $persistedDocument->file_path = $filePath;

        abort_unless($persistedDocument->signature_request_id && $persistedDocument->signed_at, 404);

        $download = $this->signatures->downloadSignedDocument($persistedDocument);

        return response($download['body'], 200, [
            'Content-Type' => $download['content_type'],
            'Content-Disposition' => 'attachment; filename="' . $download['filename'] . '"',
        ]);
    }

    public function callback(Request $request)
    {
        $payload = $request->validate([
            'signature_request_id' => 'required|string',
            'status' => 'required|string',
            'completed_at' => 'nullable|date',
        ]);

        $document = Document::where('signature_request_id', $payload['signature_request_id'])->first();

        if ($document && in_array(strtolower($payload['status']), ['completed', 'signed'], true)) {
            $document->signed_at = isset($payload['completed_at'])
                ? Carbon::parse($payload['completed_at'])
                : now();
            $document->save();
        }

        return response()->json(['status' => 'ok']);
    }
}
