<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\FinalidadeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FinalidadePresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class FinalidadePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FinalidadeTransformer();
    }
}
