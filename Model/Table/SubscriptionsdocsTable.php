<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subscriptionsdocs Model
 *
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\BelongsTo $Subscriptions
 * @property \App\Model\Table\DoctypesTable&\Cake\ORM\Association\BelongsTo $Doctypes
 *
 * @method \App\Model\Entity\Subscriptionsdoc newEmptyEntity()
 * @method \App\Model\Entity\Subscriptionsdoc newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc get($primaryKey, $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Subscriptionsdoc[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscriptionsdocsTable extends Table
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

        $this->setTable('subscriptionsdocs');
        $this->setDisplayField('descripion');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Subscriptions', [
            'foreignKey' => 'subscription_id',
        ]);
        $this->belongsTo('Doctypes', [
            'foreignKey' => 'doctype_id',
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
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 250)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('path')
            ->maxLength('path', 255)
            ->allowEmptyString('path');

        $validator
            ->scalar('statusflag')
            ->maxLength('statusflag', 45)
            ->allowEmptyString('statusflag');

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');

        $validator
            ->scalar('membername')
            ->maxLength('membername', 255)
            ->allowEmptyString('membername');   
         
        $validator
            ->scalar('memberdocnumber')
            ->maxLength('memberdocnumber', 45)
            ->allowEmptyString('memberdocnumber');   
            
        $validator
            ->integer('membercode')            
            ->allowEmptyString('membercode');   

         
        $validator
            ->date('subscriptiondate')
            ->allowEmptyDate('subscriptiondate');
          
           
        $validator
            ->decimal('subscriptionprice')
            ->allowEmptyString('subscriptionprice');
       
        $validator
            ->scalar('subscriptionevent')
            ->maxLength('subscriptionevent', 255)
            ->allowEmptyString('subscriptionevent');       

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
        $rules->add($rules->existsIn(['doctype_id'], 'Doctypes'), ['errorField' => 'doctype_id']);

        return $rules;
    }
}
