<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeftRivsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeftRivsTable Test Case
 */
class LeftRivsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LeftRivsTable
     */
    public $LeftRivs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.left_rivs',
        'app.rivs',
        'app.sales_returns',
        'app.items',
        'app.item_categories',
        'app.item_groups',
        'app.item_sub_groups',
        'app.units',
        'app.sources',
        'app.item_sources',
        'app.companies',
        'app.company_groups',
        'app.customers',
        'app.ledger_accounts',
        'app.account_second_subgroups',
        'app.account_first_subgroups',
        'app.account_groups',
        'app.account_categories',
        'app.ledgers',
        'app.reference_details',
        'app.receipt_vouchers',
        'app.vouchers_references',
        'app.voucher_ledger_accounts',
        'app.financial_years',
        'app.financial_months',
        'app.invoices',
        'app.customer_groups',
        'app.item_ledgers',
        'app.grns',
        'app.purchase_order_rows',
        'app.purchase_orders',
        'app.filenames',
        'app.sales_orders',
        'app.carrier',
        'app.customer_address',
        'app.districts',
        'app.transporters',
        'app.courier',
        'app.quotations',
        'app.employees',
        'app.departments',
        'app.designations',
        'app.employee_contact_persons',
        'app.logins',
        'app.user_rights',
        'app.pages',
        'app.user_logs',
        'app.request_leaves',
        'app.leave_types',
        'app.payments',
        'app.reference_balances',
        'app.bank_cashes',
        'app.received_froms',
        'app.creator',
        'app.employee_companies',
        'app.payment_rows',
        'app.receipts',
        'app.receipt_rows',
        'app.approve_leaves',
        'app.editor',
        'app.terms_conditions',
        'app.quotation_close_reasons',
        'app.quotation_rows',
        'app.customer_contacts',
        'app.tax_details',
        'app.sales_order_rows',
        'app.sale_taxes',
        'app.sale_tax_companies',
        'app.job_card_rows',
        'app.job_cards',
        'app.inventory_voucher_rows',
        'app.inventory_vouchers',
        'app.invoice_rows',
        'app.item_serialnumbers',
        'app.inventory_transfer_vouchers',
        'app.inventory_transfer_voucher_rows',
        'app.item_serial_numbers',
        'app.purchase_returns',
        'app.invoice_bookings',
        'app.invoice_booking_rows',
        'app.grn_rows',
        'app.vendors',
        'app.vendor_contact_persons',
        'app.vendor_companies',
        'app.account_references',
        'app.purchase_return_rows',
        'app.material_indent_rows',
        'app.material_indents',
        'app.challans',
        'app.challan_rows',
        'app.sale_returns',
        'app.sale_return_rows',
        'app.invoice_breakups',
        'app.receipt_breakups',
        'app.payment_vouchers',
        'app.paid_tos',
        'app.payment_breakups',
        'app.credit_notes',
        'app.customer_suppilers',
        'app.heads',
        'app.credit_notes_rows',
        'app.journal_vouchers',
        'app.journal_voucher_rows',
        'app.debit_notes',
        'app.debit_notes_rows',
        'app.nppayments',
        'app.nppayment_rows',
        'app.contra_vouchers',
        'app.contra_voucher_rows',
        'app.petty_cash_vouchers',
        'app.petty_cash_voucher_rows',
        'app.customer_segs',
        'app.customer_companies',
        'app.item_used_by_companies',
        'app.company_banks',
        'app.item_companies',
        'app.right_rivs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LeftRivs') ? [] : ['className' => 'App\Model\Table\LeftRivsTable'];
        $this->LeftRivs = TableRegistry::get('LeftRivs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LeftRivs);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
