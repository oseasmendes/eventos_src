<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supplier Entity
 *
 * @property int $id
 * @property string|null $shortname
 * @property string|null $description
 * @property string|null $postalcode
 * @property string|null $street
 * @property string|null $district
 * @property string|null $city
 * @property string|null $fiscalcode
 * @property string|null $email
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool|null $active
 *
 * @property \App\Model\Entity\Finentryinvoice[] $finentryinvoices
 */
class Supplier extends Entity
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
        'shortname' => true,
        'description' => true,
        'postalcode' => true,
        'street' => true,
        'district' => true,
        'city' => true,
        'fiscalcode' => true,
        'email' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'finentryinvoices' => true,
    ];
}
