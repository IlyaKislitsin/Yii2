<?php
namespace frontend\tests;

use frontend\models\ContactForm;

class HomeworkTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $string = 'Первый тест!';
        $this->assertTrue('Первый тест!' === $string);
        $string1 = 'Это второй тест!';
        $string2 = 'Это второй тест!';
        $this->assertEquals($string1, $string2);
        $num1 = 5;
        $num2 = 3;
        $this->assertLessThan($num1, $num2);
        $object = new ContactForm();
        $object->attributes = [
            'name' => 'Ilya',
            'email' => 'ilya@example.com',
            'subject' => 'This is my subject',
            'body' => 'bla bla bla',
        ];
        $this->assertAttributeEquals('ilya@example.com', 'email', $object);
        $array = [1, 2, 3, 4, 5];
        $num = 3;
        $this->assertArrayHasKey($num, $array);
    }
}