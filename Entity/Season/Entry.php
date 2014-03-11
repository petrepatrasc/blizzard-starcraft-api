<?php

namespace petrepatrasc\BlizzardApiBundle\Entity\Season;

class Entry
{

    /**
     * @var array
     */
    protected $ladderInformation;

    /**
     * @var array
     */
    protected $characters;

    /**
     * @var array
     */
    protected $nonRanked;

    /**
     * @param array $characters
     * @return $this
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;
        return $this;
    }

    /**
     * @return array
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param array $ladderInformation
     * @return $this
     */
    public function setLadderInformation($ladderInformation)
    {
        $this->ladderInformation = $ladderInformation;
        return $this;
    }

    /**
     * @return array $ladderInformation
     */
    public function getLadderInformation()
    {
        return $this->ladderInformation;
    }

    /**
     * @param array $nonRanked
     * @return $this
     */
    public function setNonRanked($nonRanked)
    {
        $this->nonRanked = $nonRanked;
        return $this;
    }

    /**
     * @return array
     */
    public function getNonRanked()
    {
        return $this->nonRanked;
    }


}