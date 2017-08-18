<?php

namespace Modules\Anuncio\Listeners;

use Modules\Anuncio\Events\AnuncioCadastrado;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Anuncio\Repositories\AnuncioPrecoRepository;

class LogAnuncioPreco
{
    /**
     * @var AnuncioPrecoRepository
     */
    private $anuncioPrecoRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AnuncioPrecoRepository $anuncioPrecoRepository)
    {
        $this->anuncioPrecoRepository = $anuncioPrecoRepository;
    }

    /**
     * Handle the event.
     *
     * @param  AnuncioCadastrado $event
     * @return void
     */
    public function handle(AnuncioCadastrado $event)
    {
        $anuncio = $event->getAnuncio();
        $this->anuncioPrecoRepository->create([
            'anuncio_id' => $anuncio->id,
            'valor' => $anuncio->valor,
            'valor_condominio' => $anuncio->valor_condominio,
        ]);
    }
}
