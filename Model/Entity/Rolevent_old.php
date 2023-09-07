<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rolevent Entity
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $details
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property bool|null $activeflag
 * @property \Cake\I18n\FrozenDate|null $startdate
 * @property \Cake\I18n\FrozenDate|null $enddate
 * @property string|null $price
 * @property bool|null $subscriptionrequired
 *
 * @property \App\Model\Entity\Subscription[] $subscriptions
 */
class Rolevent extends Entity
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
        'description' => true,
        'details' => true,
        'created' => true,
        'modified' => true,
        'activeflag' => true,
        'startdate' => true,
        'enddate' => true,
        'price' => true,
        'email' => true,
        'subscexpirationdate'=> true,
        'eventexpirationdate'=> true,
        'subscriptionrequired' => true,
        'roleventsimgs' => true,
        'subscriptions' => true,
    ];
}
