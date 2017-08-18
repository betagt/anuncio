<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\MensagemAnuncioTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MensagemAnuncioPresenter
 *
 * @package namespace Modules\Anuncio\Presenters;
 */
class MensagemAnuncioPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MensagemAnuncioTransformer();
    }
}
