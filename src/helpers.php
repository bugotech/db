<?php

if (! function_exists('db')) {

    /**
     * Database DB.
     *
     * @param null $connection
     * @return \Illuminate\Database\Connection|\Illuminate\Database\DatabaseManager
     */
    function db($connection = null)
    {
        $db = app('db');

        if (is_null($connection)) {
            return $db;
        }

        return $db->connection($connection);
    }
}

if (! function_exists('schema')) {

    /**
     * Database DB Schema.
     *
     * @param null $connection
     * @return \Illuminate\Database\Schema\Builder
     */
    function schema($connection = null)
    {
        return db($connection)->getSchemaBuilder();
    }
}