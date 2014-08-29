<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

use Star\TicTacToe\Grid\Grid;

/**
 * Class GameResult
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class GameResult implements Result
{
    /**
     * @var Grid
     */
    private $grid;

    /**
     * @var Player
     */
    private $player1;

    /**
     * @var Player
     */
    private $player2;

    /**
     * @var Game
     */
    private $game;

    /**
     * @param Grid   $grid
     * @param Player $player1
     * @param Player $player2
     * @param Game   $game
     */
    public function __construct(Grid $grid, Player $player1, Player $player2, Game $game)
    {
        $this->grid = $grid;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->game = $game;
    }

    /**
     * @return bool
     */
    public function isWin()
    {
        return $this->hasWinner() && $this->game->isFinished();
    }

    /**
     * @return bool
     */
    public function isDraw()
    {
        return ! $this->hasWinner() && $this->game->isFinished();
    }

    /**
     * @return null|Player
     *
     * @throws \RuntimeException
     */
    public function getWinner()
    {
        $winningToken = $this->grid->getWinningToken();
        if ($this->player1->getToken() == $winningToken) {
            return $this->player1;
        } else if ($this->player2->getToken() == $winningToken) {
            return $this->player2;
        } else if (false === empty($winningToken)) {
            throw new \RuntimeException("The token '{$winningToken}' is not owned by any player.");
        }

        return null;
    }

    /**
     * @return bool
     */
    private function hasWinner()
    {
        return (bool) $this->getWinner();
    }
}
 