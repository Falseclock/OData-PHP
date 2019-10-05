<?php

namespace Falseclock\OData\Server;

use Composer\Autoload\ClassLoader;
use DBD\Common\Singleton;
use DBD\Common\Utils;

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
	/** @var string $container */
	private $container;

	/**
	 * @return ClassLoader
	 */
	public function getComposer(): ClassLoader {
		return $this->composer;
	}

	/**
	 * @return string
	 */
	public function getContainer(): string {
		if(!isset($this->container)) {
			$this->container = Utils::toCamelCase($this->nameSpace, true, [ '_', '.' ]) . "Container";
		}

		return $this->container;
	}

	/**
	 * @return string
	 */
	public function getContextPath(): string {
		return $this->contextPath;
	}

	/**
	 * @return string
	 */
	public function getEntityPath(): string {
		return $this->entityPath;
	}

	/**
	 * @return string
	 */
	public function getNameSpace(): string {
		return $this->nameSpace;
	}

	/**
	 * @param ClassLoader $composer
	 *
	 * @return Configuration
	 */
	public function setComposer(ClassLoader $composer): self {
		$this->composer = $composer;

		return $this;
	}

	/**
	 * @param string $container
	 *
	 * @return Configuration
	 */
	public function setContainer(string $container): self {
		$this->container = $container;

		return $this;
	}

	/**
	 * @param string $contextPath
	 *
	 * @return Configuration
	 */
	public function setContextPath(string $contextPath): self {
		$this->contextPath = $contextPath;

		return $this;
	}

	/**
	 * @param string $entityPath
	 *
	 * @return Configuration
	 */
	public function setEntityPath(string $entityPath): self {
		$this->entityPath = $entityPath;

		return $this;
	}

	/**
	 * @param string $nameSpace
	 *
	 * @return Configuration
	 */
	public function setNameSpace(string $nameSpace): self {
		$this->nameSpace = $nameSpace;

		return $this;
	}
}