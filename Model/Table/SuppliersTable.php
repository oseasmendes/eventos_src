<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Suppliers Model
 *
 * @property \App\Model\Table\FinentryinvoicesTable&\Cake\ORM\Association\HasMany $Finentryinvoices
 *
 * @method \App\Model\Entity\Supplier newEmptyEntity()
 * @method \App\Model\Entity\Supplier newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Supplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Supplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\Supplier findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Supplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supplier saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SuppliersTable extends Table
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

        $this->setTable('suppliers');
        $this->setDisplayField('shortname');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Finentryinvoices', [
            'foreignKey' => 'supplier_id',
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
            ->scalar('shortname')
            ->maxLength('shortname', 50)
            ->allowEmptyString('shortname');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('postalcode')
            ->maxLength('postalcode', 12)
            ->allowEmptyString('postalcode');

        $validator
            ->scalar('street')
            ->maxLength('street', 255)
            ->allowEmptyString('street');

        $validator
            ->scalar('district')
            ->maxLength('district', 100)
            ->allowEmptyString('district');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmptyString('city');

        $validator
            ->scalar('fiscalcode')
            ->maxLength('fiscalcode', 20)
            ->allowEmptyString('fiscalcode');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        return $validator;
    }
}
