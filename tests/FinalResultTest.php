<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase; 
include_once 'src/FinalResult.php';
//replacing include with include_once since we need to include this file only once 


final class FinalResultTest extends TestCase
{
    private $expected_return = [
        "filename"=>Constants::sampleCsvPath,
        "failure_code"=>Constants::generalFailureCode,
        "failure_message"=>Constants::generalFailureMessage,
        "records" => Constants::expectedResultArray
    ];

    public function testReturnsTheCorrectHash(): void
    {
        $f = new FinalResult();
        $res = $f->results(Constants::sampleCsvPath);
        
        //The below line can be removed if it is being not used anywhere else. 
        //Since the code snippet is part of a larger code base, it maybe used somewhere and hence not removing it
        unset($res["document"]);
        
        $this->assertEquals($res, $this->expected_return);
        
    }
}
