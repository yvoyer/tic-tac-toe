<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Display;

/**
 * Class Display
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Display
 */
interface Display
{
    public function setNorthWestCell($token);
    public function setWestCell($token);
    public function setSouthWestCell($token);
    public function setNorthCell($token);
    public function setCenterCell($token);
    public function setSouthCell($token);
    public function setNorthEastCell($token);
    public function setEastCell($token);
    public function setSouthEastCell($token);
    public function render();
}
 