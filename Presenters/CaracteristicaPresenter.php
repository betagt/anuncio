<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\CaracteristicaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CaracteristicaPresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class CaracteristicaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CaracteristicaTransformer();
    }
}
