<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Civilstatus Model
 *
 * @method \App\Model\Entity\Civilstatus newEmptyEntity()
 * @method \App\Model\Entity\Civilstatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Civilstatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Civilstatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\Civilstatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Civilstatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Civilstatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Civilstatus|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Civilstatus saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Civilstatus[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Civilstatus[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Civilstatus[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Civilstatus[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CivilstatusTable extends Table
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

        $this->setTable('civilstatus');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('originid')
            ->allowEmptyString('originid');

        $validator
            ->scalar('description')
            ->maxLength('description', 45)
            ->allowEmptyString('description');

        $validator
            ->integer('seq')
            ->allowEmptyString('seq');

        return $validator;
    }
}
