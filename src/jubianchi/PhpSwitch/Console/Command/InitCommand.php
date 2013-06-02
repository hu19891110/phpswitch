<?php
/**
 * This file is part of phpswitch.
 *
 * (c) Julien Bianchi <contact@jubianchi.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jubianchi\PhpSwitch\Console\Command;

use jubianchi\PhpSwitch;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use jubianchi\PhpSwitch\Exception\DirectoryExistsException;

class InitCommand extends Command
{
    const NAME = 'init';
    const DESC = 'Initializes PhpSwitch environment';

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directories = array(
            $workspace = $this->getApplication()->getParameter('app.workspace.path'),
            $this->getApplication()->getParameter('app.workspace.downloads.path'),
            $this->getApplication()->getParameter('app.workspace.sources.path'),
            $installed = $this->getApplication()->getParameter('app.workspace.installed.path'),
            $this->getApplication()->getParameter('app.workspace.doc.path'),
        );

        $status = 0;
        foreach ($directories as $directory) {
            try {
                if ($this->makeDirectory($directory)) {
                    $output->writeln(sprintf('Directory <info>%s</info> was created', $directory));
                } else {
                    $output->writeln(sprintf('Directory <error>%s</error> was not created', $directory));
                    $status = 1;
                }
            } catch (DirectoryExistsException $exc) {
                $output->writeln(sprintf('Directory <info>%s</info> already exists', $directory));
            }
        }

        file_put_contents(
            $workspace . '/.phpswitchrc',
            $this->getApplication()->getService('app.twig')->render(
                'phpswitchrc.twig',
                array(
                    'path' => $this->getApplication()->getParameter('app.path'),
                    'installed' => $installed
                )
            )
        );

        file_put_contents(
            $workspace . '/.phpswitchprompt',
            $this->getApplication()->getService('app.twig')->render(
                'phpswitchprompt.twig',
                array(
                    'path' => $this->getApplication()->getParameter('app.path')
                )
            )
        );

        $output->writeln(
            sprintf(
                'You should <info>source %s</info> to use phpswitch',
                $workspace . '/.phpswitchrc'
            )
        );

        return $status;
    }

    /**
     * @param string $path
     *
     * @throws \RuntimeException
     *
     * @return bool
     */
    protected function checkWriteAccess($path)
    {
        $write = is_writable($path);

        if (false === $write) {
            throw new \RuntimeException(sprintf('You don\'t have write access on %s', $path));
        }

        return $write;
    }

    /**
     * @param $path
     *
     * @throws \RuntimeException
     * @throws \jubianchi\PhpSwitch\Exception\DirectoryExistsException
     *
     * @return bool
     */
    protected function makeDirectory($path)
    {
        $this->checkWriteAccess(dirname($path));

        if (false === file_exists($path)) {
            $create = mkdir($path);

            if (false === $create) {
                throw new \RuntimeException(sprintf('Could not create directory %s', $path));
            }
        } else {
            throw new DirectoryExistsException($path);
        }

        return $create;
    }
}
