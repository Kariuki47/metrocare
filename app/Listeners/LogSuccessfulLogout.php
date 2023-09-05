<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;

class LogSuccessfulLogout
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
        activity()->performedOn($user)->withProperties(['ip' => $this->request->ip(), 'model' => 'User'])->log('logout');
    }
}
