<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\AnuncioPrecoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AnuncioPrecoPresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class AnuncioPrecoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AnuncioPrecoTransformer();
    }
}
