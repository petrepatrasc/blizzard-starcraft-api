<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;


class Match
{

    /**
     * @var string
     */
    protected $map;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $decision;

    /**
     * @var string
     */
    protected $speed;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $decision
     * @return $this
     */
    public function setDecision($decision)
    {
        $this->decision = $decision;
        return $this;
    }

    /**
     * @return string
     */
    public function getDecision()
    {
        return $this->decision;
    }

    /**
     * @param string $map
     * @return $this
     */
    public function setMap($map)
    {
        $this->map = $map;
        return $this;
    }

    /**
     * @return string
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param string $speed
     * @return $this
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


}