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
class GameResult
{
    const CLASS_NAME = __CLASS__;

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
     * @param Grid   $grid
     * @param Player $player1
     * @param Player $player2
     */
    public function __construct(Grid $grid, Player $player1, Player $player2)
    {
        $this->grid = $grid;
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * @return bool
     */
    public function isWin()
    {
        return (bool) $this->grid->hasLine();
    }

    /**
     * @return bool
     */
    public function isDraw()
    {
        return ! $this->isWin();
    }

    public function getWinner()
    {
        $winningToken = $this->grid->getWinningToken();
        if ($this->player1->getToken() == $winningToken) {
            return $this->player1;
        } else if ($this->player2->getToken() == $winningToken) {
            return $this->player2;
        }

        return null;
    }
}
 