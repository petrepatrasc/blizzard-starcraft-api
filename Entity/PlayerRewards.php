<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;


class PlayerRewards
{

    /**
     * @var array
     */
    protected $selected = array();

    /**
     * @var array
     */
    protected $earned = array();

    /**
     * @param array $earned
     * @return $this
     */
    public function setEarned($earned)
    {
        $this->earned = $earned;
        return $this;
    }

    /**
     * @return array
     */
    public function getEarned()
    {
        return $this->earned;
    }

    /**
     * @param array $selected
     * @return $this
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;
        return $this;
    }

    /**
     * @return array
     */
    public function getSelected()
    {
        return $this->selected;
    }


}