<?php

namespace Falseclock\OData\Server;

use Composer\Autoload\ClassLoader;
use Falseclock\OData\Helpers\Singleton;

class Configuration extends Singleton
{
    /** @var string $nameSpace */
    private $nameSpace;
    /** @var string $contextPath */
    private $contextPath;
    /** @var string $entityPath */
    private $entityPath;
    /** @var ClassLoader $composer */
    private $composer;

    /**
     * @return string
     */
    public function getContextPath(): string
    {
        return $this->contextPath;
    }

    /**
     * @param string $contextPath
     *
     * @return Configuration
     */
    public function setContextPath(string $contextPath): self
    {
        $this->contextPath = $contextPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityPath(): string
    {
        return $this->entityPath;
    }

    /**
     * @param string $entityPath
     *
     * @return Configuration
     */
    public function setEntityPath(string $entityPath): self
    {
        $this->entityPath = $entityPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->nameSpace;
    }

    /**
     * @param string $nameSpace
     *
     * @return Configuration
     */
    public function setNameSpace(string $nameSpace): self
    {
        $this->nameSpace = $nameSpace;

        return $this;
    }

    /**
     * @return ClassLoader
     */
    public function getComposer(): ClassLoader
    {
        return $this->composer;
    }

    /**
     * @param ClassLoader $composer
     * @return Configuration
     */
    public function setComposer(ClassLoader $composer): self
    {
        $this->composer = $composer;

        return $this;
    }
}