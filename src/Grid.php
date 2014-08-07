<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

use Traversable;

/**
 * Class Grid
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class Grid
{
    const CLASS_NAME = __CLASS__;

    private $cells = array(
        'a,1' => '',
        'a,2' => '',
        'a,3' => '',
        'b,1' => '',
        'b,2' => '',
        'b,3' => '',
        'c,1' => '',
        'c,2' => '',
        'c,3' => '',
    );

    public function play(CellId $id, Player $player)
    {
        $this->cells[$this->getCellIndex($id)] = $player->getToken();
    }

    /**
     * @param Display $display
     */
    public function render(Display $display)
    {
        $display->setA1($this->get(new CellId('a', 1)));
        $display->setA2($this->get(new CellId('a', 2)));
        $display->setA3($this->get(new CellId('a', 3)));
        $display->setB1($this->get(new CellId('b', 1)));
        $display->setB2($this->get(new CellId('b', 2)));
        $display->setB3($this->get(new CellId('b', 3)));
        $display->setC1($this->get(new CellId('c', 1)));
        $display->setC2($this->get(new CellId('c', 2)));
        $display->setC3($this->get(new CellId('c', 3)));
    }

    private function get(CellId $cellId)
    {
        return $this->cells[$this->getCellIndex($cellId)];
    }

    /**
     * @param CellId $id
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    private function getCellIndex(CellId $id)
    {
        $index = (string)$id;
        $this->guardAgainstInvalidCell($index);
        return $index;
    }

    /**
     * @param $index
     * @throws \InvalidArgumentException
     */
    private function guardAgainstInvalidCell($index)
    {
        if (false === array_key_exists($index, $this->cells)) {
            throw new \InvalidArgumentException("The cell id '{$index}' is not found.");
        }
    }
}
