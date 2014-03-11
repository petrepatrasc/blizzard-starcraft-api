<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Reward;

class Information
{

    /**
     * @var array
     */
    protected $portraits;

    /**
     * @var array
     */
    protected $terranDecals;

    /**
     * @var array
     */
    protected $zergDecals;

    /**
     * @var array
     */
    protected $protossDecals;

    /**
     * @var array
     */
    protected $skins;

    /**
     * @var array
     */
    protected $animations;

    /**
     * @param array $animations
     * @return $this
     */
    public function setAnimations($animations)
    {
        $this->animations = $animations;
        return $this;
    }

    /**
     * @return array
     */
    public function getAnimations()
    {
        return $this->animations;
    }

    /**
     * @param array $portraits
     * @return $this
     */
    public function setPortraits($portraits)
    {
        $this->portraits = $portraits;
        return $this;
    }

    /**
     * @return array
     */
    public function getPortraits()
    {
        return $this->portraits;
    }

    /**
     * @param array $protossDecals
     * @return $this
     */
    public function setProtossDecals($protossDecals)
    {
        $this->protossDecals = $protossDecals;
        return $this;
    }

    /**
     * @return array
     */
    public function getProtossDecals()
    {
        return $this->protossDecals;
    }

    /**
     * @param array $skins
     * @return $this
     */
    public function setSkins($skins)
    {
        $this->skins = $skins;
        return $this;
    }

    /**
     * @return array
     */
    public function getSkins()
    {
        return $this->skins;
    }

    /**
     * @param array $terranDecals
     * @return $this
     */
    public function setTerranDecals($terranDecals)
    {
        $this->terranDecals = $terranDecals;
        return $this;
    }

    /**
     * @return array
     */
    public function getTerranDecals()
    {
        return $this->terranDecals;
    }

    /**
     * @param array $zergDecals
     * @return $this
     */
    public function setZergDecals($zergDecals)
    {
        $this->zergDecals = $zergDecals;
        return $this;
    }

    /**
     * @return array
     */
    public function getZergDecals()
    {
        return $this->zergDecals;
    }


}