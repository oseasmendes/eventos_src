<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Unitsfederations Model
 *
 * @property \App\Model\Table\CitiesTable&\Cake\ORM\Association\HasMany $Cities
 *
 * @method \App\Model\Entity\Unitsfederation newEmptyEntity()
 * @method \App\Model\Entity\Unitsfederation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Unitsfederation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Unitsfederation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Unitsfederation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Unitsfederation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Unitsfederation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Unitsfederation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Unitsfederation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Unitsfederation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Unitsfederation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Unitsfederation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Unitsfederation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UnitsfederationsTable extends Table
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

        $this->setTable('unitsfederations');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Cities', [
            'foreignKey' => 'unitsfederation_id',
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
            ->maxLength('description', 110)
            ->allowEmptyString('description');

        $validator
            ->scalar('initials')
            ->maxLength('initials', 2)
            ->allowEmptyString('initials');

        return $validator;
    }
}
