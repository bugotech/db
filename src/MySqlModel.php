<?php namespace Bugotech\Db;

use Bugotech\Db\Traits\CastModel;
use Bugotech\Db\Traits\MutatorModel;
use Bugotech\Db\Traits\LoaddingModel;
use Bugotech\Db\Traits\ValidatorModel;
use Bugotech\Db\Traits\DefaultValuesModel;
use Illuminate\Database\Eloquent\Model as Eloquent;

class MySqlModel extends Eloquent
{
    use CastModel;
    use MutatorModel;
    use LoaddingModel;
    use ValidatorModel;
    use DefaultValuesModel;

    protected $connection = 'mysql';
    public $timestamps = false;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
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
}