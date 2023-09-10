<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Agendas Model
 *
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 *
 * @method \App\Model\Entity\Agenda newEmptyEntity()
 * @method \App\Model\Entity\Agenda newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Agenda[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Agenda get($primaryKey, $options = [])
 * @method \App\Model\Entity\Agenda findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Agenda patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Agenda[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Agenda|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agenda saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agenda[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agenda[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agenda[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agenda[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AgendasTable extends Table
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

        $this->setTable('agendas');
        $this->setDisplayField('eventdescription');
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
            ->integer('originagendaid')
            ->allowEmptyString('originagendaid');

        $validator
            ->integer('dailyid')
            ->allowEmptyString('dailyid');

        $validator
            ->date('dateevent')
            ->allowEmptyDate('dateevent');

        $validator
            ->scalar('timestart')
            ->maxLength('timestart', 5)
            ->allowEmptyString('timestart');

        $validator
            ->scalar('timeend')
            ->maxLength('timeend', 5)
            ->allowEmptyString('timeend');

        $validator
            ->scalar('dayname')
            ->maxLength('dayname', 15)
            ->allowEmptyString('dayname');

        $validator
            ->integer('daynumber')
            ->allowEmptyString('daynumber');

        $validator
            ->scalar('monthnumber')
            ->maxLength('monthnumber', 10)
            ->allowEmptyString('monthnumber');

        $validator
            ->scalar('monthname')
            ->maxLength('monthname', 11)
            ->allowEmptyString('monthname');

        $validator
            ->integer('weeknumber')
            ->allowEmptyString('weeknumber');

        $validator
            ->integer('year')
            ->allowEmptyString('year');

        $validator
            ->scalar('agendatype')
            ->maxLength('agendatype', 10)
            ->allowEmptyString('agendatype');

        $validator
            ->scalar('sectorname')
            ->maxLength('sectorname', 45)
            ->allowEmptyString('sectorname');

        $validator
            ->scalar('unityorganization')
            ->maxLength('unityorganization', 80)
            ->allowEmptyString('unityorganization');

        $validator
            ->scalar('eventdescription')
            ->maxLength('eventdescription', 100)
            ->allowEmptyString('eventdescription');

        $validator
            ->scalar('placeofevent')
            ->maxLength('placeofevent', 100)
            ->allowEmptyString('placeofevent');

        $validator
            ->scalar('departmentname')
            ->maxLength('departmentname', 45)
            ->allowEmptyString('departmentname');

        $validator
            ->scalar('dayreference')
            ->maxLength('dayreference', 45)
            ->allowEmptyString('dayreference');

        $validator
            ->scalar('obs')
            ->maxLength('obs', 200)
            ->allowEmptyString('obs');

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
        $rules->add($rules->existsIn(['rolevent_id'], 'Rolevents'), ['errorField' => 'rolevent_id']);

        return $rules;
    }
}
