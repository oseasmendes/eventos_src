<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rolevents Model
 *
 * @property \App\Model\Table\SubscriptionsTable&\Cake\ORM\Association\HasMany $Subscriptions
 *
 * @method \App\Model\Entity\Rolevent newEmptyEntity()
 * @method \App\Model\Entity\Rolevent newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Rolevent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Rolevent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Rolevent findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Rolevent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Rolevent[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Rolevent|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rolevent saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rolevent[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Rolevent[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Rolevent[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Rolevent[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoleventsTable extends Table
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

        $this->setTable('rolevents');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Subscriptions', [
            'foreignKey' => 'rolevent_id',
        ]);

        $this->hasMany('Roleventsimgs', [
            'foreignKey' => 'rolevent_id',
        ]);

        $this->hasMany('Breakingnews', [
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
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('details')
            ->maxLength('details', 4294967295)
            ->allowEmptyString('details');

        $validator
            ->boolean('activeflag')
            ->allowEmptyString('activeflag');

        $validator
            ->date('startdate')
            ->allowEmptyDate('startdate');

        $validator
            ->date('enddate')
            ->allowEmptyDate('enddate');
        
        $validator
            ->date('subscexpirationdate')
            ->allowEmptyDate('subscexpirationdate');

        $validator
            ->date('eventexpirationdate')
            ->allowEmptyDate('eventexpirationdate');           

        $validator
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->boolean('subscriptionrequired')
            ->allowEmptyString('subscriptionrequired');
        
        $validator
            ->email('email')
            ->notEmptyString('email');

        return $validator;
    }
}
