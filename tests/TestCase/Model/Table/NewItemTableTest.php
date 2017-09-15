<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NewItemTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NewItemTable Test Case
 */
class NewItemTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NewItemTable
     */
    public $NewItem;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.new_item'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NewItem') ? [] : ['className' => 'App\Model\Table\NewItemTable'];
        $this->NewItem = TableRegistry::get('NewItem', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NewItem);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
