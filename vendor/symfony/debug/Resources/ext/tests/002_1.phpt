--TEST--
Test symfony_debug_backtrace in case of non fatal error
--SKIPIF--
<<<<<<< HEAD
<?php if (!extension_loaded('symfony_debug')) {
    echo 'skip';
} ?>
=======
<?php if (!extension_loaded("symfony_debug")) print "skip"; ?>
>>>>>>> web and vendor directory from composer install
--FILE--
<?php

function bar()
{
    bt();
}

function bt()
{
    print_r(symfony_debug_backtrace());
<<<<<<< HEAD
=======

>>>>>>> web and vendor directory from composer install
}

bar();

?>
--EXPECTF--
Array
(
    [0] => Array
        (
            [file] => %s
            [line] => %d
            [function] => bt
            [args] => Array
                (
                )

        )

    [1] => Array
        (
            [file] => %s
            [line] => %d
            [function] => bar
            [args] => Array
                (
                )

        )

)
