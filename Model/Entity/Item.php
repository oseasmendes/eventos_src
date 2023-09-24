<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property string|null $partnumber
 * @property string|null $description
 * @property string|null $unit
 * @property int|null $itemtype_id
 * @property bool|null $stockcontrol
 * @property string|null $minvalue
 * @property string|null $maxvalue
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Itemtype $itemtype
 * @property \App\Model\Entity\Finentryinvoicesdetail[] $finentryinvoicesdetails
 * @property \App\Model\Entity\Finreceivablesdetail[] $finreceivablesdetails
 */
class Item extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'partnumber' => true,
        'description' => true,
        'unit' => true,
        'itemtype_id' => true,
        'stockcontrol' => true,
        'minvalue' => true,
        'maxvalue' => true,
        'created' => true,
        'modified' => true,
        'itemtype' => true,
        'finentryinvoicesdetails' => true,
        'finreceivablesdetails' => true,
    ];
}
