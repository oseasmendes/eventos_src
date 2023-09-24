<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Paymentmethods Model
 *
 * @property \App\Model\Table\FinentryinvoicesTable&\Cake\ORM\Association\HasMany $Finentryinvoices
 *
 * @method \App\Model\Entity\Paymentmethod newEmptyEntity()
 * @method \App\Model\Entity\Paymentmethod newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Paymentmethod[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Paymentmethod get($primaryKey, $options = [])
 * @method \App\Model\Entity\Paymentmethod findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Paymentmethod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Paymentmethod[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Paymentmethod|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Paymentmethod saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Paymentmethod[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Paymentmethod[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Paymentmethod[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Paymentmethod[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentmethodsTable extends Table
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

        $this->setTable('paymentmethods');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Finentryinvoices', [
            'foreignKey' => 'paymentmethod_id',
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

        $validator
            ->scalar('entryout')
            ->maxLength('entryout', 1)
            ->allowEmptyString('entryout');

        return $validator;
    }
}
