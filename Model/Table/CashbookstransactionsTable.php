<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cashbookstransactions Model
 *
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 * @property \App\Model\Table\BussinessunitsTable&\Cake\ORM\Association\BelongsTo $Bussinessunits
 * @property \App\Model\Table\TransactioncodesTable&\Cake\ORM\Association\BelongsTo $Transactioncodes
 * @property \App\Model\Table\FinoperationsTable&\Cake\ORM\Association\BelongsTo $Finoperations
 *
 * @method \App\Model\Entity\Cashbookstransaction newEmptyEntity()
 * @method \App\Model\Entity\Cashbookstransaction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Cashbookstransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cashbookstransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cashbookstransaction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Cashbookstransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cashbookstransaction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cashbookstransaction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cashbookstransaction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cashbookstransaction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cashbookstransaction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cashbookstransaction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Cashbookstransaction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CashbookstransactionsTable extends Table
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

        $this->setTable('cashbookstransactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rolevents', [
            'foreignKey' => 'rolevent_id',
        ]);
        $this->belongsTo('Bussinessunits', [
            'foreignKey' => 'bussinessunit_id',
        ]);
        $this->belongsTo('Transactioncodes', [
            'foreignKey' => 'transactioncode_id',
        ]);
        $this->belongsTo('Finoperations', [
            'foreignKey' => 'finoperation_id',
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
            ->scalar('description')
            ->maxLength('description', 45)
            ->allowEmptyString('description');

        $validator
            ->scalar('documentreference')
            ->maxLength('documentreference', 45)
            ->allowEmptyString('documentreference');

        $validator
            ->integer('transactionid')
            ->allowEmptyString('transactionid');

        $validator
            ->decimal('originalinvoiceamount')
            ->allowEmptyString('originalinvoiceamount');

        $validator
            ->decimal('discount')
            ->allowEmptyString('discount');

        $validator
            ->decimal('amount')
            ->allowEmptyString('amount');

        $validator
            ->scalar('transactiontype')
            ->maxLength('transactiontype', 15)
            ->allowEmptyString('transactiontype');

        $validator
            ->boolean('reversal')
            ->allowEmptyString('reversal');

        $validator
            ->integer('transactionreversalid')
            ->allowEmptyString('transactionreversalid');

        $validator
            ->decimal('cashinflow')
            ->allowEmptyString('cashinflow');

        $validator
            ->decimal('cashoutflow')
            ->allowEmptyString('cashoutflow');

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
        $rules->add($rules->existsIn(['transactioncode_id'], 'Transactioncodes'), ['errorField' => 'transactioncode_id']);
        $rules->add($rules->existsIn(['finoperation_id'], 'Finoperations'), ['errorField' => 'finoperation_id']);

        return $rules;
    }
}
