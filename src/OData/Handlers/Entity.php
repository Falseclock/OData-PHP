<?php
/**
 * <description should be written here>
 *
 * @package      OData\Handlers
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 *
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, сентябрь 2019
 */

namespace OData\Handlers;

class Entity
{
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getName(): string
    {
        return (substr($this->className, strrpos($this->className, '\\') + 1));
    }
}