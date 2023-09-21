<?php

namespace App\Jobs;

use App\Mail\InviteUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $selectedEmail;
    public $tenant;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $tenantName)
    {
        $this->selectedEmail = $email;
        $this->tenant = $tenantName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->selectedEmail)->send(new InviteUser($this->tenant, env('APP_URL', 'https://cleopatra.test')));

    }
}
