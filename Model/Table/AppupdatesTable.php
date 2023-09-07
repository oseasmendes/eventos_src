<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Appupdates Model
 *
 * @method \App\Model\Entity\Appupdate newEmptyEntity()
 * @method \App\Model\Entity\Appupdate newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Appupdate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Appupdate get($primaryKey, $options = [])
 * @method \App\Model\Entity\Appupdate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Appupdate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Appupdate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Appupdate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Appupdate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Appupdate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Appupdate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Appupdate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Appupdate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AppupdatesTable extends Table
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

        $this->setTable('appupdates');
        $this->setDisplayField('id');
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
            ->scalar('doc')
            ->maxLength('doc', 45)
            ->allowEmptyString('doc');

        $validator
            ->scalar('module')
            ->maxLength('module', 45)
            ->allowEmptyString('module');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('technicaldescription')
            ->maxLength('technicaldescription', 4294967295)
            ->allowEmptyString('technicaldescription');

        $validator
            ->boolean('prd')
            ->allowEmptyString('prd');

        $validator
            ->date('prddate')
            ->allowEmptyDate('prddate');

        $validator
            ->boolean('tst')
            ->allowEmptyString('tst');

        $validator
            ->date('tstdate')
            ->allowEmptyDate('tstdate');

        $validator
            ->boolean('dev')
            ->allowEmptyString('dev');

        $validator
            ->date('devdate')
            ->allowEmptyDate('devdate');

        $validator
            ->integer('linereference')
            ->allowEmptyString('linereference');

        $validator
            ->integer('linereferenceuntil')
            ->allowEmptyString('linereferenceuntil');

        $validator
            ->scalar('status')
            ->maxLength('status', 45)
            ->allowEmptyString('status');

        $validator
            ->scalar('valor')
            ->maxLength('valor', 45)
            ->allowEmptyString('valor');

        $validator
            ->scalar('changetype')
            ->maxLength('changetype', 45)
            ->allowEmptyString('changetype');

        $validator
            ->integer('ordem')
            ->allowEmptyString('ordem');


        return $validator;
    }
}
