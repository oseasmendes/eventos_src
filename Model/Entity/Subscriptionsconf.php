<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subscriptionsconf Entity
 *
 * @property int $id
 * @property int|null $subscription_id
 * @property int|null $number
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string|null $confirmationby
 * @property int|null $user_id
 * @property int|null $people_id
 * @property string|null $statusflag
 * @property bool|null $activeflag
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Subscription $subscription
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Person $person
 */
class Subscriptionsconf extends Entity
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
        'subscription_id' => true,
        'number' => true,
        'date' => true,
        'confirmationby' => true,
        'user_id' => true,
        'people_id' => true,
        'statusflag' => true,
        'activeflag' => true,
        'created' => true,
        'modified' => true,
        'subscription' => true,
        'user' => true,
        'person' => true,
    ];
}
