<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subscription Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate|null $date
 * @property int|null $rolevent_id
 * @property int|null $user_id
 * @property bool|null $activeflag
 * @property string|null $statusflag
 *
 * @property \App\Model\Entity\Rolevent $rolevent
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Subscriptionsdoc[] $subscriptionsdocs
 * @property \App\Model\Entity\Subscriptionsflow[] $subscriptionsflows
 */
class Subscription extends Entity
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
        'dateissue' => true,
        'rolevent_id' => true,        
        'subscriptionstype_id' => true,
        'user_id' => true,
        'people_id' => true,
        'singlesubscription_id' => true,
        'mobile' => true,
        'originid' => true,
        'controlnumber'=> true,
        'paymentvalue'=> true,
        'activeflag' => true,
        'statusflag' => true,
        'rolevent' => true,
        'created' => true,
        'modified' => true,
        'summary' => true,
        'user' => true,
        'subscriptionsdocs' => true,
        'peoples' => true,
        'subscriptionsconfs' => true,
        'subscriptionstypes' => true,
        'singlesubscriptions' => true,
        'subscriptionsflows' => true,
    ];
}
