<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 17/02/2017
 * Time: 13:43
 */

namespace Modules\Anuncio\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Anuncio\Criteria\CaracteristicaCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Anuncio\Http\Requests\CaracteristicaRequest;
use Modules\Anuncio\Repositories\CaracteristicaRepository;
use Portal\Services\CacheService;
use Prettus\Repository\Exceptions\RepositoryException;

class CaracteristicaController extends BaseController
{
    /**
     * @var CaracteristicaRepository
     */
    private $caracteristicaRepository;
    /**
     * @var CacheService
     */
    private $cacheService;

    public function __construct(
        CaracteristicaRepository $caracteristicaRepository,
        CacheService $cacheService)
    {
        parent::__construct($caracteristicaRepository, CaracteristicaCriteria::class);
        $this->caracteristicaRepository = $caracteristicaRepository;
        $this->cacheService = $cacheService;
    }

    public function getList()
    {
        try {
            if($this->cacheService->has('todas_caracteristicas')){
                return $this->cacheService->get('todas_caracteristicas');
            }
            $data = $this->caracteristicaRepository->all();
            $this->cacheService->put('todas_caracteristicas',$data,15);
            return $data;

        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new CaracteristicaRequest())->rules();
        return $this->validator;
    }
}