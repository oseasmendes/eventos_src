<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Doctypes Model
 *
 * @property \App\Model\Table\SubscriptionsdocsTable&\Cake\ORM\Association\HasMany $Subscriptionsdocs
 *
 * @method \App\Model\Entity\Doctype newEmptyEntity()
 * @method \App\Model\Entity\Doctype newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Doctype[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Doctype get($primaryKey, $options = [])
 * @method \App\Model\Entity\Doctype findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Doctype patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Doctype[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Doctype|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Doctype saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Doctype[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Doctype[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Doctype[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Doctype[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DoctypesTable extends Table
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

        $this->setTable('doctypes');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Subscriptionsdocs', [
            'foreignKey' => 'doctype_id',
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

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');

        return $validator;
    }
}
