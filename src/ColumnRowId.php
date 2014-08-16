<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

/**
 * Class CellId
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class ColumnRowId implements CellId
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string  $column
     * @param integer $row
     */
    public function __construct($column, $row)
    {
        $this->value = $column . ',' . $row;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return strtolower($this->value);
    }
}
 