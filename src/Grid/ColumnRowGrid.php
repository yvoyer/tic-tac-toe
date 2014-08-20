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
class ColumnRowGrid implements Grid
{
    /**
     * @var string
     */
    private $winningToken;

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

    /**
     * @param CellId $id
     * @param Player $player
     *
     * @throws \RuntimeException
     */
    public function play(CellId $id, Player $player)
    {
        if (false === empty($this->cells[$this->getCellIndex($id)])) {
            throw new \RuntimeException('The cell already has a token.');
        }

        $token = $player->getToken();
        $this->cells[$this->getCellIndex($id)] = $token;

        if ($this->hasLine()) {
            $this->winningToken = $token;
        }
    }

    /**
     * @param Display $display
     */
    public function render(Display $display)
    {
        $display->setNorthWestCell($this->get(new ColumnRowId('a', 1)));
        $display->setWestCell($this->get(new ColumnRowId('a', 2)));
        $display->setSouthWestCell($this->get(new ColumnRowId('a', 3)));
        $display->setNorthCell($this->get(new ColumnRowId('b', 1)));
        $display->setCenterCell($this->get(new ColumnRowId('b', 2)));
        $display->setSouthCell($this->get(new ColumnRowId('b', 3)));
        $display->setNorthEastCell($this->get(new ColumnRowId('c', 1)));
        $display->setEastCell($this->get(new ColumnRowId('c', 2)));
        $display->setSouthEastCell($this->get(new ColumnRowId('c', 3)));
        $display->render();
    }

    /**
     * Returns whether an horizontal line is filled with the same token.
     *
     * @return bool
     */
    public function hasLine()
    {
        return $this->hasHorizontalLine() || $this->hasVerticalLine() || $this->hasDiagonalLine();
    }

    /**
     * @return string
     */
    public function getWinningToken()
    {
        return $this->winningToken;
    }

    /**
     * @param string $string
     *
     * @throws \InvalidArgumentException
     * @return CellId
     */
    public function createId($string)
    {
        if (! preg_match('/([abc]),([123])/', $string)) {
            throw new \InvalidArgumentException('The id must be of format X,Y.');
        }
        $aStr = explode(',', $string);

        return new ColumnRowId($aStr[0], $aStr[1]);
    }

    private function hasDiagonalLine()
    {
        $cell1 = $this->get(new ColumnRowId('a', 1));
        $cell2 = $this->get(new ColumnRowId('b', 2));
        $cell3 = $this->get(new ColumnRowId('c', 3));

        if (false === empty($cell1) && false === empty($cell2) && false === empty($cell3)) {
            if ($cell1 == $cell2 && $cell2 == $cell3) {
                return true;
            }
        }

        $cell1 = $this->get(new ColumnRowId('a', 3));
        $cell2 = $this->get(new ColumnRowId('b', 2));
        $cell3 = $this->get(new ColumnRowId('c', 1));
        if (false === empty($cell1) && false === empty($cell2) && false === empty($cell3)) {
            if ($cell1 == $cell2 && $cell2 == $cell3) {
                return true;
            }
        }

        return false;
    }

    private function hasHorizontalLine()
    {
        $rows = array(1,2,3);
        foreach ($rows as $row) {
            $col1 = $this->get(new ColumnRowId('a', $row));
            $col2 = $this->get(new ColumnRowId('b', $row));
            $col3 = $this->get(new ColumnRowId('c', $row));

            if (false === empty($col1) && false === empty($col2) && false === empty($col3)) {
                if ($col1 == $col2 && $col2 == $col3) {
                    return true;
                }
            }
        }

        return false;
    }

    private function hasVerticalLine()
    {
        $cols = array('a', 'b', 'c');
        foreach ($cols as $col) {
            $row1 = $this->get(new ColumnRowId($col, 1));
            $row2 = $this->get(new ColumnRowId($col, 2));
            $row3 = $this->get(new ColumnRowId($col, 3));

            if (false === empty($row1) && false === empty($row2) && false === empty($row3)) {
                if ($row1 == $row2 && $row2 == $row3) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Returns the content of the cell
     *
     * @param CellId $cellId
     *
     * @return mixed
     */
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
        $index = $id->getValue();
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
