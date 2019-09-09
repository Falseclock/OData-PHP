<?php
/**
 * <description should be written here>
 *
 * @package      Falseclock\OData\Writers
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 *
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, сентябрь 2019
 */

namespace Falseclock\OData\Writers;


use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;

interface Writer
{
    function __construct(Request &$request, Response &$response);

    public function getStringOutput();

    public function getWriter();

    public function serviceDocument();
}