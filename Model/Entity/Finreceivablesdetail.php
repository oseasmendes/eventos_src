<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Finreceivablesdetail Entity
 *
 * @property int $id
 * @property int|null $finreceivable_id
 * @property int|null $order
 * @property int|null $item_id
 * @property string|null $partnumber
 * @property string|null $description
 * @property string|null $quantity
 * @property string|null $unitvalue
 * @property string|null $discount
 * @property string|null $subtotal
 * @property string|null $ordernumber
 * @property int|null $orderitem
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Finreceivable $finreceivable
 * @property \App\Model\Entity\Item $item
 */
class Finreceivablesdetail extends Entity
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
        'finreceivable_id' => true,
        'order' => true,
        'item_id' => true,
        'partnumber' => true,
        'description' => true,
        'quantity' => true,
        'unitvalue' => true,
        'discount' => true,
        'subtotal' => true,
        'ordernumber' => true,
        'orderitem' => true,
        'created' => true,
        'modified' => true,
        'finreceivable' => true,
        'item' => true,
    ];
}
