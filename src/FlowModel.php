<?php namespace Bugotech\Db;

use Bugotech\Db\Flow\Steps;

abstract class FlowModel extends MongoDbModel
{
    protected $collection = 'flows';

    /**
     * @var Steps
     */
    public $steps;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->steps = new Steps();
        $this->bootSteps();

        parent::__construct($attributes);
    }

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        self::loaded(function (FlowModel $model) {
            // Carregar caixas dos passos
            foreach ($model->steps->all() as $s) {
                $model->{$s->key}()->associate($model->{$s->key}()->create([]));
            }
        });

        // BeforePost
        self::saving(function (FlowModel $model) {
            // Iniciar control
            if (! array_key_exists('control', $model->getAttributes())) {
                $model->control()->associate($model->control()->create([]));
            }
        });

        // Preparar regras
        self::validating(function(FlowModel $model) {
            ///..
        });
    }

    /**
     * Define steps.
     * @return void
     */
    abstract public function bootSteps();

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function control()
    {
        return $this->embedsOne('\Bugotech\Db\Flow\Control');
    }

    /**
     * @param null $relation
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    protected function embedsStep($relation = null)
    {
        if (is_null($relation)) {
            list(, $caller) = debug_backtrace(false);

            $relation = $caller['function'];
        }

        return $this->embedsOne('\Bugotech\Db\Flow\StepModel', null, null, $relation);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->steps->exists($method)) {
            return $this->embedsStep($method);
        }

        return parent::__call($method, $parameters);
    }
}