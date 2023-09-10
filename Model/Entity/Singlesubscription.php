<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Singlesubscription Entity
 *
 * @property int $id
 * @property int|null $rolevent_id
 * @property string|null $fullname
 * @property string|null $email
 * @property int|null $bussinessunit_id
 * @property string|null $organizationname
 * @property string|null $position
 * @property string|null $mobil
 * @property string|null $salesperson
 * @property string|null $address
 * @property string|null $district
 * @property string|null $city
 * @property string|null $reference
 * @property string|null $statusflag
 * @property string|null $documentnumber
 * @property int|null $subscription_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $people_id
 * @property string|null $comments
 * @property bool|null $lgpd_ok
 * @property bool|null $copyrigth_ok
 * @property int|null $alteradopor
 * @property int|null $processadopor
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 * @property \App\Model\Entity\Bussinessunit $bussinessunit
 * @property \App\Model\Entity\Subscription $subscription
 * @property \App\Model\Entity\Person $person
 */
class Singlesubscription extends Entity
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
        'fullname' => true,
        'email' => true,
        'bussinessunit_id' => true,
        'organizationname' => true,
        'position' => true,
        'mobil' => true,
        'salesperson' => true,
        'address' => true,
        'district' => true,
        'city' => true,
        'reference' => true,
        'hashreference' => true,        
        'statusflag' => true,
        'documentnumber' => true,
        'subscription_id' => true,
        'created' => true,
        'modified' => true,
        'people_id' => true,
        'originid' => true,
        'comments' => true,
        'lgpd_ok' => true,
        'copyrigth_ok' => true,
        'alteradopor' => true,
        'processadopor' => true,
        'rolevent' => true,
        'price' => true,
        'bussinessunit' => true,
        'subscription' => true,
        'peoples' => true,
    ];

   
}
