<?php namespace Bugotech\Db\Scope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserScope implements \Illuminate\Database\Eloquent\Scope
{
    /**
     * Aplicar.
     *
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $usuario_id = auth()->id();

        $builder->where('usuario_id', $usuario_id);
    }
}