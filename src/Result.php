<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

/**
 * Class Result
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
interface Result
{
    const INTERFACE_NAME = __CLASS__;

    /**
     * @return bool
     */
    public function isWin();

    /**
     * @return bool
     */
    public function isDraw();

    /**
     * @return null|Player
     *
     * @throws \RuntimeException
     */
    public function getWinner();
}
 