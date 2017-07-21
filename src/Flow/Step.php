<?php namespace Bugotech\Db\Flow;

class Step
{
    /**
     * @var Steps
     */
    protected $steps;

    /**
     * @var string
     */
    public $key = '';

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var string
     */
    public $desc = '';

    /**
     * @var array
     */
    public $validates = [];

    /**
     * @param $key
     * @param $title
     * @param $desc
     */
    public function __construct($steps, $key, $title, $desc, array $validates = [])
    {
        $this->steps = $steps;
        $this->key = $key;
        $this->title = $title;
        $this->desc = $desc;
        $this->validates = $validates;
    }

    /**
     * Retorna se este step esta ativo.
     * @return bool
     */
    public function isActive()
    {
        $curr = $this->steps->current();
        if (is_null($curr)) {
            return false;
        }

        return $curr->key == $this->key;
    }

    /**
     * Próximo passo.
     *
     * @return Step|null
     */
    public function next()
    {
        $keys = array_keys($this->steps->all());
        $i = array_search($this->key, $keys);

        if (is_null($i)) {
            return;
        }
        if (! isset($keys[$i + 1])) {
            return;
        }

        return $this->steps->get($keys[$i + 1]);
    }

    /**
     * Passo anterior.
     *
     * @return Step|null
     */
    public function back()
    {
        $keys = array_keys($this->steps->all());
        $i = array_search($this->key, $keys);

        if (is_null($i)) {
            return;
        }
        if (! isset($keys[$i - 1])) {
            return;
        }

        return $this->steps->get($keys[$i - 1]);
    }
}