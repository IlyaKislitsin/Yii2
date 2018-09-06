<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class HomeworkCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $example)
    {
        $I->amOnPage($example['url']);
        $I->see($example['h1']);
    }
    /**
     * @return array
     */
    protected function pageProvider() // alternatively, if you want the function to be public, be sure to prefix it with `_`
    {
        return [
            ['url'=>"/", 'h1'=>"Congratulations!"],
            ['url'=>"/site/about", 'h1'=>"About"],
            ['url'=>"/site/contact", 'h1'=>"Contact"],
            ['url'=>"/site/signup", 'h1'=>"Signup"],
            ['url'=>"/site/login", 'h1'=>"Login"],
            ['url'=>"/task", 'h1'=>"Tasks"],
            ['url'=>"/project", 'h1'=>"Projects"]
        ];
    }
}
