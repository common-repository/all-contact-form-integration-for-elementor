<?php

class CSVExport {
    // Declare the property directly within the class
    private $table_name = 'db_element_form';
    private $separator = ',';
    private $db;

    /**
    * Constructor
    */
    public function __construct(){
        global $wpdb;
        $this->db = $wpdb;

        // No need to dynamically create $this->table_name here
        // $this->table_name = 'db_element_form';                               
        // $this->separator = ',';

        if(isset($_GET['page']) && $_GET['page'] == 'export_submission_data_csv'){ 

            $filename = 'db_element_form';
            $generatedDate = date('(d-m-Y) (H:i:s)');

            $csvFile = $this->generate_csv();
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . $filename . " " . $generatedDate . ".csv\";" );
            header("Content-Transfer-Encoding: binary");

            echo $csvFile;
            exit();
        }
    }

    /**
    * Generate CSV data
    */
    private function generate_csv(){

        $csv_output = fopen('php://temp', 'w+'); // Open a temporary file handle

        $table = $this->db->prefix . $this->table_name;

        $result = $this->db->get_results("SHOW COLUMNS FROM " . $table . "");

        if (count($result) > 0) {
            $header = array();
            foreach($result as $row) {
                $header[] = $row->Field;
            }
            fputcsv($csv_output, $header); // Write header row
        }

        $values = $this->db->get_results("SELECT * FROM " . $table . "");

        foreach ($values as $rowr) {
            $fields = array_values((array) $rowr); 
            $data = unserialize($fields['7']); 
            
            $mesagedataimp = implode('; ', array_map(function ($entry) {
                return $entry['label'] .' : ' .$entry['value'] ;
            }, $data));
        
            $fields[7] = $mesagedataimp;
            fputcsv($csv_output, $fields); // Write data row
        }

        rewind($csv_output); // Move pointer to beginning of the file
        $csv_content = stream_get_contents($csv_output); // Read from the temporary file handle
        fclose($csv_output); // Close the file handle

        return $csv_content;
    }
}

// Instantiate a singleton of this plugin
$csvExport = new CSVExport();
