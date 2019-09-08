<?php
/**
 * <description should be written here>
 *
 * @package      MP\Business
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 *
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, Ноябрь 2018
 */

namespace Falseclock\OData\DAO;

use Falseclock\OData\Helpers\Singleton;

/**
 * Название переменной в дочернем классе, которая должна быть если мы вызываем BaseHandler
 *
 * @property int $id
 * @property string $constant
 */
abstract class Mapper extends Singleton
{
    public function fields()
    {
        return get_object_vars($this);
    }

    public function revers($string)
    {
        $revers = array_flip(get_object_vars($this));

        return $revers[$string];
    }
}