<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\AnuncioCondicaoComercialTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AnuncioCondicaoComercialPresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class AnuncioCondicaoComercialPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AnuncioCondicaoComercialTransformer();
    }
}
