<?php namespace Bugotech\Db\Traits;

trait LoaddingModel
{
    /**
     * Register a loading model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param  int  $priority
     * @return void
     */
    public static function loading($callback, $priority = 0)
    {
        static::registerModelEvent('loading', $callback, $priority);
    }

    /**
     * Register a loaded model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @param  int  $priority
     * @return void
     */
    public static function loaded($callback, $priority = 0)
    {
        static::registerModelEvent('loaded', $callback, $priority);
    }
}