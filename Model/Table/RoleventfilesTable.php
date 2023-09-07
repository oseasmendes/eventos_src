<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roleventfiles Model
 *
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 *
 * @method \App\Model\Entity\Roleventfile newEmptyEntity()
 * @method \App\Model\Entity\Roleventfile newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Roleventfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Roleventfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\Roleventfile findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Roleventfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Roleventfile[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Roleventfile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Roleventfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Roleventfile[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Roleventfile[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Roleventfile[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Roleventfile[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoleventfilesTable extends Table
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

        $this->setTable('roleventfiles');
        $this->setDisplayField('id');
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
            ->scalar('filename')
            ->maxLength('filename', 150)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('path')
            ->maxLength('path', 255)
            ->allowEmptyString('path');

        $validator
            ->scalar('originalfilename')
            ->maxLength('originalfilename', 150)
            ->allowEmptyFile('originalfilename');

        $validator
            ->scalar('midiatype')
            ->maxLength('midiatype', 10)
            ->allowEmptyString('midiatype');

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');

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
