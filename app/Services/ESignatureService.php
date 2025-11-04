<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ESignatureService
{
    public function createSignatureRequest(Document $document): string
    {
        $endpoint = rtrim(Config::get('services.hellosign.endpoint', ''), '/');
        $token = Config::get('services.hellosign.key');

        $filePath = $document->file_path ?? $document->getRawOriginal('file_path');

        if (! $filePath) {
            $filePath = Document::query()->whereKey($document->getKey())->value('file_path');
        }

        if (! $filePath) {
            throw new RuntimeException('Document is missing a source file for the signature request.');
        }

        $payload = [
            'title' => $document->name,
            'file' => base64_encode(Storage::disk('public')->get($filePath)),
            'filename' => $document->name,
            'metadata' => [
                'document_id' => (string) $document->getKey(),
            ],
            'callback_url' => route('signing.callback'),
        ];

        $response = Http::withToken($token)
            ->acceptJson()
            ->post($endpoint . '/signature_requests', $payload)
            ->throw();

        return (string) Arr::get($response->json(), 'signature_request.id');
    }

    /**
     * @return array{body:string, content_type:string, filename:string}
     */
    public function downloadSignedDocument(Document $document): array
    {
        $endpoint = rtrim(Config::get('services.hellosign.endpoint', ''), '/');
        $token = Config::get('services.hellosign.key');

        $response = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/pdf'])
            ->get($endpoint . '/signature_requests/' . $document->signature_request_id . '/file')
            ->throw();

        $name = pathinfo($document->name, PATHINFO_FILENAME) ?: $document->name;
        $extension = pathinfo($document->name, PATHINFO_EXTENSION) ?: 'pdf';

        return [
            'body' => $response->body(),
            'content_type' => $response->header('Content-Type', 'application/pdf'),
            'filename' => sprintf('%s-signed.%s', $name, $extension),
        ];
    }
}
