<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;


class Achievement
{

    /**
     * @var int
     */
    protected $achievementId;

    /**
     * @var \DateTime
     */
    protected $completionDate;

    /**
     * @param int $achievementId
     * @return $this
     */
    public function setAchievementId($achievementId)
    {
        $this->achievementId = $achievementId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAchievementId()
    {
        return $this->achievementId;
    }

    /**
     * @param \DateTime $completionDate
     * @return $this
     */
    public function setCompletionDate($completionDate)
    {
        $this->completionDate = $completionDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCompletionDate()
    {
        return $this->completionDate;
    }


}