<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use App\User;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $isMobileSession = $this->request->session()->get('is-mobile-session', false);
        if ($isMobileSession && isset($event->user->id)) {
            $this->request->session()->put('is-mobile-session', false);
            $user = User::find($event->user->id);
            $user->TokenNotificacion = null;
            $user->save();
        }
    }
}
