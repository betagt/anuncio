<?php

namespace Modules\Anuncio\Listeners;

use Modules\Anuncio\Events\GerarScore;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Anuncio\Repositories\AnuncioRepository;
use Modules\Anuncio\Repositories\ScoreRepository;

class MarcarPonto
{
    /**
     * @var ScoreRepository
     */
    private $scoreRepository;
    /**
     * @var AnuncioRepository
     */
    private $anuncioRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ScoreRepository $scoreRepository, AnuncioRepository $anuncioRepository)
    {
        $this->scoreRepository = $scoreRepository;
        $this->anuncioRepository = $anuncioRepository;
    }

    /**
     * Handle the event.
     *
     * @param  GerarScore  $event
     * @return void
     */
    public function handle(GerarScore $event)
    {
        $this->scoreRepository->create([
          'user_id'=>$event->getUserId(),
          'anuncio_id'=>$event->getAnuncioId(),
          'acesso'=>$event->getTipo(),
          'ponto'=>$event->getPontuacao(),
        ]);
        $anuncio = $this->anuncioRepository->skipPresenter(true)->find($event->getAnuncioId());
        $anuncio->score = $this->scoreRepository->findWhere(['anuncio_id'=>$event->getAnuncioId()])->sum('ponto');
        $anuncio->save();
    }
}
