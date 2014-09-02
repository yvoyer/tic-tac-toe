<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Grid;

use Star\TicTacToe\Id\NumberId;
use Star\TicTacToe\Id\CellId;

/**
 * Class NumberGrid
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Grid
 */
class NumberGrid extends CellGrid
{
    protected function getCellMapping()
    {
        return array(
            '1' => '',
            '2' => '',
            '3' => '',
            '4' => '',
            '5' => '',
            '6' => '',
            '7' => '',
            '8' => '',
            '9' => '',
        );
    }

    /**
     * @return CellId
     */
    protected function getNorthWestCellId()
    {
        return $this->createId(1);
    }

    /**
     * @return CellId
     */
    protected function getWestCellId()
    {
        return $this->createId(4);
    }

    /**
     * @return CellId
     */
    protected function getSouthWestCellId()
    {
        return $this->createId(7);
    }

    /**
     * @return CellId
     */
    protected function getNorthCellId()
    {
        return $this->createId(2);
    }

    /**
     * @return CellId
     */
    protected function getCenterCellId()
    {
        return $this->createId(5);
    }

    /**
     * @return CellId
     */
    protected function getSouthCellId()
    {
        return $this->createId(8);
    }

    /**
     * @return CellId
     */
    protected function getNorthEastCellId()
    {
        return $this->createId(3);
    }

    /**
     * @return CellId
     */
    protected function getEastCellId()
    {
        return $this->createId(6);
    }

    /**
     * @return CellId
     */
    protected function getSouthEastCellId()
    {
        return $this->createId(9);
    }

    /**
     * @param string $string
     *
     * @return CellId
     */
    public function createId($string)
    {
        return new NumberId($string);
    }

    /**
     * Returns the content of the cell
     *
     * @param CellId $cellId
     *
     * @return mixed
     */
    protected function get(CellId $cellId)
    {
        $content = parent::get($cellId);
        if (empty($content)) {
            $content = $cellId->getValue();
        }

        return $content;
    }
}
 