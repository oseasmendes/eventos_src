<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subscriptionsflows Model
 *
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\BelongsTo $Subscriptions
 *
 * @method \App\Model\Entity\Subscriptionsflow newEmptyEntity()
 * @method \App\Model\Entity\Subscriptionsflow newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsflow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsflow get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subscriptionsflow findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Subscriptionsflow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsflow[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsflow|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionsflow saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionsflow[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsflow[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsflow[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsflow[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionsflowsTable extends Table
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

        $this->setTable('subscriptionsflows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Subscriptions', [
            'foreignKey' => 'subscription_id',
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
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('action')
            ->maxLength('action', 255)
            ->allowEmptyString('action');

        $validator
            ->scalar('statusflag')
            ->maxLength('statusflag', 45)
            ->allowEmptyString('statusflag');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['subscription_id'], 'Subscriptions'), ['errorField' => 'subscription_id']);

        return $rules;
    }
}
