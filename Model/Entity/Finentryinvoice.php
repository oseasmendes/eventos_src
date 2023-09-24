<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Finentryinvoice Entity
 *
 * @property int $id
 * @property int|null $rolevent_id
 * @property int|null $paymentmethod_id
 * @property int|null $bussinessunit_id
 * @property int|null $finoperation_id
 * @property int|null $docstatu_id
 * @property int|null $supplier_id
 * @property string|null $shortdescription
 * @property string|null $number
 * @property \Cake\I18n\FrozenDate|null $entrydate
 * @property \Cake\I18n\FrozenDate|null $issuedate
 * @property \Cake\I18n\FrozenDate|null $duedate
 * @property string|null $suppliername
 * @property string|null $totalamount
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $observation
 * @property int|null $createdby
 * @property int|null $updatedby
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 * @property \App\Model\Entity\Paymentmethod $paymentmethod
 * @property \App\Model\Entity\Bussinessunit $bussinessunit
 * @property \App\Model\Entity\Finoperation $finoperation
 * @property \App\Model\Entity\Docstatus $docstatus
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Finentryinvoicesdetail[] $finentryinvoicesdetails
 */
class Finentryinvoice extends Entity
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
        'rolevent_id' => true,
        'paymentmethod_id' => true,
        'bussinessunit_id' => true,
        'finoperation_id' => true,
        'docstatu_id' => true,
        'supplier_id' => true,
        'shortdescription' => true,
        'number' => true,
        'entrydate' => true,
        'issuedate' => true,
        'duedate' => true,
        'suppliername' => true,
        'totalamount' => true,
        'discount' => true,
        'amount' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'observation' => true,
        'createdby' => true,
        'updatedby' => true,
        'rolevent' => true,
        'paymentmethod' => true,
        'bussinessunit' => true,
        'finoperation' => true,
        'docstatus' => true,
        'supplier' => true,
        'user' => true,
        'finentryinvoicesdetails' => true,
    ];
}
