<?php

namespace OData\Server;

use OData\Helpers\Singleton;

class Configuration extends Singleton
{
	/** @var string $nameSpace */
	private $nameSpace;
	/** @var string $contextPath */
	private $contextPath;
	/** @var string $odataVersion */
	private $odataVersion;

	/**
	 * @return string
	 */
	public function getContextPath(): string {
		return $this->contextPath;
	}

	/**
	 * @return string
	 */
	public function getNameSpace(): string {
		return $this->nameSpace;
	}

	/**
	 * @return string
	 */
	public function getOdataVersion(): string {
		return $this->odataVersion;
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
	 * @param string $nameSpace
	 */
	public function setNameSpace(string $nameSpace): void {
		$this->nameSpace = $nameSpace;
	}

	/**
	 * @param string $odataVersion
	 *
	 * @return Configuration
	 */
	public function setOdataVersion(string $odataVersion): self {
		$this->odataVersion = $odataVersion;

		return $this;
	}
}