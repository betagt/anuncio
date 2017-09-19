<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\AnuncioTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AnuncioPresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class AnuncioPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AnuncioTransformer();
    }
}
