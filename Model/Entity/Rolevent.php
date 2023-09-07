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
 * @property \Cake\I18n\FrozenDate|null $subscexpirationdate
 * @property \Cake\I18n\FrozenDate|null $eventexpirationdate
 * @property string|null $email
 *
 * @property \App\Model\Entity\Agenda[] $agendas
 * @property \App\Model\Entity\Breakingnews[] $breakingnews
 * @property \App\Model\Entity\Roleventfile[] $roleventfiles
 * @property \App\Model\Entity\Roleventschannel[] $roleventschannels
 * @property \App\Model\Entity\Roleventsimg[] $roleventsimgs
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
        'subscriptionrequired' => true,
        'subscexpirationdate' => true,
        'eventexpirationdate' => true,
        'email' => true,
        'bussinessunit_id' => true,
        'agendas' => true,
        'breakingnews' => true,
        'bussinessunits' => true,
        'roleventfiles' => true,
        'roleventschannels' => true,
        'roleventsimgs' => true,
        'subscriptions' => true,
    ];
}
