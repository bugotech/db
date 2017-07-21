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
        parent::__construct($attributes);

        $this->steps = new Steps();
        $this->bootSteps();
    }

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

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
}