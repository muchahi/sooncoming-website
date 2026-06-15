<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class WebRTCController extends Controller
{
    protected $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            ['cluster' => config('broadcasting.connections.pusher.options.cluster')]
        );
    }

    public function signal(Request $request)
    {
        // Send signaling data (SDP, ICE candidates) through Pusher
        $this->pusher->trigger('webrtc-channel', 'signal', $request->all());

        return response()->json(['status' => 'Signal sent']);
    }
}
