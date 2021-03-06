<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Display;

/**
 * Class TesterDisplay
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Display
 */
class TesterDisplay implements Display
{
    private $northWest;
    private $west;
    private $southWest;
    private $north;
    private $center;
    private $south;
    private $northEast;
    private $east;
    private $southEast;

    public function setNorthWestCell($token)
    {
        $this->northWest = $token;
    }

    public function setWestCell($token)
    {
        $this->west = $token;
    }

    public function setSouthWestCell($token)
    {
        $this->southWest = $token;
    }

    public function setNorthCell($token)
    {
        $this->north = $token;
    }

    public function setCenterCell($token)
    {
        $this->center = $token;
    }

    public function setSouthCell($token)
    {
        $this->south = $token;
    }

    public function setNorthEastCell($token)
    {
        $this->northEast = $token;
    }

    public function setEastCell($token)
    {
        $this->east = $token;
    }

    public function setSouthEastCell($token)
    {
        $this->southEast = $token;
    }

    public function render()
    {
    }

    /**
     * Returns the Center.
     *
     * @return mixed
     */
    public function getCenterCell()
    {
        return $this->center;
    }

    /**
     * Returns the East.
     *
     * @return mixed
     */
    public function getEastCell()
    {
        return $this->east;
    }

    /**
     * Returns the NorthEast.
     *
     * @return mixed
     */
    public function getNorthEastCell()
    {
        return $this->northEast;
    }

    /**
     * Returns the North.
     *
     * @return mixed
     */
    public function getNorthCell()
    {
        return $this->north;
    }

    /**
     * Returns the NorthWest.
     *
     * @return mixed
     */
    public function getNorthWestCell()
    {
        return $this->northWest;
    }

    /**
     * Returns the South.
     *
     * @return mixed
     */
    public function getSouthCell()
    {
        return $this->south;
    }

    /**
     * Returns the SouthEast.
     *
     * @return mixed
     */
    public function getSouthEastCell()
    {
        return $this->southEast;
    }

    /**
     * Returns the West.
     *
     * @return mixed
     */
    public function getWestCell()
    {
        return $this->west;
    }

    /**
     * Returns the SouthWest.
     *
     * @return mixed
     */
    public function getSouthWestCell()
    {
        return $this->southWest;
    }
}
 