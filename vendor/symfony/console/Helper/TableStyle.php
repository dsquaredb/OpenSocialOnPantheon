<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Defines the styles for a Table.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class TableStyle
{
    private $paddingChar = ' ';
    private $horizontalBorderChar = '-';
    private $verticalBorderChar = '|';
    private $crossingChar = '+';
    private $cellHeaderFormat = '<info>%s</info>';
    private $cellRowFormat = '%s';
    private $cellRowContentFormat = ' %s ';
    private $borderFormat = '%s';
    private $padType = STR_PAD_RIGHT;

    /**
     * Sets padding character, used for cell padding.
     *
     * @param string $paddingChar
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setPaddingChar($paddingChar)
    {
        if (!$paddingChar) {
            throw new LogicException('The padding char must not be empty');
        }

        $this->paddingChar = $paddingChar;

        return $this;
    }

    /**
     * Gets padding character, used for cell padding.
     *
     * @return string
     */
    public function getPaddingChar()
    {
        return $this->paddingChar;
    }

    /**
     * Sets horizontal border character.
     *
     * @param string $horizontalBorderChar
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setHorizontalBorderChar($horizontalBorderChar)
    {
        $this->horizontalBorderChar = $horizontalBorderChar;

        return $this;
    }

    /**
     * Gets horizontal border character.
     *
     * @return string
     */
    public function getHorizontalBorderChar()
    {
        return $this->horizontalBorderChar;
    }

    /**
     * Sets vertical border character.
     *
     * @param string $verticalBorderChar
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setVerticalBorderChar($verticalBorderChar)
    {
        $this->verticalBorderChar = $verticalBorderChar;

        return $this;
    }

    /**
     * Gets vertical border character.
     *
     * @return string
     */
    public function getVerticalBorderChar()
    {
        return $this->verticalBorderChar;
    }

    /**
     * Sets crossing character.
     *
     * @param string $crossingChar
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setCrossingChar($crossingChar)
    {
        $this->crossingChar = $crossingChar;

        return $this;
    }

    /**
     * Gets crossing character.
     *
     * @return string $crossingChar
     */
    public function getCrossingChar()
    {
        return $this->crossingChar;
    }

    /**
     * Sets header cell format.
     *
     * @param string $cellHeaderFormat
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setCellHeaderFormat($cellHeaderFormat)
    {
        $this->cellHeaderFormat = $cellHeaderFormat;

        return $this;
    }

    /**
     * Gets header cell format.
     *
     * @return string
     */
    public function getCellHeaderFormat()
    {
        return $this->cellHeaderFormat;
    }

    /**
     * Sets row cell format.
     *
     * @param string $cellRowFormat
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setCellRowFormat($cellRowFormat)
    {
        $this->cellRowFormat = $cellRowFormat;

        return $this;
    }

    /**
     * Gets row cell format.
     *
     * @return string
     */
    public function getCellRowFormat()
    {
        return $this->cellRowFormat;
    }

    /**
     * Sets row cell content format.
     *
     * @param string $cellRowContentFormat
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setCellRowContentFormat($cellRowContentFormat)
    {
        $this->cellRowContentFormat = $cellRowContentFormat;

        return $this;
    }

    /**
     * Gets row cell content format.
     *
     * @return string
     */
    public function getCellRowContentFormat()
    {
        return $this->cellRowContentFormat;
    }

    /**
     * Sets table border format.
     *
     * @param string $borderFormat
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setBorderFormat($borderFormat)
    {
        $this->borderFormat = $borderFormat;

        return $this;
    }

    /**
     * Gets table border format.
     *
     * @return string
     */
    public function getBorderFormat()
    {
        return $this->borderFormat;
    }

    /**
     * Sets cell padding type.
     *
     * @param int $padType STR_PAD_*
     *
<<<<<<< HEAD
     * @return $this
=======
     * @return TableStyle
>>>>>>> web and vendor directory from composer install
     */
    public function setPadType($padType)
    {
        if (!in_array($padType, array(STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH), true)) {
            throw new InvalidArgumentException('Invalid padding type. Expected one of (STR_PAD_LEFT, STR_PAD_RIGHT, STR_PAD_BOTH).');
        }

        $this->padType = $padType;

        return $this;
    }

    /**
     * Gets cell padding type.
     *
     * @return int
     */
    public function getPadType()
    {
        return $this->padType;
    }
}
