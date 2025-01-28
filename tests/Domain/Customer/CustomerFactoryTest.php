<?php
namespace Bookstore\Tests\Domain\Customer;

use PHPUnit\Framework\TestCase;
use Bookstore\Domain\Customer\CustomerFactory;
use Bookstore\Domain\Customer\Basic;

class CustomerFactoryTest extends TestCase {
    public function testFactoryBasic() {
        $customer = CustomerFactory::factory(
            'basic',
            'han',
            'solo',
            'han@solo.com',
            1
        );
        $this->assertInstanceOf(
            Basic::class,
            $customer,
            'basic should create a Customer\Basic object.'
        );
        
        $expectedBasicCustomer = new Basic('han', 'solo', 'han@solo.com', 1);
        $this->assertEquals(
            $customer, $expectedBasicCustomer,
            'Customer object is not as expected.'
        );
    }
    
    /**
    * @expectedException \InvalidArgumentException
    * @expectedExceptionMessage Wrong type.
    */
    public function testCreatingWrongTypeOfCustomer() {
        $customer = CustomerFactory::factory(
            'deluxe', 'han', 'solo', 'han@solo.com', 1
        );
    }
    
    public function providerFactoryValidCustomerTypes() {
        return [ 'Basic customer, lowercase' => [ 
                'type' => 'basic',
                'expectedType' => '\Bookstore\Domain\Customer\Basic'
            ],
            'Basic customer, uppercase' => [
                'type' => 'BASIC',
                'expectedType' => '\Bookstore\Domain\Customer\Basic'
            ],
            'Premium customer, lowercase' => [
                'type' => 'premium',
                'expectedType' => '\Bookstore\Domain\Customer\Premium'
            ],
            'Premium customer, uppercase' => [
                'type' => 'PREMIUM',
                'expectedType' => '\Bookstore\Domain\Customer\Premium'
            ]
        ];
    }
    
    /**
    * @dataProvider providerFactoryValidCustomerTypes
    * @param string $type
    * @param string $expectedType
    */
    public function testFactoryValidCustomerTypes(
        string $type,
        string $expectedType
    ) {
        $customer = CustomerFactory::factory(
            $type, 'han', 'solo', 'han@solo.com', 1
        );
        $this->assertInstanceOf(
            $expectedType, $customer,
            'Factory created the wrong type of customer.'
        );
    }
}