<?php

namespace Modules\Anuncio\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GerarScore
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var array
     */
    private $pontuacao;
    /**
     * @var int
     */
    private $user_id;
    /**
     * @var string
     */
    private $tipo;

    private $anuncio_id;

    /**
     * @return mixed
     */
    public function getAnuncioId()
    {
        return $this->anuncio_id;
    }

    /**
     * @param mixed $anuncio_id
     */
    public function setAnuncioId($anuncio_id)
    {
        $this->anuncio_id = $anuncio_id;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $tipo, int $pontuacao, $anuncio_id, int $user_id = null)
    {
        $this->pontuacao = $pontuacao;
        $this->user_id = $user_id;
        $this->tipo = $tipo;
        $this->anuncio_id = $anuncio_id;
    }

    /**
     * @return array
     */
    public function getPontuacao()
    {
        return $this->pontuacao;
    }

    /**
     * @param array $pontuacao
     */
    public function setPontuacao(array $pontuacao)
    {
        $this->pontuacao = $pontuacao;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo(string $tipo)
    {
        $this->tipo = $tipo;
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
