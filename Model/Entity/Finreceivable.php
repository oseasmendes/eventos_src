<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Finreceivable Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate|null $receivabledate
 * @property int|null $bussinessunit_id
 * @property int|null $rolevent_id
 * @property int|null $finoperation_id
 * @property int|null $paymentmethod_id
 * @property int|null $docstatu_id
 * @property string|null $reference
 * @property string|null $shortdescription
 * @property int|null $people_id
 * @property string|null $responsible
 * @property string|null $discount
 * @property string|null $amount
 * @property string|null $totalamount
 * @property string|null $observation
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $createdby
 * @property int|null $modifiedby
 *
 * @property \App\Model\Entity\Bussinessunit $bussinessunit
 * @property \App\Model\Entity\Rolevent $rolevent
 * @property \App\Model\Entity\Finoperation $finoperation
 * @property \App\Model\Entity\Paymentmethod $paymentmethod
 * @property \App\Model\Entity\Docstatus $docstatus
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Finreceivablesdetail[] $finreceivablesdetails
 */
class Finreceivable extends Entity
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
        'receivabledate' => true,
        'bussinessunit_id' => true,
        'rolevent_id' => true,
        'finoperation_id' => true,
        'paymentmethod_id' => true,
        'docstatu_id' => true,
        'reference' => true,
        'shortdescription' => true,
        'people_id' => true,
        'responsible' => true,
        'discount' => true,
        'amount' => true,
        'totalamount' => true,
        'observation' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'createdby' => true,
        'modifiedby' => true,
        'bussinessunit' => true,
        'rolevent' => true,
        'finoperation' => true,
        'paymentmethod' => true,
        'docstatus' => true,
        'peoples' => true,
        'user' => true,
        'finreceivablesdetails' => true,
    ];
}
