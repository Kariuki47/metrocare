<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class LogSuccessfulSignup
{
    /**
     * Create the event listener.
     */
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        activity()->performedOn($user)->causedBy($user)->withProperties(['ip' => $this->request->ip(), 'model' => 'User'])->log('signup');
    }
}
