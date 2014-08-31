<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Grid;

use Star\TicTacToe\Display\Display;
use Star\TicTacToe\Id\CellId;
use Star\TicTacToe\Player;

/**
 * Class CellGrid
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Grid
 */
abstract class CellGrid implements Grid
{
    /**
     * @var string
     */
    private $winningToken = '';

    /**
     * @var array
     */
    private $cells = array();

    public function __construct()
    {
        $this->cells = $this->getCellMapping();
    }

    /**
     * @return array
     */
    protected abstract function getCellMapping();

    /**
     * @param CellId $cellId
     * @param Player $player
     *
     * @throws \RuntimeException
     */
    public function play(CellId $cellId, Player $player)
    {
        if (false === empty($this->cells[$this->getCellIndex($cellId)])) {
            throw new \RuntimeException('The cell already has a token.');
        }

        $token = $player->getToken();
        $this->cells[$this->getCellIndex($cellId)] = $token;

        if ($this->hasLine()) {
            $this->winningToken = $token;
        }
    }

    /**
     * @param Display $display
     */
    public function render(Display $display)
    {
        $display->setNorthWestCell($this->get($this->getNorthWestCellId()));
        $display->setWestCell($this->get($this->getWestCellId()));
        $display->setSouthWestCell($this->get($this->getSouthWestCellId()));
        $display->setNorthCell($this->get($this->getNorthCellId()));
        $display->setCenterCell($this->get($this->getCenterCellId()));
        $display->setSouthCell($this->get($this->getSouthCellId()));
        $display->setNorthEastCell($this->get($this->getNorthEastCellId()));
        $display->setEastCell($this->get($this->getEastCellId()));
        $display->setSouthEastCell($this->get($this->getSouthEastCellId()));
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
     * @return bool
     */
    public function isFull()
    {
        $emptyCellCount = 0;
        foreach ($this->cells as $cell) {
            if (empty($cell)) {
                $emptyCellCount ++;
            }
        }

        return $emptyCellCount == 0;
    }

    /**
     * @return CellId
     */
    protected abstract function getNorthWestCellId();

    /**
     * @return CellId
     */
    protected abstract function getWestCellId();

    /**
     * @return CellId
     */
    protected abstract function getSouthWestCellId();

    /**
     * @return CellId
     */
    protected abstract function getNorthCellId();

    /**
     * @return CellId
     */
    protected abstract function getCenterCellId();

    /**
     * @return CellId
     */
    protected abstract function getSouthCellId();

    /**
     * @return CellId
     */
    protected abstract function getNorthEastCellId();

    /**
     * @return CellId
     */
    protected abstract function getEastCellId();

    /**
     * @return CellId
     */
    protected abstract function getSouthEastCellId();

    /**
     * @param CellId $cell1
     * @param CellId $cell2
     * @param CellId $cell3
     *
     * @return bool
     */
    private function isWinningLine(CellId $cell1, CellId $cell2, CellId $cell3)
    {
        $cell1Content = $this->get($cell1);
        $cell2Content = $this->get($cell2);
        $cell3Content = $this->get($cell3);

        if (false === empty($cell1Content) && false === empty($cell2Content) && false === empty($cell3Content)) {
            if ($cell1Content == $cell2Content && $cell2Content == $cell3Content) {
                return true;
            }
        }

        return false;
    }

    private function hasDiagonalLine()
    {
        if ($this->isWinningLine($this->getNorthWestCellId(), $this->getCenterCellId(), $this->getSouthEastCellId())) {
            return true;
        }

        if ($this->isWinningLine($this->getNorthEastCellId(), $this->getCenterCellId(), $this->getSouthWestCellId())) {
            return true;
        }

        return false;
    }

    private function hasHorizontalLine()
    {
        if ($this->isWinningLine($this->getNorthWestCellId(), $this->getNorthCellId(), $this->getNorthEastCellId())) {
            return true;
        }

        if ($this->isWinningLine($this->getWestCellId(), $this->getCenterCellId(), $this->getEastCellId())) {
            return true;
        }

        if ($this->isWinningLine($this->getSouthWestCellId(), $this->getSouthCellId(), $this->getSouthEastCellId())) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function hasVerticalLine()
    {
        if ($this->isWinningLine($this->getNorthWestCellId(), $this->getWestCellId(), $this->getSouthWestCellId())) {
            return true;
        }

        if ($this->isWinningLine($this->getNorthCellId(), $this->getCenterCellId(), $this->getSouthCellId())) {
            return true;
        }

        if ($this->isWinningLine($this->getNorthEastCellId(), $this->getEastCellId(), $this->getSouthEastCellId())) {
            return true;
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
 