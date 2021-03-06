<?php
/**
 * This file is part of phpswitch.
 *
 * (c) Julien Bianchi <contact@jubianchi.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jubianchi\PhpSwitch\PHP\Option\With;

use Symfony\Component\Console\Input\InputOption;

class ReadlineOption extends WithOption
{
    const ARG = 'readline';
    const MODE = InputOption::VALUE_OPTIONAL;
}
