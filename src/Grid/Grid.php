<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Grid;

use Star\TicTacToe\Id\CellId;
use Star\TicTacToe\Display\Display;
use Star\TicTacToe\Player;

/**
 * Class Grid
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Grid
 */
interface Grid
{
    const CLASS_NAME = __CLASS__;

    /**
     * @param CellId $cellId
     * @param Player $player
     */
    public function play(CellId $cellId, Player $player);

    /**
     * @param Display $display
     */
    public function render(Display $display);

    /**
     * Returns whether an horizontal/vertical/diagonal line is filled with the same token.
     *
     * @return bool
     */
    public function hasLine();

    /**
     * @return string
     */
    public function getWinningToken();

    /**
     * @param string $string
     *
     * @return CellId
     */
    public function createId($string);

    /**
     * @return bool
     */
    public function isFull();
}
 