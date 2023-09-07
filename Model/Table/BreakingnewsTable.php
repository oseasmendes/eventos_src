<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Breakingnews Model
 *
 * @method \App\Model\Entity\Breakingnews newEmptyEntity()
 * @method \App\Model\Entity\Breakingnews newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Breakingnews[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Breakingnews get($primaryKey, $options = [])
 * @method \App\Model\Entity\Breakingnews findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Breakingnews patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Breakingnews[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Breakingnews|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Breakingnews saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Breakingnews[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Breakingnews[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Breakingnews[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Breakingnews[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BreakingnewsTable extends Table
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

        $this->setTable('breakingnews');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rolevents', [
            'foreignKey' => 'rolevent_id',
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
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('details')
            ->maxLength('details', 4294967295)
            ->allowEmptyString('details');

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');

        $validator
            ->date('expirationdate')
            ->allowEmptyDate('expirationdate');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['rolevent_id'], 'Rolevents'), ['errorField' => 'rolevent_id']);

        return $rules;
    }
}
