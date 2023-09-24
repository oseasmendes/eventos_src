<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Finoperations Model
 *
 * @property \App\Model\Table\FinentryinvoicesTable&\Cake\ORM\Association\HasMany $Finentryinvoices
 *
 * @method \App\Model\Entity\Finoperation newEmptyEntity()
 * @method \App\Model\Entity\Finoperation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Finoperation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Finoperation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Finoperation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Finoperation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Finoperation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Finoperation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finoperation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Finoperation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finoperation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finoperation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Finoperation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FinoperationsTable extends Table
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

        $this->setTable('finoperations');
        $this->setDisplayField('shortdescription');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Finentryinvoices', [
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
            ->scalar('operationcode')
            ->maxLength('operationcode', 20)
            ->allowEmptyString('operationcode');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('shortdescription')
            ->maxLength('shortdescription', 45)
            ->allowEmptyString('shortdescription');

        $validator
            ->scalar('entryout')
            ->maxLength('entryout', 1)
            ->allowEmptyString('entryout');

        $validator
            ->scalar('accountcode')
            ->maxLength('accountcode', 45)
            ->allowEmptyString('accountcode');

        $validator
            ->integer('module')
            ->allowEmptyString('module');

        return $validator;
    }
}
