<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

/**
 * Class Player
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class Player
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $token
     * @param string $name
     */
    public function __construct($token, $name)
    {
        $this->token = $token;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param Player $player
     *
     * @return bool
     */
    public function equals(Player $player)
    {
        return $this == $player;
    }

    /**
     * Returns the Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
 