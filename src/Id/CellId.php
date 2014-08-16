<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Id;

/**
 * Class CellId
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Id
 */
interface CellId
{
    const CLASS_NAME = __CLASS__;

    /**
     * @return string
     */
    public function getValue();
}
 