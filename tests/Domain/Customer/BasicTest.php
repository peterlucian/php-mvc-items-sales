<?php
namespace Bookstore\Tests\Domain\Customer;

use Bookstore\Domain\Customer\Basic;
use PHPUnit\Framework\TestCase;


class BasicTest extends TestCase {
    public function setUp() {
        $this->customer = new Basic('han', 'solo', 'han@solo.com', 1);
    }
    
    public function testAmountToBorrow() {
        $this->assertSame(
            3,
            $this->customer->getAmountToBorrow(),
            'Basic customer should borrow up to 3 books.'
        );
    }
    
    public function testIsExemptOfTaxes() {
        $this->assertFalse(
            $this->customer->isExemptOfTaxes(),
            'Basic customer should be exempt of taxes.'
        );
    }
    
    public function testGetMonthlyFee() {
        $this->assertEquals(
            5, $this->customer->getMonthlyFee(),
            'Basic customer should pay 5 a month.'
        );
    }
    
    /*
    public function testFail() {
        $customer = new Basic('han', 'solo', 'han@solo.com', 1);
        $this->assertSame(
            4,
            $customer->getAmountToBorrow(),
            'Basic customer should borrow up to 3 books.'
        );
    }
    */
    /**
    * @test 
    public function thisIsATestToo() {
        $this->assertTrue(true, 'This test always works.');
    }
    **/
}