<?php
      
class Constants {
  const bankAccountNumberMissingMessage = 'Bank account number missing';
  const bankBranchCodeMissingMessage = 'Bank branch code missing';
  const bankEndToEndIDMissingMessage = 'End to end id missing';
  const sampleCsvPath = 'tests/support/data_sample.csv';
  
  const generalFailureCode = 100;
  const generalFailureMessage = 'All systems go';
  
  const fileErrorCode = 150; //Custom Error Code. Can be changed according to the code repository standards
  const fileErrorDocumentName = 'No FileName';
  const fileNotFoundMessage = 'File not found.';
  const fileNotOpenMessage = 'File open failed.';

}

?>
