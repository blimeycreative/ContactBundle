<?php

namespace Oxygen\ContactBundle\Tests\Utility;

use Oxygen\ContactBundle\Utility\Useful;

class UsefulTest extends \PHPUnit_Framework_TestCase{
  
  public function testStripper(){
    $stripped = Useful::stripper("\n   tes  &nbsp;t");
    $this->assertEquals("test", $stripped);
  }
  
  public function testRandomString(){
    $test_length = 15;
    $random = Useful::randomString($test_length);
    $this->assertRegExp("/[0-9A-Za-z]{{$test_length}}/", $random);
  }
  
  public function testSlugify(){
    $slug = Useful::slugify('This -Is a Test #* *', '_');
    $this->assertEquals('this_is_a_test', $slug);
  }
}
