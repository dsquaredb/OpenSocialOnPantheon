<?php
/**
 * Random_* Compatibility Library
 * for using the new PHP 7 random_* API in PHP 5 projects
 *
 * The MIT License (MIT)
 *
<<<<<<< HEAD
 * Copyright (c) 2015 - 2017 Paragon Initiative Enterprises
=======
 * Copyright (c) 2015 Paragon Initiative Enterprises
>>>>>>> web and vendor directory from composer install
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

<<<<<<< HEAD
if (!is_callable('RandomCompat_strlen')) {
=======
if (!function_exists('RandomCompat_strlen')) {
>>>>>>> web and vendor directory from composer install
    if (
        defined('MB_OVERLOAD_STRING') &&
        ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING
    ) {
        /**
         * strlen() implementation that isn't brittle to mbstring.func_overload
         *
         * This version uses mb_strlen() in '8bit' mode to treat strings as raw
         * binary rather than UTF-8, ISO-8859-1, etc
         *
         * @param string $binary_string
         *
         * @throws TypeError
         *
         * @return int
         */
        function RandomCompat_strlen($binary_string)
        {
            if (!is_string($binary_string)) {
                throw new TypeError(
                    'RandomCompat_strlen() expects a string'
                );
            }

<<<<<<< HEAD
            return (int) mb_strlen($binary_string, '8bit');
=======
            return mb_strlen($binary_string, '8bit');
>>>>>>> web and vendor directory from composer install
        }

    } else {
        /**
         * strlen() implementation that isn't brittle to mbstring.func_overload
         *
         * This version just used the default strlen()
         *
         * @param string $binary_string
         *
         * @throws TypeError
         *
         * @return int
         */
        function RandomCompat_strlen($binary_string)
        {
            if (!is_string($binary_string)) {
                throw new TypeError(
                    'RandomCompat_strlen() expects a string'
                );
            }
<<<<<<< HEAD
            return (int) strlen($binary_string);
=======
            return strlen($binary_string);
>>>>>>> web and vendor directory from composer install
        }
    }
}

<<<<<<< HEAD
if (!is_callable('RandomCompat_substr')) {
=======
if (!function_exists('RandomCompat_substr')) {
>>>>>>> web and vendor directory from composer install

    if (
        defined('MB_OVERLOAD_STRING')
        &&
        ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING
    ) {
        /**
         * substr() implementation that isn't brittle to mbstring.func_overload
         *
         * This version uses mb_substr() in '8bit' mode to treat strings as raw
         * binary rather than UTF-8, ISO-8859-1, etc
         *
         * @param string $binary_string
         * @param int $start
         * @param int $length (optional)
         *
         * @throws TypeError
         *
         * @return string
         */
        function RandomCompat_substr($binary_string, $start, $length = null)
        {
            if (!is_string($binary_string)) {
                throw new TypeError(
                    'RandomCompat_substr(): First argument should be a string'
                );
            }

            if (!is_int($start)) {
                throw new TypeError(
                    'RandomCompat_substr(): Second argument should be an integer'
                );
            }

            if ($length === null) {
                /**
                 * mb_substr($str, 0, NULL, '8bit') returns an empty string on
                 * PHP 5.3, so we have to find the length ourselves.
                 */
<<<<<<< HEAD
                $length = RandomCompat_strlen($binary_string) - $start;
=======
                $length = RandomCompat_strlen($length) - $start;
>>>>>>> web and vendor directory from composer install
            } elseif (!is_int($length)) {
                throw new TypeError(
                    'RandomCompat_substr(): Third argument should be an integer, or omitted'
                );
            }

<<<<<<< HEAD
            // Consistency with PHP's behavior
            if ($start === RandomCompat_strlen($binary_string) && $length === 0) {
                return '';
            }
            if ($start > RandomCompat_strlen($binary_string)) {
                return '';
            }

            return (string) mb_substr($binary_string, $start, $length, '8bit');
=======
            return mb_substr($binary_string, $start, $length, '8bit');
>>>>>>> web and vendor directory from composer install
        }

    } else {

        /**
         * substr() implementation that isn't brittle to mbstring.func_overload
         *
         * This version just uses the default substr()
         *
         * @param string $binary_string
         * @param int $start
         * @param int $length (optional)
         *
         * @throws TypeError
         *
         * @return string
         */
        function RandomCompat_substr($binary_string, $start, $length = null)
        {
            if (!is_string($binary_string)) {
                throw new TypeError(
                    'RandomCompat_substr(): First argument should be a string'
                );
            }

            if (!is_int($start)) {
                throw new TypeError(
                    'RandomCompat_substr(): Second argument should be an integer'
                );
            }

            if ($length !== null) {
                if (!is_int($length)) {
                    throw new TypeError(
                        'RandomCompat_substr(): Third argument should be an integer, or omitted'
                    );
                }

<<<<<<< HEAD
                return (string) substr($binary_string, $start, $length);
            }

            return (string) substr($binary_string, $start);
=======
                return substr($binary_string, $start, $length);
            }

            return substr($binary_string, $start);
>>>>>>> web and vendor directory from composer install
        }
    }
}
