<?php

namespace Modules\Anuncio\Criteria;
use Illuminate\Http\Request;
use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;


/**
 * Class MensagemAnuncioCriteria
 * @package namespace Portal\Criteria;
 */
class MensagemAnuncioCriteria extends BaseCriteria
{
    protected $filterCriteria = [
        'mensagem_anuncios.id'=>'=',
        'mensagem_anuncios.nome'=>'like',
        'mensagem_anuncios.email'=>'like',
    ];
    /**
     * @var null
     */
    private $id;

    public function __construct(Request $request, $id = null)
    {
        parent::__construct($request);
        $this->id = $id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        if(!is_null($this->id)){
            $model = $model->join('anuncios','mensagem_anuncios.anuncio_id','anuncios.id')
                ->where('anuncios.user_id',$this->id)
                ->select(['mensagem_anuncios.*']);
        }
        return $model;
    }
}
