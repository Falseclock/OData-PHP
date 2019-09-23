<?php

namespace Tests\Entities\Complex;

use Falseclock\DBD\Entity\Interfaces\Row;
use Tests\Entities\User;
use Tests\Entities\UserMap;

class UserRow extends User implements Row
{
}

class UserRowMap extends UserMap
{
}