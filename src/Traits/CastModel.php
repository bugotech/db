<?php namespace Bugotech\Db\Traits;

trait CastModel
{
    protected static $alias = [
        'str' => 'string',
        'num' => 'float',
        'bol' => 'bool',
        'dat' => 'datetime',
        'txt' => 'string',
        'lst' => 'string',
        'lkp' => 'int',
    ];

    /**
     * Traduzir casts do builder.
     * @param $key
     * @return string
     */
    protected function getCastType($key)
    {
        $cast = parent::getCastType($key);

        // Traduzir campos do builder
        return $this->castAlias($cast);
    }

    /**
     * Traduzir campos do builder.
     * @param $cast
     * @return string
     */
    protected function castAlias($cast)
    {
        $cast = trim(strtolower($cast));

        return array_key_exists($cast, self::$alias) ? self::$alias[$cast] : $cast;
    }

    /**
     * Preparar lista de dates.
     */
    protected function prepareDates()
    {
        $casts = $this->getCasts();
        foreach ($casts as $attr => $cast) {
            $cast = $this->castAlias($cast);

            if ((in_array($cast, ['datetime','date'])) && (! in_array($attr, $this->dates))) {
                $this->dates[] = $attr;
            }
        }
    }
}