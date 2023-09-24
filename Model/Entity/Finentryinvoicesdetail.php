<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Finentryinvoicesdetail Entity
 *
 * @property int $id
 * @property int|null $finentryinvoice_id
 * @property int|null $order
 * @property int|null $item_id
 * @property string|null $partnumber
 * @property string|null $vendorcode
 * @property string|null $description
 * @property string|null $quantity
 * @property string|null $unitvalue
 * @property string|null $discount
 * @property string|null $interest
 * @property string|null $subtotal
 * @property string|null $ordernumber
 * @property int|null $orderitem
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Finentryinvoice $finentryinvoice
 * @property \App\Model\Entity\Item $item
 */
class Finentryinvoicesdetail extends Entity
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
        'finentryinvoice_id' => true,
        'order' => true,
        'item_id' => true,
        'partnumber' => true,
        'vendorcode' => true,
        'description' => true,
        'quantity' => true,
        'unitvalue' => true,
        'discount' => true,
        'interest' => true,
        'subtotal' => true,
        'ordernumber' => true,
        'orderitem' => true,
        'created' => true,
        'modified' => true,
        'finentryinvoice' => true,
        'item' => true,
    ];
}
