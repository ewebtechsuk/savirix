<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\ContactCommunication;
use App\Services\Messaging\CommunicationManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Throwable;

class SendContactCommunication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Contact $contact,
        public string $channel,
        public array $payload,
        public ?int $userId = null,
        public ?int $communicationId = null,
    ) {
    }

    public function handle(): void
    {
        /** @var CommunicationManager $manager */
        $manager = App::make(CommunicationManager::class);

        $communication = $this->communicationId
            ? ContactCommunication::find($this->communicationId)
            : $this->contact->communications()->create([
                'user_id' => $this->userId,
                'communication' => $this->payload['body'] ?? '',
                'subject' => $this->payload['subject'] ?? null,
                'channel' => $this->channel,
                'status' => 'pending',
            ]);

        if (! $communication) {
            return;
        }

        try {
            $result = $manager->send($this->contact, $this->channel, $this->payload);
            $communication->update([
                'status' => $result->success ? 'delivered' : 'failed',
                'provider' => $result->provider,
                'provider_message_id' => $result->messageId,
                'delivered_at' => $result->success ? now() : null,
                'meta' => $result->meta,
            ]);
        } catch (Throwable $exception) {
            $communication->update([
                'status' => 'failed',
                'meta' => ['exception' => $exception->getMessage()],
            ]);
            throw $exception;
        }
    }
}
