<?php
/**
 * This file is part of phpswitch.
 *
 * (c) Julien Bianchi <contact@jubianchi.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jubianchi\PhpSwitch\PHP\Option;

class EnableAllOption extends Option
{
    const ARG = 'enable-all';
    const ALIAS = '--enable-all';
    const DESC = 'Enables all <comment>(--enable-all)</comment>';
}
