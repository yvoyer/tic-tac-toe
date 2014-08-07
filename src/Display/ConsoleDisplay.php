<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Display;

use Star\TicTacToe\Display;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsoleDisplay
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Display
 */
class ConsoleDisplay implements Display
{
    /**
     * @var \Symfony\Component\Console\Output\ConsoleOutput
     */
    private $output;

    /**
     * @var array
     */
    private $cells = array();

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output = null)
    {
        if (null === $output) {
            $output = new ConsoleOutput();
        }

        $this->output = $output;
    }

    public function setA1($token)
    {
        $this->cells[1][1] = $token;
    }

    public function setA2($token)
    {
        $this->cells[1][2] = $token;
    }

    public function setA3($token)
    {
        $this->cells[1][3] = $token;
    }

    public function setB1($token)
    {
        $this->cells[2][1] = $token;
    }

    public function setB2($token)
    {
        $this->cells[2][2] = $token;
    }

    public function setB3($token)
    {
        $this->cells[2][3] = $token;
    }

    public function setC1($token)
    {
        $this->cells[3][1] = $token;
    }

    public function setC2($token)
    {
        $this->cells[3][2] = $token;
    }

    public function setC3($token)
    {
        $this->cells[3][3] = $token;
    }

    public function render()
    {
        $this->output->writeln('-------------');

        foreach ($this->cells as $row => $cols) {
            $strRow = '|';
            foreach ($cols as $col => $token) {
                if (empty($token)) {
                    $token = ' ';
                }
                $strRow .= ' ' . $token . ' |';
            }

            $this->output->writeln($strRow);
        }

        $this->output->writeln('-------------');
    }
}
 