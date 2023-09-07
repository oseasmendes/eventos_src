<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subscriptionstypes Model
 *
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\HasMany $Subscriptions
 *
 * @method \App\Model\Entity\Subscriptionstype newEmptyEntity()
 * @method \App\Model\Entity\Subscriptionstype newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionstype[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionstype get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subscriptionstype findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Subscriptionstype patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionstype[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionstype|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionstype saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionstype[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionstype[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionstype[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionstype[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionstypesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('subscriptionstypes');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Subscriptions', [
            'foreignKey' => 'subscriptionstype_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('description')
            ->maxLength('description', 45)
            ->allowEmptyString('description');

        return $validator;
    }
}
