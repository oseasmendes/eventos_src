<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Districts Model
 *
 * @property \App\Model\Table\CitiesTable&\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\PeoplesTable&\Cake\ORM\Association\HasMany $Peoples
 *
 * @method \App\Model\Entity\District newEmptyEntity()
 * @method \App\Model\Entity\District newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\District[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\District get($primaryKey, $options = [])
 * @method \App\Model\Entity\District findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\District patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\District[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\District|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\District saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\District[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\District[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\District[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\District[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DistrictsTable extends Table
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

        $this->setTable('districts');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cities', [
            'foreignKey' => 'citie_id',
        ]);
        $this->hasMany('Peoples', [
            'foreignKey' => 'district_id',
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
            ->allowEmptyString('id', null, 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->allowEmptyString('description');

        $validator
            ->integer('originid')
            ->allowEmptyString('originid')
            ->add('originid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('seq')
            ->allowEmptyString('seq');

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
        $rules->add($rules->isUnique(['id']), ['errorField' => 'id']);
        $rules->add($rules->isUnique(['originid']), ['errorField' => 'originid']);
        $rules->add($rules->existsIn(['citie_id'], 'Cities'), ['errorField' => 'citie_id']);

        return $rules;
    }
}
