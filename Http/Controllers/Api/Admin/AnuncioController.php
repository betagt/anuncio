<?php

namespace Modules\Anuncio\Http\Controllers\Api\Admin;

use Modules\Anuncio\Criteria\PesquisaCriteria;
use Modules\Anuncio\Models\Anuncio;
use Modules\Anuncio\Repositories\LogPesquisaRepository;
use Portal\Models\Imagem;
use Portal\Repositories\ImagemRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Anuncio\Criteria\AnuncioCriteria;
use Modules\Anuncio\Events\AnuncioCadastrado;
use Modules\Core\Services\ImageUploadService;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Anuncio\Http\Requests\AnuncioRequest;
use Modules\Anuncio\Repositories\AnuncioRepository;
use Modules\Anuncio\Services\AnuncioService;
use Prettus\Repository\Exceptions\RepositoryException;

class AnuncioController extends BaseController
{
    /**
     * @var AnuncioRepository
     */
    private $anuncioRepository;

    /**
     * @var AnuncioService
     */
    private $anuncioService;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;
    /**
     * @var ImagemRepository
     */
    private $imagemRepository;
	/**
	 * @var LogPesquisaRepository
	 */
	private $logPesquisaRepository;

	public function __construct(
        AnuncioRepository $anuncioRepository,
		LogPesquisaRepository $logPesquisaRepository,
        AnuncioService $anuncioService,
        ImageUploadService $imageUploadService,
        ImagemRepository $imagemRepository)
    {
        parent::__construct($anuncioRepository, AnuncioCriteria::class);
        $this->setPathFile(public_path('arquivos/img/anuncio'));
        $this->anuncioRepository = $anuncioRepository;
        $this->anuncioService = $anuncioService;
        $this->imageUploadService = $imageUploadService;
        $this->imagemRepository = $imagemRepository;
		$this->logPesquisaRepository = $logPesquisaRepository;
	}

    /**
     * @return array
     */
    public function getValidator($id = null, $tipo=null)
    {
        $this->validator = (new AnuncioRequest())->rules($id, $tipo);
        return $this->validator;
    }

	public function store(Request $request)
    {
        $data = $request->all();
        \Validator::make($data, $this->getValidator())->validate();
        try {
            $aux = ['banner' => $data['banner']];
            $this->imageUploadService->upload64('banner', $this->getPathFile(), $aux);
            $data['banner'] = $aux['banner'];
            return $this->anuncioRepository->createByEnderecoPreco($data);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    /**
     * Consulta  por ID
     *
     * Endpoint para consultar passando o ID como parametro
     *
     * @param $id
     * @return retorna um registro
     */
    public function show($id){
        return parent::show($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        \Validator::make($data, $this->getValidator($id, $data['tipo']))->validate();
        try {
            if(preg_match('/(base64)/', $data['banner'])){
                $aux = ['banner' => $data['banner']];
                $this->imageUploadService->upload64('banner', $this->getPathFile(), $aux);
                $data['banner'] = $aux['banner'];
            }else{
                unset($data['banner']);
            }
            return $this->anuncioRepository->updateByEnderecoPreco($data, $id);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }


    public function checkPlanoAtivo($idAnuncio)
    {
        //$this->anuncioRpo
        return;
    }

    public function suspender($id)
    {
        $anuncio = $this->anuncioRepository->skipPresenter(true)->find($id);
        try {
            if (!$anuncio->getPssuiContratacao()) {
                throw new Exception('Anuncio não possui contratação');
            }
            $anuncio->status = !$anuncio->status;
            $anuncio->save();
            return parent::responseSuccess(parent::HTTP_CODE_OK, 'Alterado com sucesso!');
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function salvarImagem(Request $request, $id)
    {
        $request->merge(['max_imagens' => $id]);
        $request->merge(['anuncio' => $id]);
        $data = $request->all();
        \Validator::make($data, [
            'imagem' => 'array|max:10',
            'max_imagens' => "count:10," . Anuncio::class,
            'anuncio' => 'exists:anuncios,id',
            'imagem.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,bmp,png'
            ]
        ])->validate();
        try {
            $result = [];
            if(isset($data['imagem'])) {
                foreach ($data['imagem'] as $key => $img) {
                    $aux = ['imagem' => $img];
                    $this->imageUploadService->upload('imagem', $this->getPathFile(), $aux);
                    $filemake = explode('.', $aux['imagem']);
                    $imagem_list = Imagem::$tamanhos;
                    foreach ($imagem_list['anuncio'] as $index => $item) {
                        $this->imageUploadService->cropPhoto('arquivos/img/anuncio/' . $aux['imagem'], array(
                            'width' => $item['w'],
                            'height' => $item['h'],
                            'grayscale' => false
                        ), 'arquivos/img/anuncio/' . $filemake[0] . '_' . $index . '.' . $filemake[1]);
                    }
                    $imagem = $this->imagemRepository->create([
                        'img' => $aux['imagem'],
                        'imagemtable_id' => $id,
                        'imagemtable_type' => Anuncio::class,
                        'princial' => false,
                        'prioridade' => $key + 1
                    ]);
                    $result['data'][$key] = $imagem['data'];
                    $result['data'][$key]['img'] = \URL::to('/') . '/arquivos/img/anuncio/' . $filemake[0] . '_img_230_160.' . $filemake[1];
                }
                return $result;
            }else{
                throw new \Exception('imagem não encontrada!');
            }
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    public function imagensByAnuncios($id){
        try{
            return $this->anuncioRepository->skipPresenter(true)->find($id)->imagens;
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        }catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        }catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Deletar
     *
     * Endpoint para deletar passando o ID
     */
    public function destroyImage($id){
        try{
            $this->imagemRepository->delete($id);
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function reOrdenar(Request $request){
        $data = $request->all();
        \Validator::make($data, [
            'imagem'=>'array|max:10',
            'imagem.*' => [
                'required'
            ]
        ])->validate();
        try {
            foreach ($data['imagem'] as $key => $img){
                $imagem = $this->imagemRepository->skipPresenter(true)->find($img['id']);
                $imagem->principal = $img['principal'];
                $imagem->prioridade = $key+1;
                $imagem->save();
            }
            return parent::responseSuccess(parent::HTTP_CODE_OK, 'imagens alterada com sucesso');
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

	public function statisticas(Request $request){
		try{
			$result = $this->logPesquisaRepository
				->pushCriteria(new PesquisaCriteria($request))
				->pushCriteria(new OrderCriteria($request))
				->paginate(self::$_PAGINATION_COUNT, ['pesquisa','count']);

			$result['meta']['contagem'] = $this->logPesquisaRepository->contagem();
			return $result;
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
}
