<?php
/**
 * <description should be written here>
 *
 * @package      Model
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 *
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, Апрель 2018
 */

namespace Tests\Entities;

use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;

class Tender extends Entity
{
    const TABLE = "tender.tenders_new";
    public $id;
    public $name;
    public $datePublication;
    public $isActive;
    /** @var User $User */
    public $User;
    /** @var TenderLot[] $TenderLots */
    public $TenderLots;

    protected $json = [];
    protected $objects = [
        'TenderLots' => TenderLot::class,
        'User' => User::class
    ];
}

class TenderMap extends Mapper
{
    public $id = "tender_id";
    public $name = "tender_name";
    public $datePublication = "tender_date_publication";
    public $isActive = "tender_is_active";
}

