<?php namespace Bugotech\Db\Flow;

class Steps
{
    /**
     * Lista de itens.
     * @var array
     */
    protected $steps = [];

    /**
     * Step atual.
     * @var Step
     */
    protected $current;

    /**
     * Add step in list.
     *
     * @param $key
     * @param $title
     * @param $desc
     * @param array $validates
     * @return Step
     */
    public function add($key, $title, $desc, array $validates = [])
    {
        return $this->steps[$key] = new Step($this, $key, $title, $desc, $validates);
    }

    /**
     * Setar step atual.
     * @param $current
     * @return bool
     */
    public function setCurrent($current)
    {
        $this->current = null;

        if (! $this->exists($current)) {
            return false;
        }

        $this->current = $this->steps[$current];

        return true;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->steps;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->steps);
    }

    /**
     * Step atual.
     * @return Step
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * @param $stepId
     * @return bool
     */
    public function exists($stepId)
    {
        return array_key_exists($stepId, $this->steps);
    }

    /**
     * @return string
     */
    public function firstId()
    {
        return array_keys($this->steps)[0];
    }

    /**
     * @param $stepId
     * @return Step
     */
    public function get($stepId)
    {
        return $this->steps[$stepId];
    }
}