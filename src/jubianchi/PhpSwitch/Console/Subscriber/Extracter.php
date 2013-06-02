<?php
/**
 * This file is part of phpswitch.
 *
 * (c) Julien Bianchi <contact@jubianchi.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jubianchi\PhpSwitch\Console\Subscriber;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Console\Helper\ProgressHelper;
use jubianchi\PhpSwitch\Event;

class Extracter extends Event\Subscriber
{
    public function __construct(OutputInterface $output, ProgressHelper $progress)
    {
        $afterCallback = function() use ($output) { $output->write(PHP_EOL); };
        $processCallback = function() use ($progress, $output) {
            $progress->advance();
        };
        $self = $this;

        $this
            ->handle('extract.before', function(GenericEvent $event) use ($self, $output, $progress) {
                $output->writeln(array(
                    sprintf(PHP_EOL . 'Extracting <info>%s</info>', $event->getArgument('version')->getVersion()),
                    sprintf('    <comment>%s</comment>', $event->getArgument('archive'))
                ));

                $self->startProgress($progress, $output);
            })
            ->handle('extract.progress', $processCallback)
            ->handle('extract.after', $afterCallback)
        ;
    }

    public function startProgress(ProgressHelper $progress, OutputInterface $output)
    {
        $progress->setBarWidth(50);
        $progress->setEmptyBarCharacter('-');
        $progress->setProgressCharacter('>');
        $progress->setFormat('[%bar%]');

        $progress->start($output);
    }
}
