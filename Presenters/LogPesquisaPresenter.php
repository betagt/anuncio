<?php

namespace Modules\Anuncio\Presenters;

use Modules\Anuncio\Transformers\LogPesquisaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LogPesquisaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class LogPesquisaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LogPesquisaTransformer();
    }
}
