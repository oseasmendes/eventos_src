<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ProfilesTable&\Cake\ORM\Association\BelongsTo $Profiles
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\PeoplesTable&\Cake\ORM\Association\HasMany $Peoples
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\HasMany $Subscriptions
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Profiles', [
            'foreignKey' => 'profile_id',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
        ]);
        $this->hasMany('Peoples', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Subscriptions', [
            'foreignKey' => 'user_id',
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
            ->scalar('username')
            ->maxLength('username', 60)
            ->notEmptyString('username');

        $validator
            ->scalar('docnumber')
            ->maxLength('docnumber', 11)
            ->requirePresence('docnumber')
            ->notEmptyString('docnumber')
            ->add('docnumber', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
            ->add('docnumber', 'numeric', ['rule' => 'numeric','message' => 'Inserir apenas numeros'])            
            ;

        $validator
            ->email('email')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->notEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->notEmptyString('name');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 15)
            ->notEmptyString('mobile');
        
           
        $validator
            ->boolean('active')
            ->allowEmptyString('active');
        
        $validator                        
            ->sameAs('confirm_password','password','Senha não confere. Verifique');



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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['docnumber']), ['errorField' => 'docnumber']);
        $rules->add($rules->existsIn(['profile_id'], 'Profiles'), ['errorField' => 'profile_id']);
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
