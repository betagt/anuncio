<?php

namespace Modules\Anuncio\Http\Controllers\Api\Admin;

use Modules\Anuncio\Criteria\MensagemAnuncioCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Anuncio\Http\Requests\MensagemAnuncioRequest;
use Modules\Anuncio\Repositories\MensagemAnuncioRepository;

class MensagemAnuncioController extends BaseController
{
    /**
     * @var AnuncioRepository
     */
    private $mensagemAnuncioRepository;

    public function __construct(MensagemAnuncioRepository $mensagemAnuncioRepository)
    {
        parent::__construct($mensagemAnuncioRepository, MensagemAnuncioCriteria::class);
        $this->mensagemAnuncioRepository = $mensagemAnuncioRepository;
    }

    public function getValidator($id = null)
    {
        $this->validator = (new MensagemAnuncioRequest())->rules();
        return $this->validator;
    }
}
