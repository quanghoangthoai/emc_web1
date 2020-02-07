<?php

namespace Modules\Request\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Artisan;

class SendRequestMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $contact;
    public function __construct($contact)
    {
        $this->$contact = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($contact)
    {
        Mail::send('Request::admin.component.mail-request-info', array('name' => $contact["sender_name"], 'email' => $contact["sender_email"], 'iRequest' => $contact["iRequest"]), function ($message) use ($contact) {
            $message->to($contact["sender_email"])->subject('Thông báo từ EMC');
        });
    }
}
