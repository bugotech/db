<?php namespace Bugotech\Db;

class DbServiceProvider extends \Illuminate\Database\DatabaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('database', __DIR__ . '/../config/database.php');

        parent::register();

        // Alias
        $this->app->alias('db', 'Illuminate\Database\DatabaseManager');
        $this->app->alias('db', 'Illuminate\Database\ConnectionResolverInterface');

        // MongoDb
        $this->app->register('\Jenssegers\Mongodb\MongodbServiceProvider');
    }
}
