<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \App\Model\Table\ItemtypesTable&\Cake\ORM\Association\BelongsTo $Itemtypes
 * @property \App\Model\Table\FinentryinvoicesdetailsTable&\Cake\ORM\Association\HasMany $Finentryinvoicesdetails
 * @property \App\Model\Table\FinreceivablesdetailsTable&\Cake\ORM\Association\HasMany $Finreceivablesdetails
 *
 * @method \App\Model\Entity\Item newEmptyEntity()
 * @method \App\Model\Entity\Item newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Itemtypes', [
            'foreignKey' => 'itemtype_id',
        ]);
        $this->hasMany('Finentryinvoicesdetails', [
            'foreignKey' => 'item_id',
        ]);
        $this->hasMany('Finreceivablesdetails', [
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
            ->scalar('partnumber')
            ->maxLength('partnumber', 45)
            ->allowEmptyString('partnumber');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 2)
            ->allowEmptyString('unit');

        $validator
            ->boolean('stockcontrol')
            ->allowEmptyString('stockcontrol');

        $validator
            ->decimal('minvalue')
            ->allowEmptyString('minvalue');

        $validator
            ->decimal('maxvalue')
            ->allowEmptyString('maxvalue');

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
        $rules->add($rules->existsIn(['itemtype_id'], 'Itemtypes'), ['errorField' => 'itemtype_id']);

        return $rules;
    }
}
