<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Syscontrols Model
 *
 * @property \App\Model\Table\SysadminsTable&\Cake\ORM\Association\HasMany $Sysadmins
 *
 * @method \App\Model\Entity\Syscontrol newEmptyEntity()
 * @method \App\Model\Entity\Syscontrol newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Syscontrol[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Syscontrol get($primaryKey, $options = [])
 * @method \App\Model\Entity\Syscontrol findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Syscontrol patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Syscontrol[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Syscontrol|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Syscontrol saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Syscontrol[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Syscontrol[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Syscontrol[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Syscontrol[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SyscontrolsTable extends Table
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

        $this->setTable('syscontrols');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Sysadmins', [
            'foreignKey' => 'syscontrol_id',
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
