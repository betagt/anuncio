<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\LogPesquisaPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\LogPesquisaRepository;
use Modules\Anuncio\Models\LogPesquisa;
//use Modules\Anuncio\Validators\LogPesquisaValidator;

/**
 * Class LogPesquisaRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class LogPesquisaRepositoryEloquent extends BaseRepository implements LogPesquisaRepository
{

    /**
     * Specify Model class name
     *
     * @  return string
     */
    public function model()
    {
        return LogPesquisa::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
	{
		return LogPesquisaPresenter::class;
	}

	public function statistica()
	{

	}

	public function contagem()
	{
		return $this->model->count();
	}
}
