<?php
namespace Phwoolcon\Tests;

use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;
use Phwoolcon\Db;
use Phwoolcon\Model;

/**
 * Class TestModel
 * @package Phwoolcon\Tests
 *
 * @method string getKey()
 * @method mixed getValue()
 * @method $this setValue(mixed $value)
 */
class TestModel extends Model
{
    protected $_table = 'test_model';
    protected $_pk = 'key';
    protected $_jsonFields = ['value'];

    protected function createTable()
    {
        $db = Db::connection();
        $db->createTable($this->_table, null, [
            'columns' => [
                new Column('key', [
                    'type' => Column::TYPE_VARCHAR,
                    'size' => 32,
                    'notNull' => true,
                    'primary' => true,
                ]),
                new Column('value', [
                    'type' => Column::TYPE_TEXT,
                ]),
                new Column('created_at', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => false,
                ]),
                new Column('updated_at', [
                    'type' => Column::TYPE_BIGINTEGER,
                    'size' => 20,
                    'unsigned' => true,
                    'notNull' => false,
                ]),
            ],
        ]);
    }

    public function initialize()
    {
        parent::initialize();
        $db = Db::connection();
        $db->tableExists($this->_table) or $this->createTable();
        $db->delete($this->_table);
    }

    public function validation()
    {
        $validator = new Validation();
        $validator->add('key', new StringLength([
            'min' => 3,
            'max' => 32,
        ]));
        $this->validate($validator);
        return parent::validation();
    }
}
