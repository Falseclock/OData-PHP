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

class TenderLotState extends Entity
{
    /**
     * ВНИМАНИЕ! После измнениея, удалением или добавления нового статуса, необходимо
     * 1. перебилдить индекс tender_lot_search_any_public_state
     * 2. изменить триггерную функцию tender.tender_lot_search_any_public_state() в таблице tender_lots
     * 3. проверить логику установки статусов лотов при поиске @see TenderLotsSearch::setLotState()
     */
    const CANCELED = "CANCELED";
    const DEAL_CANCELED = "DEAL_CANCELED";
    const FINISHED = "FINISHED";
    const ON_APPROVAL = "ON_APPROVAL";
    const ON_DRAFT = "ON_DRAFT";
    const ON_MODERATION = "ON_MODERATION";
    const ON_NEXT_STEP = "ON_NEXT_STEP";
    const OPEN_FOR_BID = "OPEN_FOR_BID";
    const PUBLISHED = "PUBLISHED";
    const SUCCESSFUL = "SUCCESSFUL";
    const TABLE = "tender.tender_lot_states";
    const UNSUCCESSFUL = "UNSUCCESSFUL";
    public $id;
    public $name;
    public $description;
    public $constant;

    protected $json = [];
    protected $objects = [];
}

class TenderLotStateMap extends Mapper
{
    public $id = "tender_lot_state_id";
    public $name = "tender_lot_state_name";
    public $description = "tender_lot_state_description";
    public $constant = "tender_lot_state_constant";
}

