<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roleventsimgs Model
 *
 * @property \App\Model\Table\RoleventsTable&\Cake\ORM\Association\BelongsTo $Rolevents
 *
 * @method \App\Model\Entity\Roleventsimg newEmptyEntity()
 * @method \App\Model\Entity\Roleventsimg newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Roleventsimg[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Roleventsimg get($primaryKey, $options = [])
 * @method \App\Model\Entity\Roleventsimg findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Roleventsimg patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Roleventsimg[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Roleventsimg|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Roleventsimg saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Roleventsimg[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Roleventsimg[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Roleventsimg[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Roleventsimg[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoleventsimgsTable extends Table
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

        $this->setTable('roleventsimgs');
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
            ->maxLength('description', 250)
            ->allowEmptyString('description');

        $validator
            ->scalar('filepath')
            ->maxLength('filepath', 250)
            ->allowEmptyFile('filepath');

        $validator
            ->scalar('filename')
            ->maxLength('filename', 250)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('filenameoriginal')
            ->maxLength('filenameoriginal', 250)
            ->allowEmptyFile('filenameoriginal');

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');

        $validator
            ->boolean('fileselection')
            ->allowEmptyFile('fileselection');

        $validator
            ->scalar('docsystemtype')
            ->maxLength('docsystemtype', 45)
            ->allowEmptyString('docsystemtype');

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
