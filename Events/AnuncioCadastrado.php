<?php

namespace Modules\Anuncio\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Anuncio\Models\Anuncio;

class AnuncioCadastrado
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Anuncio
     */
    private $anuncio;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Anuncio $anuncio)
    {
        $this->anuncio = $anuncio;
    }

    /**
     * @return Anuncio
     */
    public function getAnuncio(): Anuncio
    {
        return $this->anuncio;
    }

    /**
     * @param Anuncio $anuncio
     */
    public function setAnuncio(Anuncio $anuncio)
    {
        $this->anuncio = $anuncio;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
