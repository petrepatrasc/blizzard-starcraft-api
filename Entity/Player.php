<?php

namespace petrepatrasc\BlizzardApiBundle\Entity;

/**
 * Class holds a representation of a player's profile.
 * @package petrepatrasc\BlizzardApiBundle\Entities
 */
class Player
{

    /**
     * Battle.NET ID
     *
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $realm;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $clanName;

    /**
     * @var string
     */
    protected $clanTag;

    /**
     * @var string
     */
    protected $profilePath;

    /**
     * @param string $clanName
     * @return $this
     */
    public function setClanName($clanName)
    {
        $this->clanName = $clanName;
        return $this;
    }

    /**
     * @return string
     */
    public function getClanName()
    {
        return $this->clanName;
    }

    /**
     * @param string $clanTag
     * @return $this
     */
    public function setClanTag($clanTag)
    {
        $this->clanTag = $clanTag;
        return $this;
    }

    /**
     * @return string
     */
    public function getClanTag()
    {
        return $this->clanTag;
    }

    /**
     * @param string $displayName
     * @return $this
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $profilePath
     * @return $this
     */
    public function setProfilePath($profilePath)
    {
        $this->profilePath = $profilePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfilePath()
    {
        return $this->profilePath;
    }

    /**
     * @param int $realm
     * @return $this
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;
        return $this;
    }

    /**
     * @return int
     */
    public function getRealm()
    {
        return $this->realm;
    }


}