<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Finoperation Entity
 *
 * @property int $id
 * @property string|null $operationcode
 * @property string|null $description
 * @property string|null $shortdescription
 * @property string|null $entryout
 * @property string|null $accountcode
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $module
 *
 * @property \App\Model\Entity\Finentryinvoice[] $finentryinvoices
 */
class Finoperation extends Entity
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
        'operationcode' => true,
        'description' => true,
        'shortdescription' => true,
        'entryout' => true,
        'accountcode' => true,
        'created' => true,
        'modified' => true,
        'module' => true,
        'finentryinvoices' => true,
    ];
}
