<?php

include_once 'src/Constants.php';
class FinalResult {
    function results($f) {
         try
            {
            if ( !file_exists($f) ) {
                throw new Exception(Constants::fileNotFoundMessage);
            }
        
            $d = fopen($f, "r");
            if ( !$d ) {
                 throw new Exception(Constants::fileNotOpenMessage);
            }
            $h = fgetcsv($d);
            $rcs = [];
            while(!feof($d)) {
                $r = fgetcsv($d);
                if(count($r) == 16) {
                    $amt = !$r[8] || $r[8] == "0" ? 0 : (float) $r[8];
                    $ban = !$r[6] ? Constants::bankAccountNumberMissingMessage : (int) $r[6];
                    $bac = !$r[2] ? Constants::bankBranchCodeMissingMessage : $r[2];
                    $e2e = !$r[10] && !$r[11] ? Constants::bankAccountNumberMissingMessage : $r[10] . $r[11];
                    $rcd = [
                        "amount" => [
                            "currency" => $h[0],
                            "subunits" => (int) ($amt * 100)
                        ],
                        "bank_account_name" => str_replace(" ", "_", strtolower($r[7])),
                        "bank_account_number" => $ban,
                        "bank_branch_code" => $bac,
                        "bank_code" => $r[0],
                        "end_to_end_id" => $e2e,
                    ];
                    $rcs[] = $rcd;
                }
        }
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
