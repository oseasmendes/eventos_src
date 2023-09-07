<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orgs Model
 *
 * @property \App\Model\Table\BussinessunitsTable&\Cake\ORM\Association\HasMany $Bussinessunits
 *
 * @method \App\Model\Entity\Org newEmptyEntity()
 * @method \App\Model\Entity\Org newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Org[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Org get($primaryKey, $options = [])
 * @method \App\Model\Entity\Org findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Org patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Org[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Org|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Org saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Org[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Org[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Org[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Org[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrgsTable extends Table
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

        $this->setTable('orgs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Bussinessunits', [
            'foreignKey' => 'org_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('district')
            ->maxLength('district', 155)
            ->allowEmptyString('district');

        $validator
            ->scalar('zipcode')
            ->maxLength('zipcode', 45)
            ->allowEmptyString('zipcode');

        $validator
            ->scalar('city')
            ->maxLength('city', 45)
            ->allowEmptyString('city');

        $validator
            ->scalar('contactfone')
            ->maxLength('contactfone', 25)
            ->allowEmptyString('contactfone');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->dateTime('modifed')
            ->allowEmptyDateTime('modifed');

        return $validator;
    }
}
