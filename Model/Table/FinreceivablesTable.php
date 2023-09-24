<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Finreceivables Model
 *
 * @property \App\Model\Table\BussinessunitsTable&\Cake\ORM\Association\BelongsTo $Bussinessunits
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 * @property \App\Model\Table\FinoperationsTable&\Cake\ORM\Association\BelongsTo $Finoperations
 * @property \App\Model\Table\PaymentmethodsTable&\Cake\ORM\Association\BelongsTo $Paymentmethods
 * @property \App\Model\Table\DocstatusTable&\Cake\ORM\Association\BelongsTo $Docstatus
 * @property \App\Model\Table\PeopleTable&\Cake\ORM\Association\BelongsTo $People
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FinreceivablesdetailsTable&\Cake\ORM\Association\HasMany $Finreceivablesdetails
 *
 * @method \App\Model\Entity\Finreceivable newEmptyEntity()
 * @method \App\Model\Entity\Finreceivable newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivable[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivable get($primaryKey, $options = [])
 * @method \App\Model\Entity\Finreceivable findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Finreceivable patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivable[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivable|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finreceivable saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finreceivable[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finreceivable[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finreceivable[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finreceivable[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FinreceivablesTable extends Table
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

        $this->setTable('finreceivables');
        $this->setDisplayField('shortdescription');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Bussinessunits', [
            'foreignKey' => 'bussinessunit_id',
        ]);
        $this->belongsTo('Rolevents', [
            'foreignKey' => 'rolevent_id',
        ]);
        $this->belongsTo('Finoperations', [
            'foreignKey' => 'finoperation_id',
        ]);
        $this->belongsTo('Paymentmethods', [
            'foreignKey' => 'paymentmethod_id',
        ]);
        $this->belongsTo('Docstatus', [
            'foreignKey' => 'docstatu_id',
        ]);
        $this->belongsTo('Peoples', [
            'foreignKey' => 'people_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Finreceivablesdetails', [
            'foreignKey' => 'finreceivable_id',
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
            ->date('receivabledate')
            ->allowEmptyDate('receivabledate');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 45)
            ->allowEmptyString('reference');

        $validator
            ->scalar('shortdescription')
            ->maxLength('shortdescription', 255)
            ->allowEmptyString('shortdescription');

        $validator
            ->scalar('responsible')
            ->maxLength('responsible', 255)
            ->allowEmptyString('responsible');

        $validator
            ->decimal('discount')
            ->allowEmptyString('discount');

        $validator
            ->decimal('amount')
            ->allowEmptyString('amount');

        $validator
            ->decimal('totalamount')
            ->allowEmptyString('totalamount');

        $validator
            ->scalar('observation')
            ->maxLength('observation', 4294967295)
            ->allowEmptyString('observation');

        $validator
            ->integer('createdby')
            ->allowEmptyString('createdby');

        $validator
            ->integer('modifiedby')
            ->allowEmptyString('modifiedby');

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
        $rules->add($rules->existsIn(['bussinessunit_id'], 'Bussinessunits'), ['errorField' => 'bussinessunit_id']);
        $rules->add($rules->existsIn(['rolevent_id'], 'Rolevents'), ['errorField' => 'rolevent_id']);
        $rules->add($rules->existsIn(['finoperation_id'], 'Finoperations'), ['errorField' => 'finoperation_id']);
        $rules->add($rules->existsIn(['paymentmethod_id'], 'Paymentmethods'), ['errorField' => 'paymentmethod_id']);
        $rules->add($rules->existsIn(['docstatu_id'], 'Docstatus'), ['errorField' => 'docstatu_id']);
        $rules->add($rules->existsIn(['people_id'], 'Peoples'), ['errorField' => 'people_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
