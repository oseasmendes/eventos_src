<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Finreceivablesdetails Model
 *
 * @property \App\Model\Table\FinreceivablesTable&\Cake\ORM\Association\BelongsTo $Finreceivables
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\Finreceivablesdetail newEmptyEntity()
 * @method \App\Model\Entity\Finreceivablesdetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finreceivablesdetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FinreceivablesdetailsTable extends Table
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

        $this->setTable('finreceivablesdetails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Finreceivables', [
            'foreignKey' => 'finreceivable_id',
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
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
            ->integer('order')
            ->allowEmptyString('order');

        $validator
            ->scalar('partnumber')
            ->maxLength('partnumber', 45)
            ->allowEmptyString('partnumber');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->decimal('quantity')
            ->allowEmptyString('quantity');

        $validator
            ->decimal('unitvalue')
            ->allowEmptyString('unitvalue');

        $validator
            ->decimal('discount')
            ->allowEmptyString('discount');

        $validator
            ->decimal('subtotal')
            ->allowEmptyString('subtotal');

        $validator
            ->scalar('ordernumber')
            ->maxLength('ordernumber', 45)
            ->allowEmptyString('ordernumber');

        $validator
            ->integer('orderitem')
            ->allowEmptyString('orderitem');

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
        $rules->add($rules->existsIn(['finreceivable_id'], 'Finreceivables'), ['errorField' => 'finreceivable_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
