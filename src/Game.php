<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

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
     * @param Player $player1
     * @param Player $player2
     * @param Grid   $grid
     */
    public function __construct(Player $player1, Player $player2, Grid $grid = null)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        if (null === $grid) {
            $grid = new Grid();
        }
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
        $this->grid->play($cellId, $player);

        return $this->grid;
    }

    public function render(Display $display)
    {
        $this->grid->render($display);
        $display->render();
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
}
 