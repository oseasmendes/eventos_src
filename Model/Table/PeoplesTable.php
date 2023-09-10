<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Peoples Model
 *
 * @property \App\Model\Table\BussinessunitsTable&\Cake\ORM\Association\BelongsTo $Bussinessunits
 * @property \App\Model\Table\PositionsTable&\Cake\ORM\Association\BelongsTo $Positions
 * @property \App\Model\Table\DistrictsTable&\Cake\ORM\Association\BelongsTo $Districts
 * @property \App\Model\Table\CitiesTable&\Cake\ORM\Association\BelongsTo $Cities
 * @property \App\Model\Table\CivilstatusTable&\Cake\ORM\Association\BelongsTo $Civilstatus
 * @property \App\Model\Table\ConditionsTable&\Cake\ORM\Association\BelongsTo $Conditions
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\People newEmptyEntity()
 * @method \App\Model\Entity\People newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\People[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\People get($primaryKey, $options = [])
 * @method \App\Model\Entity\People findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\People patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\People[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\People|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\People saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\People[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\People[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\People[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\People[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PeoplesTable extends Table
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

        $this->setTable('peoples');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Bussinessunits', [
            'foreignKey' => 'bussinessunit_id',
        ]);
        $this->belongsTo('Positions', [
            'foreignKey' => 'position_id',
        ]);
        $this->belongsTo('Districts', [
            'foreignKey' => 'district_id',
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'citie_id',
        ]);
        $this->belongsTo('Civilstatus', [
            'foreignKey' => 'civilstatu_id',
        ]);
        $this->belongsTo('Conditions', [
            'foreignKey' => 'condition_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);

        $this->hasMany('Subscriptions', [
            'foreignKey' => 'people_id',
        ]);

        $this->hasMany('Singlesubscriptions', [
            'foreignKey' => 'people_id',
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
            ->integer('originid')
            ->allowEmptyString('originid');

        $validator
            ->scalar('bussinessunitname')
            ->maxLength('bussinessunitname', 255)
            ->allowEmptyString('bussinessunitname');

        $validator
            ->scalar('positiondescription')
            ->maxLength('positiondescription', 255)
            ->allowEmptyString('positiondescription');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 1)
            ->allowEmptyString('gender');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('street')
            ->maxLength('street', 255)
            ->allowEmptyString('street');

        $validator
            ->scalar('streetcomplement')
            ->maxLength('streetcomplement', 255)
            ->allowEmptyString('streetcomplement');

        $validator
            ->scalar('districtname')
            ->maxLength('districtname', 255)
            ->allowEmptyString('districtname');

        $validator
            ->scalar('unitfederation')
            ->maxLength('unitfederation', 255)
            ->allowEmptyString('unitfederation');

        $validator
            ->scalar('citiesname')
            ->maxLength('citiesname', 255)
            ->allowEmptyString('citiesname');

        $validator
            ->scalar('civilstatusdescrition')
            ->maxLength('civilstatusdescrition', 50)
            ->allowEmptyString('civilstatusdescrition');

        $validator
            ->scalar('postalcode')
            ->maxLength('postalcode', 10)
            ->allowEmptyString('postalcode');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 12)
            ->allowEmptyString('mobile')
            ->add('mobile', 'numeric', ['rule' => 'numeric','message' => 'Inserir apenas numeros'])            
            ;

        $validator
            ->scalar('phonehome')
            ->maxLength('phonehome', 12)
            ->allowEmptyString('phonehome');

        $validator
            ->scalar('whatsapp')
            ->maxLength('whatsapp', 12)
            ->allowEmptyString('whatsapp');

        $validator
            ->date('birthdate')
            ->allowEmptyDate('birthdate');

        $validator
            ->scalar('photopath')
            ->maxLength('photopath', 255)
            ->allowEmptyString('photopath');

        $validator
            ->scalar('photoname')
            ->maxLength('photoname', 255)
            ->allowEmptyString('photoname');

        $validator
            ->integer('origin')
            ->allowEmptyString('origin');

        $validator
            ->integer('prio')
            ->allowEmptyString('prio');

        $validator
            ->scalar('origindescription')
            ->maxLength('origindescription', 255)
            ->allowEmptyString('origindescription');

        $validator
            ->scalar('conditiondescription')
            ->maxLength('conditiondescription', 255)
            ->allowEmptyString('conditiondescription');

        $validator
            ->scalar('integrationguid')
            ->maxLength('integrationguid', 255)
            ->allowEmptyString('integrationguid');

        $validator
            ->boolean('preinput')
            ->allowEmptyString('preinput');

        
        $validator
            ->scalar('idocnumber')
            ->maxLength('idocnumber', 11)
            ->requirePresence('idocnumber', 'create')
            ->notEmptyString('idocnumber')
            ->add('idocnumber', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('idocnumber', 'numeric', ['rule' => 'numeric','message' => 'Inserir apenas numeros'])            
            ;
           

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
        $rules->add($rules->existsIn(['bussinessunit_id'], 'Bussinessunits'), ['errorField' => 'bussinessunit_id']);
        $rules->add($rules->existsIn(['position_id'], 'Positions'), ['errorField' => 'position_id']);
        $rules->add($rules->existsIn(['district_id'], 'Districts'), ['errorField' => 'district_id']);
        $rules->add($rules->existsIn(['citie_id'], 'Cities'), ['errorField' => 'citie_id']);
        $rules->add($rules->existsIn(['civilstatu_id'], 'Civilstatus'), ['errorField' => 'civilstatu_id']);
        $rules->add($rules->existsIn(['condition_id'], 'Conditions'), ['errorField' => 'condition_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
