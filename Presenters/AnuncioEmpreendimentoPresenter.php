<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\AnuncioEmpreendimentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AnuncioEmpreendimentoPresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class AnuncioEmpreendimentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AnuncioEmpreendimentoTransformer();
    }
}
