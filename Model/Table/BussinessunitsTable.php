<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bussinessunits Model
 *
 * @property \App\Model\Table\OrgsTable&\Cake\ORM\Association\BelongsTo $Orgs
 * @property \App\Model\Table\PeoplesTable&\Cake\ORM\Association\HasMany $Peoples
 *
 * @method \App\Model\Entity\Bussinessunit newEmptyEntity()
 * @method \App\Model\Entity\Bussinessunit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Bussinessunit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bussinessunit get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bussinessunit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Bussinessunit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bussinessunit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bussinessunit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bussinessunit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bussinessunit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bussinessunit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bussinessunit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Bussinessunit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BussinessunitsTable extends Table
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

        $this->setTable('bussinessunits');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orgs', [
            'foreignKey' => 'org_id',
        ]);
        $this->hasMany('Peoples', [
            'foreignKey' => 'bussinessunit_id',
        ]);

        $this->hasMany('Rolevents', [
            'foreignKey' => 'bussinessunit_id',
        ]);

        $this->hasMany('Singlesubscriptions', [
            'foreignKey' => 'bussinessunit_id',
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
            ->integer('oringid')
            ->allowEmptyString('oringid')
            ->add('oringid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->allowEmptyString('description');

        $validator
            ->integer('seq')
            ->allowEmptyString('seq');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('postalcode')
            ->maxLength('postalcode', 45)
            ->allowEmptyString('postalcode');

        $validator
            ->scalar('district')
            ->maxLength('district', 150)
            ->allowEmptyString('district');

        $validator
            ->scalar('city')
            ->maxLength('city', 150)
            ->allowEmptyString('city');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 45)
            ->allowEmptyString('phone');

        $validator
            ->scalar('responsible')
            ->maxLength('responsible', 200)
            ->allowEmptyString('responsible');

        $validator
            ->scalar('sector')
            ->maxLength('sector', 45)
            ->allowEmptyString('sector');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->boolean('general')
            ->allowEmptyString('general');

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
        $rules->add($rules->isUnique(['oringid']), ['errorField' => 'oringid']);
        $rules->add($rules->existsIn(['org_id'], 'Orgs'), ['errorField' => 'org_id']);

        return $rules;
    }
}
