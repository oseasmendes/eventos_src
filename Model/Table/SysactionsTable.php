<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sysactions Model
 *
 * @property \App\Model\Table\SysadminsTable&\Cake\ORM\Association\HasMany $Sysadmins
 *
 * @method \App\Model\Entity\Sysaction newEmptyEntity()
 * @method \App\Model\Entity\Sysaction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Sysaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sysaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sysaction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Sysaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sysaction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sysaction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sysaction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sysaction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysaction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysaction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysaction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SysactionsTable extends Table
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

        $this->setTable('sysactions');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Sysadmins', [
            'foreignKey' => 'sysaction_id',
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
            ->boolean('automatic')
            ->allowEmptyString('automatic');

        $validator
            ->boolean('standard')
            ->allowEmptyString('standard');
        
        $validator
            ->boolean('active')
            ->allowEmptyString('active');


        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->integer('valuestandard')
            ->allowEmptyString('valuestandard');

        return $validator;
    }
}
