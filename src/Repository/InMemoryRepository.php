<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Repository;

use Star\TicTacToe\Game;
use Star\TicTacToe\Player;

/**
 * Class InMemoryRepository
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Repository
 */
class InMemoryRepository
{
    /**
     * @var Player[]
     */
    private $players = array();

    /**
     * @var Game
     */
    private $game;

    /**
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    /**
     * @param $name
     *
     * @return null|Player
     */
    public function findPlayer($name)
    {
        foreach ($this->players as $player) {
            if ($player->getName() === $name) {
                return $player;
            }
        }

        return null;
    }

    /**
     * Returns the Game.
     *
     * @return \Star\TicTacToe\Game
     */
    public function getGame()
    {
        return $this->game;
    }
}
 