<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sysapps Model
 *
 * @property \App\Model\Table\SysadminsTable&\Cake\ORM\Association\HasMany $Sysadmins
 *
 * @method \App\Model\Entity\Sysapp newEmptyEntity()
 * @method \App\Model\Entity\Sysapp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Sysapp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sysapp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sysapp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Sysapp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sysapp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sysapp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sysapp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sysapp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysapp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysapp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Sysapp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SysappsTable extends Table
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

        $this->setTable('sysapps');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Sysadmins', [
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
            ->scalar('description')
            ->maxLength('description', 45)
            ->allowEmptyString('description');

        return $validator;
    }
}
