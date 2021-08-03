<?php

include_once 'src/Constants.php';
class FinalResult {
    function results($f) {
        //exception handling for file open functions
        //we can also use array_map instead of fopen
         try
            {
            if ( !file_exists($f) ) {
                throw new Exception(Constants::fileNotFoundMessage);
            }
        
            $d = fopen($f, "r");
            if ( !$d ) {
                 throw new Exception(Constants::fileNotOpenMessage);
            }
             
            //removing fixed count looping so that the code is extensible even if more than 16 lines of data is put in the csv
            $isFirstLine = true;
            $rcs = [];
            while (($data = fgetcsv($d)) !== FALSE) 
            {
                if(!$isFirstLine){
                    $amt =  (float) $data[8] ?? "0" ;
                    $ban = !$data[6] ? Constants::bankAccountNumberMissingMessage : (int) $data[6];
                    $bac = !$data[2] ? Constants::bankBranchCodeMissingMessage : $data[2];
                    $e2e = !$data[10] && !$data[11] ? Constants::bankAccountNumberMissingMessage : $data[10] . $data[11];
                    
                    $rcd = [
                            "amount" => [
                                "currency" => $h[0],
                                "subunits" => (int) ($amt * 100)
                            ],
                            "bank_account_name" => str_replace(" ", "_", strtolower($data[7])),
                            "bank_account_number" => $ban,
                            "bank_branch_code" => $bac,
                            "bank_code" => $data[0],
                            "end_to_end_id" => $e2e,
                        ];
                    $rcs[] = $rcd; 
                } else {
                    $h = $data;
                    $isFirstLine = false;
                }
                
            }
            
            //closing the file
            fclose($d);
            $rcs = array_filter($rcs);
            return [
                        "filename" => basename($f),
                        "document" => $d,
                        "failure_code" => $h[1],
                        "failure_message" => $h[2],
                        "records" => $rcs
                    ];
    } catch ( Exception $e ) {
           return [
                "filename" => basename($f),
                "document" => Constants::fileErrorDocumentName,
                "failure_code" => Constants::fileErrorCode,
                "failure_message" => $e->getMessage(),
                "records" => []
            ];
        }
    }
}

?>
