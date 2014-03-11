<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Achievements;
use petrepatrasc\BlizzardApiBundle\Entity\Player\Basic;
use petrepatrasc\BlizzardApiBundle\Entity;

/**
 * Class holds a representation of a player's profile.
 * @package petrepatrasc\BlizzardApiBundle\Entities
 */
class Player
{

    /**
     * @var Basic
     */
    protected $basicInformation;

    /**
     * @var Icon
     */
    protected $portrait;

    /**
     * @var Player\Career
     */
    protected $career;

    /**
     * @var Player\SwarmLevels
     */
    protected $swarmLevels;

    /**
     * @var Player\Campaign
     */
    protected $campaign;

    /**
     * @var Player\Season
     */
    protected $season;

    /**
     * @var Player\Rewards
     */
    protected $rewards;

    /**
     * @var Achievements
     */
    protected $achievements;

    /**
     * @param Icon $portrait
     * @return $this
     */
    public function setPortrait($portrait)
    {
        $this->portrait = $portrait;
        return $this;
    }

    /**
     * @return Icon
     */
    public function getPortrait()
    {
        return $this->portrait;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Player\Career $career
     * @return $this
     */
    public function setCareer($career)
    {
        $this->career = $career;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Career
     */
    public function getCareer()
    {
        return $this->career;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Player\SwarmLevels $swarmLevels
     * @return $this
     */
    public function setSwarmLevels($swarmLevels)
    {
        $this->swarmLevels = $swarmLevels;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\SwarmLevels
     */
    public function getSwarmLevels()
    {
        return $this->swarmLevels;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign $campaign
     * @return $this
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Player\Season $season
     * @return $this
     */
    public function setSeason($season)
    {
        $this->season = $season;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Player\Rewards $rewards
     * @return $this
     */
    public function setRewards($rewards)
    {
        $this->rewards = $rewards;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Rewards
     */
    public function getRewards()
    {
        return $this->rewards;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Player\Achievements $achievements
     * @return $this
     */
    public function setAchievements($achievements)
    {
        $this->achievements = $achievements;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Achievements
     */
    public function getAchievements()
    {
        return $this->achievements;
    }

    /**
     * @param \petrepatrasc\BlizzardApiBundle\Entity\Player\Basic $basicInformation
     * @return $this
     */
    public function setBasicInformation($basicInformation)
    {
        $this->basicInformation = $basicInformation;
        return $this;
    }

    /**
     * @return \petrepatrasc\BlizzardApiBundle\Entity\Player\Basic
     */
    public function getBasicInformation()
    {
        return $this->basicInformation;
    }


}