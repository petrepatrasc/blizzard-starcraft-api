<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Reward;

class Skin extends Resource
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}