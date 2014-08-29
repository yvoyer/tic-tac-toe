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

    public function start(Player $startPlayer)
    {
        $this->currentPlayer = $startPlayer;
    }

    private function isStarted()
    {
        return null !== $this->currentPlayer;
    }

    /**
     * @param CellId $cellId
     *
     * @return Result
     */
    public function playTurn(CellId $cellId)
    {
        $this->guardAgainstNotStartedGame();
        $this->guardAgainstWrongPlayer($this->currentPlayer);
        $this->guardAgainstFinishedGrid();
        $this->grid->play($cellId, $this->currentPlayer);
        $this->endTurn();

        return new GameResult($this->grid, $this->player1, $this->player2, $this);
    }

    private function endTurn()
    {
        if ($this->currentPlayer->equals($this->player1)) {
            $this->currentPlayer = $this->player2;
        } else {
            $this->currentPlayer = $this->player1;
        }
    }

    /**
     * @param Display $display
     */
    public function render(Display $display)
    {
        $this->grid->render($display);
    }

    /**
     * @return Player
     */
    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return (bool) $this->grid->hasLine() || $this->grid->isFull();
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

    private function guardAgainstFinishedGrid()
    {
        if ($this->grid->hasLine()) {
            throw new \RuntimeException('The game is finished since the grid has a line.');
        }
    }

    private function guardAgainstNotStartedGame()
    {
        if (false === $this->isStarted()) {
            throw new \RuntimeException('The game is not yet started.');
        }
    }

    private function guardAgainstGameNotFinished()
    {
        if (false === $this->isFinished()) {
            throw new \RuntimeException('The game is not yet finished.');
        }
    }
}
 