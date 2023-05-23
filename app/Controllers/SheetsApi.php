<?php

namespace App\Controllers;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Drive;
use Exception as GlobalException;
use Google\Service\Sheets\Request;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\ValueRange;

class SheetsApi extends BaseController
{        
    protected $sheetGoogle;    

    // Digunakan untuk melakukan authentikasi user atau login kedalam akun google
    public function __construct(){
        $authGoogle = new Client();
        $driveGoogle = new Drive();                      
        $authGoogle->setAuthConfig('auth.json'); //auth.json didapatkan dari web google bagian key API
        $authGoogle->addScope($driveGoogle::DRIVE);     
        // var_dump($authGoogle);die;
        $this->sheetGoogle = new Sheets($authGoogle);
        // var_dump($this->sheetGoogle);die;        
    }

    // Digunakan Untuk Mengambil Data Dalam Cell Spreadsheet
    public function getValues($spreadsheetId,$range){           
        $result = $this->sheetGoogle->spreadsheets_values->get($spreadsheetId, $range);
        try{
            $numRows = $result->getValues() != null ? count($result->getValues()) : 0;
            printf($numRows);
            return $result;
        }
        catch(GlobalException $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }                    
    }

    // Digunakan Untuk Menambahkan Data Atau Cell Pada Spreadsheet, Jika Sudah Ada Data Maka Data Yang Ada Akan DiPindahkan ke Bawah
    function appendValues($spreadsheetId, $range, $valueInputOption, $data){            
        try {
            $values = [$data]; //add the values to be appended
            //execute the request
            $body = new Sheets\ValueRange([
                'values' => $values
            ]);
            $params = [
                'valueInputOption' => $valueInputOption
            ];
            $result =$this->sheetGoogle->spreadsheets_values->append($spreadsheetId, $range, $body, $params);    
            // printf("%d cells updated.");
            // return $result;            
            return json_encode([
                'status'=> true,
                'data' => $result
            ]);
        } catch (GlobalException $e) {            
            // printf("GAGAL updated. ". $e);
            // return $result;
            return json_encode([
                'status'=> false,
                'data' => $e->getMessage()
            ]);
        }
        // [END sheets_append_values]
    }

    // Untuk Update Secara Keseluruhan Data
    function batchUpdate($spreadsheetId, $title, $find, $replacement){           
        try{
            //execute the request
            $requests = [
                $req = new Request([
              'updateSpreadsheetProperties' => [
                  'properties' => [
                      'title' => $title
                    ],
                'fields' => 'title'
                ]
            ]),
            $req = new Request([
                'findReplace' => [
                    'find' => $find,
                    'replacement' => $replacement,
                    'allSheets' => true
                    ]
                ])
            ];

            $batchUpdateRequest = new BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);
            $response = $this->sheetGoogle->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);            
        }    
        catch(GlobalException $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }

    // Digunakan Untuk Update Value Didalam Cell
    public function valueUpdate($spreadsheetId, $range, $valueInputOption,$value){
        try{
            $values = [$value];

            $body = new ValueRange([
                'values' => $values
            ]);

            $params = [
                'valueInputOption' => $valueInputOption
            ];
            //executing the request
            $result = $this->sheetGoogle->spreadsheets_values->update($spreadsheetId, $range,
            $body, $params);
            $result->getUpdatedCells();
            // printf("%d cells updated.", $result->getUpdatedCells());
            // return $result;
            return "Success";
            
        }
        catch(GlobalException $e) {
            return "Failed".$e;
            // TODO(developer) - handle error appropriately
            // printf("GAGAL" .$e);
            // echo 'Message: ' .$e->getMessage();
        }
    }   
    function deleteCells($spreadsheetId, $noCell){           
        try{            
            $requests = [
                new Request([
                    'deleteDimension' => [
                        'range' => [
                            "sheetId" => 0,
                            "dimension" => "ROWS",
                            "startIndex" => $noCell-1,
                            "endIndex" => $noCell,
                        ]                    
                    ]
                ])
            ];            

            $batchUpdateRequest = new BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);
            $response = $this->sheetGoogle->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);            
        }    
        catch(GlobalException $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }
}