<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * People Entity
 *
 * @property int $id
 * @property int|null $originid
 * @property int|null $bussinessunit_id
 * @property string|null $bussinessunitname
 * @property int|null $position_id
 * @property string|null $positiondescription
 * @property string|null $name
 * @property string|null $gender
 * @property string|null $email
 * @property string|null $street
 * @property string|null $streetcomplement
 * @property int|null $district_id
 * @property string|null $districtname
 * @property string|null $unitfederation
 * @property int|null $citie_id
 * @property string|null $citiesname
 * @property int|null $civilstatu_id
 * @property string|null $civilstatusdescrition
 * @property string|null $postalcode
 * @property string|null $mobile
 * @property string|null $phonehome
 * @property string|null $whatsapp
 * @property \Cake\I18n\FrozenDate|null $birthdate
 * @property string|null $photopath
 * @property string|null $photoname
 * @property int|null $origin
 * @property string|null $origindescription
 * @property int|null $condition_id
 * @property string|null $conditiondescription
 * @property string|null $integrationguid
 * @property bool|null $preinput
 * @property string|null $idocnumber
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Bussinessunit $bussinessunit
 * @property \App\Model\Entity\Position $position
 * @property \App\Model\Entity\District $district
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Civilstatus $civilstatus
 * @property \App\Model\Entity\Condition $condition
 * @property \App\Model\Entity\User $user
 */
class People extends Entity
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
        'originid' => true,
        'bussinessunit_id' => true,
        'bussinessunitname' => true,
        'position_id' => true,
        'positiondescription' => true,
        'name' => true,
        'gender' => true,
        'email' => true,
        'street' => true,
        'prio' => true,
        'streetcomplement' => true,
        'district_id' => true,
        'districtname' => true,
        'unitfederation' => true,
        'citie_id' => true,
        'citiesname' => true,
        'civilstatu_id' => true,
        'civilstatusdescrition' => true,
        'postalcode' => true,
        'mobile' => true,
        'phonehome' => true,
        'whatsapp' => true,
        'birthdate' => true,
        'photopath' => true,
        'photoname' => true,
        'origin' => true,
        'origindescription' => true,
        'condition_id' => true,
        'conditiondescription' => true,
        'integrationguid' => true,
        'preinput' => true,
        'idocnumber' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'bussinessunit' => true,
        'singlesubscriptions' => true,
        'subscriptions' => true,
        'position' => true,
        'district' => true,
        'city' => true,
        'civilstatus' => true,
        'condition' => true,
        'user' => true,
    ];
}
