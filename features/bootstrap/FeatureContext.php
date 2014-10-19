<?php

use Symfony\Component\BrowserKit\Cookie;

class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements \Behat\Symfony2Extension\Context\KernelAwareContext
{
    private $kernel;

    /**
     * Sets Kernel instance.
     *
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    public function setKernel(\Symfony\Component\HttpKernel\KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
}
 