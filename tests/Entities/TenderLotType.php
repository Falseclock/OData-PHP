<?php
/**
 * Типы закупа в тендерных лотах
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

class TenderLotType extends Entity
{
    const CLASSIC = "CLASSIC";
    const COMMERCIAL_PROPOSAL = "COMMERCIAL_PROPOSAL";
    const DOUBLE_ENVELOPE = "DOUBLE_ENVELOPE";
    const ENGLISH = "ENGLISH";
    const FRAME_AGREEMENT = "FRAME_AGREEMENT";
    const PRICE_LIST = "PRICE_LIST";
    const PRIVATE = "PRIVATE";
    const QUALIFICATION = "QUALIFICATION";
    const QUALIFICATION_CLASSIC = "QUALIFICATION_CLASSIC";
    const SUBSOIL = "SUBSOIL";
    const TABLE = "tender.tender_lot_types";
    public $id;
    public $name;
    public $description;
    public $constant;

    protected $json = [];
    protected $objects = [];
}

class TenderLotTypeMap extends Mapper
{
    public $id = "tender_lot_type_id";
    public $name = "tender_lot_type_name";
    public $description = "tender_lot_type_description";
    public $constant = "tender_lot_type_constant";
}

