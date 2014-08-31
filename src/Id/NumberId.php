<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Id;

/**
 * Class NumberId
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Id
 */
class NumberId implements CellId
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        $acceptedValues = range(1, 9);
        if (false === in_array($value, $acceptedValues) || false === is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be int between 1-9.');
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return (int) $this->value;
    }
}
 