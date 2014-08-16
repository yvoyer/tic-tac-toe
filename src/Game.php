<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

use Star\TicTacToe\Display\Display;
use Star\TicTacToe\Grid\Grid;
use Star\TicTacToe\Id\CellId;

/**
 * Class Game
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class Game
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
     * @var Player
     */
    private $currentPlayer;

    /**
     * @param Player $player1
     * @param Player $player2
     * @param Grid   $grid
     */
    public function __construct(Player $player1, Player $player2, Grid $grid)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->grid = $grid;
    }

    /**
     * @param Player $player
     * @param CellId $cellId
     *
     * @return Grid
     */
    public function playTurn(Player $player, CellId $cellId)
    {
        $this->guardAgainstWrongPlayer($player);
        $this->guardAgainstFullGrid();
        $this->guardAgainstWrongPlayerOrder($player);
        $this->currentPlayer = $player;

        $this->grid->play($cellId, $player);

        return $this->grid;
    }

    /**
     * @param Display $display
     */
    public function render(Display $display)
    {
        $this->grid->render($display);
        $display->render();
    }

    /**
     * @return Player
     */
    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
    }

    /**
     * @param Player $player
     * @throws \InvalidArgumentException
     */
    private function guardAgainstWrongPlayer(Player $player)
    {
        if (!$player->equals($this->player1) && !$player->equals($this->player2)) {
            throw new \InvalidArgumentException('The player is not part of the game.');
        }
    }

    private function guardAgainstFullGrid()
    {
        if ($this->grid->hasLine()) {
            throw new \RuntimeException('The game is finished since the grid has a line.');
        }
    }

    /**
     * @param Player $player
     * @throws \RuntimeException
     */
    private function guardAgainstWrongPlayerOrder(Player $player)
    {
        if ($this->currentPlayer) {
            if ($this->currentPlayer->equals($player)) {
                throw new \RuntimeException('You already played, it should be the other player turn.');
            }
        }
    }
}
 