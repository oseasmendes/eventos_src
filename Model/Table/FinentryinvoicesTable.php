<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Finentryinvoices Model
 *
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 * @property \App\Model\Table\PaymentmethodsTable&\Cake\ORM\Association\BelongsTo $Paymentmethods
 * @property \App\Model\Table\BussinessunitsTable&\Cake\ORM\Association\BelongsTo $Bussinessunits
 * @property \App\Model\Table\FinoperationsTable&\Cake\ORM\Association\BelongsTo $Finoperations
 * @property \App\Model\Table\DocstatusTable&\Cake\ORM\Association\BelongsTo $Docstatus
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FinentryinvoicesdetailsTable&\Cake\ORM\Association\HasMany $Finentryinvoicesdetails
 *
 * @method \App\Model\Entity\Finentryinvoice newEmptyEntity()
 * @method \App\Model\Entity\Finentryinvoice newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Finentryinvoice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Finentryinvoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finentryinvoice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finentryinvoice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finentryinvoice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finentryinvoice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finentryinvoice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FinentryinvoicesTable extends Table
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

        $this->setTable('finentryinvoices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rolevents', [
            'foreignKey' => 'rolevent_id',
        ]);
        $this->belongsTo('Paymentmethods', [
            'foreignKey' => 'paymentmethod_id',
        ]);
        $this->belongsTo('Bussinessunits', [
            'foreignKey' => 'bussinessunit_id',
        ]);
        $this->belongsTo('Finoperations', [
            'foreignKey' => 'finoperation_id',
        ]);
        $this->belongsTo('Docstatus', [
            'foreignKey' => 'docstatu_id',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Finentryinvoicesdetails', [
            'foreignKey' => 'finentryinvoice_id',
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
            ->scalar('shortdescription')
            ->maxLength('shortdescription', 255)
            ->allowEmptyString('shortdescription');

        $validator
            ->scalar('number')
            ->maxLength('number', 20)
            ->allowEmptyString('number');

        $validator
            ->date('entrydate')
            ->allowEmptyDate('entrydate');

        $validator
            ->date('issuedate')
            ->allowEmptyDate('issuedate');

        $validator
            ->date('duedate')
            ->allowEmptyDate('duedate');

        $validator
            ->scalar('suppliername')
            ->maxLength('suppliername', 255)
            ->allowEmptyString('suppliername');

        $validator
            ->decimal('totalamount')
            ->allowEmptyString('totalamount');


        $validator
            ->decimal('discount')
            ->allowEmptyString('discount');

        $validator
            ->decimal('amount')
            ->allowEmptyString('amount');


        $validator
            ->scalar('observation')
            ->maxLength('observation', 4294967295)
            ->allowEmptyString('observation');

        $validator
            ->integer('createdby')
            ->allowEmptyString('createdby');

        $validator
            ->integer('updatedby')
            ->allowEmptyString('updatedby');

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
        $rules->add($rules->existsIn(['paymentmethod_id'], 'Paymentmethods'), ['errorField' => 'paymentmethod_id']);
        $rules->add($rules->existsIn(['bussinessunit_id'], 'Bussinessunits'), ['errorField' => 'bussinessunit_id']);
        $rules->add($rules->existsIn(['finoperation_id'], 'Finoperations'), ['errorField' => 'finoperation_id']);
        $rules->add($rules->existsIn(['docstatu_id'], 'Docstatus'), ['errorField' => 'docstatu_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
