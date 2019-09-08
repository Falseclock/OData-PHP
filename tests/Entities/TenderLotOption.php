<?php
/**
 * Стандартные настройки опций тендеров для компаний.
 * Все создаваемые тендеры автоматом имеют опции, которые привязаны к компании.
 * Эта таблица нужна чтобы 1 раз настроить опции создаваемых тендеров для определенных закупщиков
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

use Falseclock\OData\DAO\Mapper;
use Falseclock\OData\DAO\Model;

class TenderLotOption extends Model
{
    const TABLE = "tender.tender_lot_options";
    const TYPES = ['STRING', 'BOOLEAN', 'INTEGER', 'FLOAT', 'INTERVAL'];
    public $id;
    public $name;
    public $description;
    public $constant;
    public $valueType;
    public $value;
    public $oldConstant;

    protected $json = [];
    protected $objects = [];
}

class TenderLotOptionMap extends Mapper
{
    public $id = "tender_lot_option_id";
    public $name = "tender_lot_option_name";
    public $description = "tender_lot_option_description";
    public $constant = "tender_lot_option_constant";
    public $valueType = "tender_lot_option_value_type";
    public $value = "tender_lot_option_value";
    public $oldConstant = "tender_lot_option_old_constant";
}

