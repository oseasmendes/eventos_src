<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sysadmins Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\ProfilesTable&\Cake\ORM\Association\BelongsTo $Profiles
 * @property \App\Model\Table\SysactionsTable&\Cake\ORM\Association\BelongsTo $Sysactions
 * @property \App\Model\Table\SyscontrolsTable&\Cake\ORM\Association\BelongsTo $Syscontrols
 * @property \App\Model\Table\SysappsTable&\Cake\ORM\Association\BelongsTo $Sysapps
 *
 * @method \App\Model\Entity\Sysadmin newEmptyEntity()
 * @method \App\Model\Entity\Sysadmin newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Sysadmin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sysadmin get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sysadmin findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Sysadmin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sysadmin[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sysadmin|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sysadmin saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sysadmin[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysadmin[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysadmin[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysadmin[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SysadminsTable extends Table
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

        $this->setTable('sysadmins');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
        ]);
        $this->belongsTo('Profiles', [
            'foreignKey' => 'profile_id',
        ]);
        $this->belongsTo('Sysactions', [
            'foreignKey' => 'sysaction_id',
        ]);
        $this->belongsTo('Syscontrols', [
            'foreignKey' => 'syscontrol_id',
        ]);
        $this->belongsTo('Sysapps', [
            'foreignKey' => 'sysapp_id',
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
            ->scalar('app')
            ->maxLength('app', 45)
            ->allowEmptyString('app');

        $validator
            ->scalar('control')
            ->maxLength('control', 45)
            ->allowEmptyString('control');

        $validator
            ->scalar('act')
            ->maxLength('act', 45)
            ->allowEmptyString('act');

        $validator
            ->integer('value')
            ->allowEmptyString('value');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 45)
            ->allowEmptyString('reference');

        $validator
            ->integer('register')
            ->allowEmptyString('register');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);
        $rules->add($rules->existsIn(['profile_id'], 'Profiles'), ['errorField' => 'profile_id']);
        $rules->add($rules->existsIn(['sysaction_id'], 'Sysactions'), ['errorField' => 'sysaction_id']);
        $rules->add($rules->existsIn(['syscontrol_id'], 'Syscontrols'), ['errorField' => 'syscontrol_id']);
        $rules->add($rules->existsIn(['sysapp_id'], 'Sysapps'), ['errorField' => 'sysapp_id']);

        return $rules;
    }
}
