<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Finentryinvoicesdetails Model
 *
 * @property \App\Model\Table\FinentryinvoicesTable&\Cake\ORM\Association\BelongsTo $Finentryinvoices
 * @property \App\Model\Table\ItemsTable&\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\Finentryinvoicesdetail newEmptyEntity()
 * @method \App\Model\Entity\Finentryinvoicesdetail newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finentryinvoicesdetail[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FinentryinvoicesdetailsTable extends Table
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

        $this->setTable('finentryinvoicesdetails');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Finentryinvoices', [
            'foreignKey' => 'finentryinvoice_id',
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
            ->scalar('vendorcode')
            ->maxLength('vendorcode', 45)
            ->allowEmptyString('vendorcode');

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
            ->decimal('interest')
            ->allowEmptyString('interest');

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
        $rules->add($rules->existsIn(['finentryinvoice_id'], 'Finentryinvoices'), ['errorField' => 'finentryinvoice_id']);
        $rules->add($rules->existsIn(['item_id'], 'Items'), ['errorField' => 'item_id']);

        return $rules;
    }
}
