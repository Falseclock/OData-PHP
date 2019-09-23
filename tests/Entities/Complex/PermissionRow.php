<?php

namespace Tests\Entities\Complex;

use Falseclock\DBD\Entity\Interfaces\Row;
use Tests\Entities\Permission;
use Tests\Entities\PermissionMap;

class PermissionRow extends Permission implements Row
{
}

class PermissionRowMap extends PermissionMap
{
}