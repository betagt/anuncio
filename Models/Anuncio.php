<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Anuncio\Scope\AnuncioSiteScope;
use Modules\Core\Models\User;
use Modules\Localidade\Models\Endereco;
use Modules\Localidade\Models\Telefone;
use Modules\Plano\Models\PlanoContratacao;
use OwenIt\Auditing\Auditable;
use Portal\Models\Imagem;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Anuncio extends Model implements Transformable
{
    use TransformableTrait, Auditable, SoftDeletes;

    const TYPE_ALUGAR = 'Alugar';
    const TYPE_VENDER = 'Vender';
    const TYPE_REVENDER = 'Revender';

    const TYPE_ANUNCIO_IMOVEL = 'imovel';
    const TYPE_ANUNCIO_EMPREENDIMENTO = 'empreendimento';

    const STATUS_ATIVO = true;
    const STATUS_INATIVO = false;

    public static $pretencao = [
      'Alugar', 'Vender', 'Revender'
    ];
    public static function boot()
    {
        parent::boot();
        //static::addGlobalScope(new AnuncioSiteScope());

    }
    protected $fillable = [
        'user_id',
        'finalidade_id',
        'endereco_id',
        'pretensao',
        'codigo',
        'valor',
        'valor_condominio',
        'descricao',
        'ano_construcao',
        'observacao',
        'configuracao_extra',
        'latitude',
        'longitude',
        'tipo',

        'area_util',
        'area_total',
        'qtde_dormitorio',
        'qtde_suite',
        'qtde_banheiro',
        'qtde_vaga',
        'possui_divida',
        'saldo_divida',
        'valor_mensalidade_divida',
        'data_vencimento_divida',
        'data_ultima_parcela_divida',
        'qtde_parcela_restante_divida',

        'titulo',
        'titulo_reduzido',
        'subtitulo',
        'descricao_curta',
        'qtde_area_minimo',
        'qtde_area_maximo',
        'qtde_dormitoario_minimo',
        'qtde_dormitoario_maximo',
        'qtde_suite_minimo',
        'qtde_suite_maximo',
        'qtde_andar',
        'qtde_elevador',
        'qtde_unidade_andar',
        'situacao',
        'status',
        'remove_site_view',
        'anuncio_mapa_confirm',
        'video'
    ];
    public function getSlugAttribute($value){
        if(is_null($value)){
            if($this->tipo == Anuncio::TYPE_ANUNCIO_IMOVEL) {
                $value = str_slug($this->tipo . ' '.
                    (($this->finalidade)?$this->finalidade->titulo:'') . ' ' .
                    $this->pretensao . ' ' .
                    $this->qtde_dormitorio . ' quartos ' .
                    $this->area_util . ' m2 ' .
                    (($this->endereco)?$this->endereco->endereco:'') . ' ' .
                    (($this->endereco)?$this->endereco->bairro->titulo:'') . ' ' .
                    (($this->endereco)?$this->endereco->cidade->titulo:'') . ' ' .
                    (($this->endereco)?$this->endereco->estado->uf:''), '+');
            }else{
                $value = str_slug(
                    $this->tipo . ' ' .
                    $this->pretensao. ' ' .
                    (($this->endereco)?$this->estado->uf:'') . ' ' .
                    (($this->endereco)?$this->cidade->titulo:'') . ' ' .
                    (($this->endereco)?$this->bairro->titulo:'') . ' ' .
                    (($this->endereco)?$this->endereco->endereco:'') . ' ' .
                    $this->titulo .
                    (($this->qtde_area_minimo)?$this->qtde_area_minimo.' m2 ':'').
                    (($this->qtde_area_maximo)?$this->qtde_area_maximo.' m2':''), '+');
            }
        }

        return $value;
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function finalidade(){
        return $this->belongsTo(Finalidade::class, 'finalidade_id');
    }

    public function caracteristicas(){
        return $this->belongsToMany(Caracteristica::class, 'anuncio_caracteristicas', 'anuncio_id', 'caracteristica_id');
    }

    public function telefones(){
        return $this->morphMany(Telefone::class,'telefonetable');
    }
    public function telefone(){
        return $this->morphOne(Telefone::class,'telefonetable')->where('principal',true);
    }

    public function imagens(){
        return $this->morphMany(Imagem::class,'imagemtable');
    }

    public function endereco(){
        return $this->morphOne(Endereco::class,'enderecotable');
    }

    public function preco(){
        return $this->hasOne(AnuncioPreco::class, 'anuncio_id');
    }

    public function contratacaoAtiva(){
        //return $this->belongsToMany(PlanoContratacao::class, 'anuncio_contratacaos','anuncio_id', 'plano_contratacao_id')->whereOr('status','ativo')->whereOr('status','pendente');
        return $this->belongsToMany(PlanoContratacao::class, 'anuncio_contratacaos','anuncio_id', 'plano_contratacao_id')->where('status','ativo');
    }

    public function houvecontratacao(){
        //return $this->belongsToMany(PlanoContratacao::class, 'anuncio_contratacaos','anuncio_id', 'plano_contratacao_id')->whereOr('status','ativo')->whereOr('status','pendente');
        return $this->belongsToMany(PlanoContratacao::class, 'anuncio_contratacaos','anuncio_id', 'plano_contratacao_id')->orderBy('id','desc');
    }

    public function concicaoComercial(){
        return $this->hasOne(AnuncioCondicaoComercial::class, 'anuncio_id');
    }

    public function precos(){
        return $this->hasMany(AnuncioPreco::class, 'anuncio_id');
    }

    public function getValorAtivo(){
        return $this->preco->orderBy('id', 'desc')->limit(1)->first();
    }

    public function imagemPrincipal(){
        $imagem = $this->imagens->where('principal', true)->first();
        if(is_null($imagem)){
            return null;
        }
        $tamanos = [];
        $imagem_list = Imagem::$tamanhos;
        $filemake = explode('.', $imagem->img);
        foreach ($imagem_list['anuncio'] as $index => $item) {
            $tamanos[$index] = \URL::to('/') . '/arquivos/img/anuncio/' . $filemake[0] . '_' . $index . '.' . $filemake[1];
        }
        return $tamanos;
    }

    public function getPssuiContratacao(){
        return (boolean)($this->contratacaoAtiva->count() > 0)?true:false;
    }
}
