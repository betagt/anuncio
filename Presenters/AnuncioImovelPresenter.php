<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\AnuncioImovelTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AnuncioImovelPresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class AnuncioImovelPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AnuncioImovelTransformer();
    }
}
