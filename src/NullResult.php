<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

/**
 * Class NullResult
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class NullResult implements Result
{
    /**
     * @return bool
     */
    public function isWin()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isDraw()
    {
        return false;
    }

    /**
     * @return null|Player
     *
     * @throws \RuntimeException
     */
    public function getWinner()
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }
}
 