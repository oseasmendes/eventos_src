<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subscriptionsconfs Model
 *
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\BelongsTo $Subscriptions
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PeopleTable&\Cake\ORM\Association\BelongsTo $People
 *
 * @method \App\Model\Entity\Subscriptionsconf newEmptyEntity()
 * @method \App\Model\Entity\Subscriptionsconf newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsconf[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsconf get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subscriptionsconf findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Subscriptionsconf patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsconf[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsconf|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionsconf saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionsconf[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsconf[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsconf[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsconf[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionsconfsTable extends Table
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

        $this->setTable('subscriptionsconfs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Subscriptions', [
            'foreignKey' => 'subscription_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('People', [
            'foreignKey' => 'people_id',
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
            ->integer('number')
            ->allowEmptyString('number');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('confirmationby')
            ->maxLength('confirmationby', 255)
            ->allowEmptyString('confirmationby');

        $validator
            ->scalar('statusflag')
            ->maxLength('statusflag', 45)
            ->allowEmptyString('statusflag');

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['people_id'], 'People'), ['errorField' => 'people_id']);

        return $rules;
    }
}
