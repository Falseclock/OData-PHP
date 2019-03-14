<?php
/**
 * <description should be written here>
 *
 * @package      OData\Server\Helpers
 * @copyright    2004-2007 by Konstantin V. Arkhipov
 * @license      GNU (Library|Lesser) General Public License, version 3
 */

namespace OData\Server\Helpers;

interface Instantiatable
{
    /**
     * @return mixed
     */
    public static function me();
}