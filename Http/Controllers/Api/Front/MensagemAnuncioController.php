<?php

namespace Modules\Anuncio\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Anuncio\Criteria\MensagemAnuncioCriteria;
use Modules\Anuncio\Repositories\AnuncioRepository;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Anuncio\Http\Requests\MensagemAnuncioRequest;
use Modules\Anuncio\Repositories\MensagemAnuncioRepository;

class MensagemAnuncioController extends BaseController
{
    /**
     * @var AnuncioRepository
     */
    private $mensagemAnuncioRepository;
    /**
     * @var AnuncioRepository
     */
    private $anuncioRepository;

    public function __construct(
        MensagemAnuncioRepository $mensagemAnuncioRepository,
        AnuncioRepository $anuncioRepository)
    {
        parent::__construct($mensagemAnuncioRepository, MensagemAnuncioCriteria::class);
        $this->mensagemAnuncioRepository = $mensagemAnuncioRepository;
        $this->anuncioRepository = $anuncioRepository;
    }

    public function getValidator($id = null)
    {
        $this->validator = (new MensagemAnuncioRequest())->rules();
        return $this->validator;
    }

    /**
     * Consultar
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function index(Request $request){
        try{
            return $this->mensagemAnuncioRepository
                ->pushCriteria(new MensagemAnuncioCriteria($request, $this->getUserId()))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate(self::$_PAGINATION_COUNT);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function registrar(Request $request,$slug){
        $data = $request->all();
        \Validator::make($data, $this->getValidator())->validate();
        try{
            $anuncio = $this->anuncioRepository->findByAtivo($slug);
            if(is_null($anuncio))
                throw new Exception('anuncio inválido');
            $data['anuncio_id'] = $anuncio['data']['id'];
            $data['status'] = false;

            $this->mensagemAnuncioRepository->create($data);
            return parent::responseSuccess(parent::HTTP_CODE_OK, 'mensagem registrada com sucesso!');
        }catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_OK, $e->getMessage());
        }
    }
}
