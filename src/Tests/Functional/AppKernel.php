<?php

namespace Effiana\JobQueueBundle\Tests\Functional;

// Set-up composer auto-loading if Client is insulated.
call_user_func(function() {
    if ( ! is_file($autoloadFile = __DIR__ . '/../../../vendor/autoload.php')) {
        throw new \LogicException('The autoload file "vendor/autoload.php" was not found. Did you run "composer install --dev"?');
    }

    require_once $autoloadFile;
});

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $config;

    public function __construct($config)
    {
        parent::__construct('test', false);

        $fs = new Filesystem();
        if (!$fs->isAbsolutePath($config)) {
            $config = __DIR__ . '/config/' .$config;
        }

        if ( ! is_file($config)) {
            throw new \RuntimeException(sprintf('The config file "%s" does not exist.', $config));
        }

        $this->config = $config;
    }

    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),

            new \Effiana\JobQueueBundle\Tests\Functional\TestBundle\TestBundle(),
            new \Effiana\JobQueueBundle\EffianaJobQueueBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->config);
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/'.Kernel::VERSION.'/EffianaJobQueueBundle/'.substr(sha1($this->config), 0, 6).'/cache';
    }

    public function getContainerClass()
    {
        return parent::getContainerClass().'_'.substr(sha1($this->config), 0, 6);
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/'.Kernel::VERSION.'/EffianaJobQueueBundle/'.substr(sha1($this->config), 0, 6).'/logs';
    }

    public function serialize()
    {
        return $this->config;
    }

    public function unserialize($config)
    {
        $this->__construct($config);
    }

    protected function getKernelParameters(): array
    {
        //get the original params
        $parameters = parent::getKernelParameters();
        $webDir = sprintf('%s/web', realpath($this->getProjectDir()) ?: $this->getProjectDir());
        //and merge it with ours.
        return array_merge(
            [
                'kernel.root_dir' => $this->getProjectDir(),
                'kernel.web_dir' => $webDir,
            ],
            $parameters
        );
    }
}