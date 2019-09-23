<?php

namespace Tests\Entities\Complex;

use Falseclock\DBD\Entity\Interfaces\Row;
use Tests\Entities\Company;
use Tests\Entities\CompanyMap;

class CompanyRow extends Company implements Row
{
}

class CompanyRowMap extends CompanyMap
{
}