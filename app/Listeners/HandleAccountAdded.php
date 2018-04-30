<?php

namespace App\Listeners;

use App\Events\AccountAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\AccountVerifyMail;
use Mail;

class HandleAccountAdded
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccountAdded  $event
     * @return void
     */
    public function handle(AccountAdded $event)
    {
        //
	Mail::to($event->user->email)->send(new AccountVerifyMail($event->user));
    }
}
