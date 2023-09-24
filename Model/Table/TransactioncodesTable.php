<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transactioncodes Model
 *
 * @property \App\Model\Table\CashbookstransactionsTable&\Cake\ORM\Association\HasMany $Cashbookstransactions
 *
 * @method \App\Model\Entity\Transactioncode newEmptyEntity()
 * @method \App\Model\Entity\Transactioncode newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Transactioncode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transactioncode get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transactioncode findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Transactioncode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transactioncode[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transactioncode|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transactioncode saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transactioncode[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transactioncode[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transactioncode[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transactioncode[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TransactioncodesTable extends Table
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

        $this->setTable('transactioncodes');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Cashbookstransactions', [
            'foreignKey' => 'transactioncode_id',
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
