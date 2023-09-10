<?php
declare(strict_types=1);

namespace App\Model\Entity;

//use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;


/**
 * User Entity
 *
 * @property int $id
 * @property string|null $username
 * @property string $docnumber
 * @property string|null $email
 * @property string|null $password
 * @property string|null $name
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $profile_id
 * @property int|null $role_id
 * @property string|null $mobile
 *
 * @property \App\Model\Entity\Profile $profile
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\People[] $peoples
 * @property \App\Model\Entity\Subscription[] $subscriptions
 */
class User extends Entity
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
        'username' => true,
        'docnumber' => true,
        'email' => true,
        'password' => true,
        'name' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'profile_id' => true,
        'role_id' => true,
        'mobile' => true,
        'profile' => true,
        'role' => true,
        'peoples' => true,
        'singlesubscriptions' => true,
        'subscriptions' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}
