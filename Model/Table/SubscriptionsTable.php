<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subscriptions Model
 *
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\SubscriptionsdocsTable&\Cake\ORM\Association\HasMany $Subscriptionsdocs
 * @property \App\Model\Table\SubscriptionsflowsTable&\Cake\ORM\Association\HasMany $Subscriptionsflows
 *
 * @method \App\Model\Entity\Subscription newEmptyEntity()
 * @method \App\Model\Entity\Subscription newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Subscription[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subscription get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subscription findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Subscription patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subscription[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subscription|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscription saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscription[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SubscriptionsTable extends Table
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

        $this->setTable('subscriptions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rolevents', [
            'foreignKey' => 'rolevent_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);

        $this->belongsTo('Peoples', [
            'foreignKey' => 'people_id',
        ]);

        $this->hasMany('Subscriptionsdocs', [
            'foreignKey' => 'subscription_id',
        ]);
        $this->hasMany('Subscriptionsflows', [
            'foreignKey' => 'subscription_id',
        ]);
        $this->hasMany('Subscriptionsconfs', [
            'foreignKey' => 'subscription_id',
        ]);

        $this->hasMany('Singlesubscriptions', [
            'foreignKey' => 'subscription_id',
        ]);

        $this->belongsTo('Subscriptionstypes', [
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
            ->date('dateissue')
            ->allowEmptyDate('dateissue');

        $validator
            ->integer('originid')
            ->allowEmptyString('originid');

        $validator
            ->integer('controlnumber')
            ->allowEmptyString('controlnumber');          

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');            

        $validator
            ->decimal('paymentvalue')
            ->allowEmptyString('paymentvalue');

        $validator
            ->scalar('statusflag')
            ->maxLength('statusflag', 30)
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
        $rules->add($rules->existsIn(['rolevent_id'], 'Rolevents'), ['errorField' => 'rolevent_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['subscriptionstype_id'], 'Subscriptionstypes'), ['errorField' => 'subscriptionstype_id']);
        $rules->add($rules->existsIn(['people_id'], 'Peoples'), ['errorField' => 'people_id']);

        return $rules;
    }
}
