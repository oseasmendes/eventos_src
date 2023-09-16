<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Singlesubscriptions Model
 *
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 * @property \App\Model\Table\BussinessunitsTable&\Cake\ORM\Association\BelongsTo $Bussinessunits
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\BelongsTo $Subscriptions
 * @property \App\Model\Table\PeopleTable&\Cake\ORM\Association\BelongsTo $People
 *
 * @method \App\Model\Entity\Singlesubscription newEmptyEntity()
 * @method \App\Model\Entity\Singlesubscription newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Singlesubscription[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Singlesubscription get($primaryKey, $options = [])
 * @method \App\Model\Entity\Singlesubscription findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Singlesubscription patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Singlesubscription[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Singlesubscription|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Singlesubscription saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Singlesubscription[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Singlesubscription[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Singlesubscription[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Singlesubscription[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SinglesubscriptionsTable extends Table
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

        $this->setTable('singlesubscriptions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rolevents', [
            'foreignKey' => 'rolevent_id',
        ]);
        $this->belongsTo('Bussinessunits', [
            'foreignKey' => 'bussinessunit_id',
        ]);
        $this->hasOne('Subscriptions');

        $this->belongsTo('Peoples', [
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
            ->scalar('fullname')
            ->maxLength('fullname', 255)
            ->allowEmptyString('fullname');

        $validator
            ->email('email')
            ->allowEmptyString('email')
            ->requirePresence('email')
            ->notEmptyString('email')           
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail precisa ser um email válido'
            ]);  

        $validator
            ->scalar('organizationname')
            ->maxLength('organizationname', 255)
            ->allowEmptyString('organizationname');

        $validator
            ->scalar('position')
            ->maxLength('position', 255)
            ->allowEmptyString('position');

        $validator
            ->scalar('mobil')
            ->maxLength('mobil', 45)
            ->allowEmptyString('mobil');

        $validator
            ->scalar('salesperson')
            ->maxLength('salesperson', 255)
            ->allowEmptyString('salesperson');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('district')
            ->maxLength('district', 255)
            ->allowEmptyString('district');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmptyString('city');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 255)
            ->allowEmptyString('reference');

        $validator
            ->scalar('hashreference')
            ->maxLength('hashreference', 255)
            ->allowEmptyString('hashreference');            

        $validator
            ->scalar('statusflag')
            ->maxLength('statusflag', 45)
            ->allowEmptyString('statusflag');

        $validator
            ->scalar('documentnumber')
            ->maxLength('documentnumber', 45)
            ->requirePresence('documentnumber')
            ->notEmptyString('documentnumber')           
            ->add('documentnumber', 'numeric', ['rule' => 'numeric','message' => 'Inserir apenas numeros']);      

        $validator
            ->scalar('comments')
            ->maxLength('comments', 4294967295)
            ->allowEmptyString('comments');

        $validator
            ->boolean('lgpd_ok')
            ->allowEmptyString('lgpd_ok');

        $validator
            ->boolean('copyrigth_ok')
            ->allowEmptyString('copyrigth_ok');

        $validator
            ->integer('alteradopor')
            ->allowEmptyString('alteradopor');

        $validator
            ->integer('processadopor')
            ->allowEmptyString('processadopor');

        $validator
            ->decimal('price')
            ->allowEmptyString('price');    

        $validator
            ->integer('originid')
            ->allowEmptyString('originid');

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
        $rules->add($rules->existsIn(['bussinessunit_id'], 'Bussinessunits'), ['errorField' => 'bussinessunit_id']);
        $rules->add($rules->existsIn(['subscription_id'], 'Subscriptions'), ['errorField' => 'subscription_id']);
        $rules->add($rules->existsIn(['people_id'], 'Peoples'), ['errorField' => 'people_id']);

        return $rules;
    }
}
