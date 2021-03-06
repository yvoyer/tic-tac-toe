<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Grid;

use Star\TicTacToe\Id\CellId;
use Star\TicTacToe\Id\ColumnRowId;
use Star\TicTacToe\Display\Display;
use Star\TicTacToe\Player;

/**
 * Class ColumnRowGrid
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Grid
 */
class ColumnRowGrid extends CellGrid
{
    /**
     * @return array
     */
    protected function getCellMapping()
    {
        return array(
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
    }

    /**
     * @param string $string
     *
     * @throws \InvalidArgumentException
     * @return CellId
     */
    public function createId($string)
    {
        if (!preg_match('/([abc]),([123])/', $string)) {
            throw new \InvalidArgumentException('The id must be of format X,Y.');
        }
        $aStr = explode(',', $string);

        return new ColumnRowId($aStr[0], $aStr[1]);
    }

    /**
     * @return CellId
     */
    protected function getNorthWestCellId()
    {
        return $this->createId('a,1');
    }

    /**
     * @return CellId
     */
    protected function getWestCellId()
    {
        return $this->createId('a,2');
    }

    /**
     * @return CellId
     */
    protected function getSouthWestCellId()
    {
        return $this->createId('a,3');
    }

    /**
     * @return CellId
     */
    protected function getNorthCellId()
    {
        return $this->createId('b,1');
    }

    /**
     * @return CellId
     */
    protected function getCenterCellId()
    {
        return $this->createId('b,2');
    }

    /**
     * @return CellId
     */
    protected function getSouthCellId()
    {
        return $this->createId('b,3');
    }

    /**
     * @return CellId
     */
    protected function getNorthEastCellId()
    {
        return $this->createId('c,1');
    }

    /**
     * @return CellId
     */
    protected function getEastCellId()
    {
        return $this->createId('c,2');
    }

    /**
     * @return CellId
     */
    protected function getSouthEastCellId()
    {
        return $this->createId('c,3');
    }
}
