<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Auth\Events\Login;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $messages;

    public function __construct(Message $message)
    {
        $this->messages = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $messageDB = new Message;
        // $messageDB->parent_id = 1;
        // $messageDB->message = $this->messages->message;
        // $messageDB->save();
        Log::info('ok');
    }
}
