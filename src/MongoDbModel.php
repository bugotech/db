<?php namespace Bugotech\Db;

use Bugotech\Db\Traits\CastModel;
use Bugotech\Db\Traits\MutatorModel;
use Bugotech\Db\Traits\LoaddingModel;
use Bugotech\Db\Traits\ValidatorModel;
use Bugotech\Db\Traits\DefaultValuesModel;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MongoDbModel extends Eloquent
{
    use CastModel {
        CastModel::castAlias as parentCastAlias;
    }

    use MutatorModel;
    use LoaddingModel;
    use ValidatorModel;
    use DefaultValuesModel;

    protected $connection = 'mongodb';
    public $timestamps = false;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->collection = is_null($this->collection) ? $this->table : $this->collection;

        $this->prepareDates();

        $this->fireModelEvent('loading', false);

        parent::__construct($attributes);

        $this->fireModelEvent('loaded', false);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // Tratar manipulaçãoes gerais
        $value = $this->resolveMutator($key, $value);

        // Atribuir valores
        return parent::setAttribute($key, $value);
    }

    /**
     * @param $cast
     * @return string
     */
    protected function castAlias($cast)
    {
        $cast = trim(strtolower($cast));

        if ($cast == 'lkp') {
            return 'string';
        }

        return $this->parentCastAlias($cast);
    }
}