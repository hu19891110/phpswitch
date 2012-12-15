<?php
namespace jubianchi\PhpSwitch\Config;

class Configuration implements \IteratorAggregate
{
    const ROOT = 'phpswitch';

    /** @var array */
    private $configuration = array();

    /** @var \jubianchi\PhpSwitch\Config\Dumper */
    private $dumper;

    /**
     * @param string $offset
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function get($offset)
    {
        $offset = explode('.', $offset);
        $reference = $this->configuration;
        $current = $sep = '';

        foreach($offset as $key) {
            $current .= $sep . $key;
            if(false === isset($reference[$key])) {
                throw new \InvalidArgumentException(sprintf('Offset %s does not exist', $current));
            }

            $reference = & $reference[$key];

            $sep = '.';
        }

        return $reference;
    }

    /**
     * @param string $offset
     * @param mixed  $value
     *
     * @throws \InvalidArgumentException
     *
     * @return \jubianchi\PhpSwitch\Config\Configuration
     */
    public function set($offset, $value)
    {
        $offset = explode('.', $offset);
        $reference = & $this->configuration;
        $current = $sep = '';

        foreach($offset as $key) {
            $current .= $sep . $key;
            if(false === isset($reference[$key])) {
                $reference[$key] = null;
            }

            $reference = & $reference[$key];

            $sep = '.';
        }

        $reference = $value;

        return $this;
    }

    /**
     * @param array $values
     *
     * @return \jubianchi\PhpSwitch\Config\Configuration
     */
    public function setValues(array $values)
    {
        $this->configuration = $values;

        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->configuration;
    }

    /**
     * @return \RecursiveArrayIterator
     */
    public function getIterator()
    {
    return new \RecursiveArrayIterator($this->configuration);
    }

    /**
     * @throws \RuntimeException
     *
     * @return \jubianchi\PhpSwitch\Config\Configuration
     */
    public function dump()
    {
        if(null === $this->dumper) {
            throw new \RuntimeException('No dumper available');
        }

        $this->dumper->dump('.phpswitch.yml', $this);

        return $this;
    }

    /**
     * @param \jubianchi\PhpSwitch\Config\Dumper $dumper
     *
     * @return Configuration
     */
    public function setDumper(Dumper $dumper)
    {
        $this->dumper = $dumper;

        return $this;
    }

    /**
     * @return \jubianchi\PhpSwitch\Config\Dumper
     */
    public function getDumper()
    {
        return $this->dumper;
    }
}
