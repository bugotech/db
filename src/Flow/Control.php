<?php namespace Bugotech\Db\Flow;

use Bugotech\Db\MongoDbModel;

class Control extends MongoDbModel
{
    public $timestamps = true;

    public $validates = [
        'step' => 'required',
        'validated' => 'required',
    ];

    protected $fillable = ['step'];

    protected $casts = [
        'step' => 'str',
    ];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        // BeforePost
        self::saving(function (Control $model) {

            $steps = $model->parentRelation->getParent()->steps;
            $step = $steps->current();

            // Montar lista de validados
            $model->validated = [];
            if (! is_null($step)) {
                foreach ($steps->all() as $s) {
                    if ($s->key == $step->key) {
                        break;
                    }
                    $model->validated[] = $s->key;
                }
            }
        });
    }
}