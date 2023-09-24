<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cashbookstransaction Entity
 *
 * @property int $id
 * @property int|null $rolevent_id
 * @property int|null $bussinessunit_id
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $description
 * @property string|null $documentreference
 * @property int|null $transactionid
 * @property string|null $originalinvoiceamount
 * @property string|null $discount
 * @property string|null $amount
 * @property string|null $transactiontype
 * @property bool|null $reversal
 * @property int|null $transactionreversalid
 * @property int|null $transactioncode_id
 * @property string|null $cashinflow
 * @property string|null $cashoutflow
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $finoperation_id
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 * @property \App\Model\Entity\Bussinessunit $bussinessunit
 * @property \App\Model\Entity\Transactioncode $transactioncode
 * @property \App\Model\Entity\Finoperation $finoperation
 */
class Cashbookstransaction extends Entity
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
        'bussinessunit_id' => true,
        'date' => true,
        'description' => true,
        'documentreference' => true,
        'transactionid' => true,
        'originalinvoiceamount' => true,
        'discount' => true,
        'amount' => true,
        'transactiontype' => true,
        'reversal' => true,
        'transactionreversalid' => true,
        'transactioncode_id' => true,
        'cashinflow' => true,
        'cashoutflow' => true,
        'created' => true,
        'modified' => true,
        'finoperation_id' => true,
        'rolevent' => true,
        'bussinessunit' => true,
        'transactioncode' => true,
        'finoperation' => true,
    ];
}
