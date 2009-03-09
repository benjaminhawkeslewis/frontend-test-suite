<?php

/**
 * @author  Neil Crosby <neil@neilcrosby.com>
 * @license Creative Commons Attribution-Share Alike 3.0 Unported 
 *          http://creativecommons.org/licenses/by-sa/3.0/
 **/
class TheCodeTrainCssValidatorTestCase_GetValidationErrorTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->obj = new ConcreteCssValidatorTestCase();
        $this->obj->setValidatorUrl('http://127.0.0.1:8080/css-validator/validator');
    }

    public function tearDown() {
    }

    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::invalidValidatorUrlProvider
     **/
    public function testSkipsTestWhenBadUrlGiven($input) {
        $this->obj = new ConcreteCssValidatorTestCase();
        $this->obj->setValidatorUrl($input);
        try {
            $this->obj->getValidationError('<p>whatever</pee>');
        } catch (PHPUnit_Framework_SkippedTestError $e) {
            // If this gets fired, the test has passed. Therefore, return!
            // This is fired because when a test is marked as skipped a
            // PHPUnit_Framework_SkippedTestError error is fired.  We can't
            // test for this the normal way, with a setExpectedException,
            // because doing that still results in the inner test being shown
            // as having been skipped when we run this test.
            return;
        }
        
        // Therefore, if we get to here, the test has failed.
        $this->fail();
    }
    
    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::validCssProvider
     */
    public function testReturnsFalseWhenValidCssTested($input) {
        $errors = $this->obj->getValidationError($input);
        $this->assertFalse($errors);
    }

    /**
     * @dataProvider TheCodeTrainCssValidatorProviders::invalidCssProvider
     */
    public function testReturnsStringWhenInvalidCssTested($input) {
        $errors = $this->obj->getValidationError($input);
        $this->assertType('string', $errors);
    }
}
?>