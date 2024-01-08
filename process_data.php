<?php
    session_start();
    // ajax-partyName-search.php
    $user_id = $_SESSION["id"];
    $user_name = $_SESSION["user"];
    $page_name = "CaseLaws";
    $search_in = "Advance Search";
    $db_pwd = '!e_Z38]cTAmY';
    $db_user = 'vilgstnewmay_new_user';
    $database = 'vilgstnewmay_vilgstprod';

    $connect = new PDO("mysql:host=localhost;dbname=$database", "$db_user", "$db_pwd");
    //$connect = new PDO("mysql:host=localhost;dbname=vilgst12_vilgstprod", "root", "");

    if (isset($_POST["query"])) {

        $userText = $_POST["query"];

        $data = array();

        $table = array("casedata_vat", "casedata_st", "casedata_ce", "casedata_cu", "casedata_sgst");

        //$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $userText);

        foreach ($table as $tbl) {
            $variable = explode(" ", $userText);
            foreach($variable as $v){
                $cond = "(party_name LIKE '" . $v . "%' OR party_name LIKE '%" . $v . "' OR party_name LIKE '%" . $v . "%')";
            }
            
            $query = "
            SELECT * FROM $tbl
                WHERE $cond 
                ORDER BY circular_date DESC 
                LIMIT 10
            ";
            
            $result = $connect->query($query);

            // $replace_string = '<b>'.$condition.'</b>';

            $replace_string = '<b style="text-transform:uppercase;" >'.$userText.'</b>';

            foreach ($result as $row) {
                $data[] = array(
                    'party_name'    =>  str_ireplace($userText, $replace_string, $row["party_name"])
                );
            }
        }

        echo json_encode($data);
    }

    $post_data = json_decode(file_get_contents('php://input'), true);

    //console.log($post_data);

    if (isset($post_data['party_name'])) {
        $data = array(
            ':party_name'   =>  $post_data['party_name']
        );

        $query = "
            SELECT search_id FROM search_history
            WHERE party_name = :party_name
        ";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        if ($statement->rowCount() == 0) {
            $query = "
                INSERT INTO search_history (`user_id`, `user_name`, `party_name`, `pagename`, `search_in`) VALUES ($user_id, $user_name, :party_name, $page_name, $search_in)
            ";

            $statement = $connect->prepare($query);

            $statement->execute($data);
        }

        $output = array(
            'success'   =>  true
        );

        echo json_encode($output);
    }

    if (isset($post_data['action'])) {
        //$data = array($user_id);
        $query = "SELECT DISTINCT party_name, user_id FROM search_history ORDER BY search_id DESC LIMIT 5";

        $result = $connect->query($query);

        //$data = array();

        foreach ($result as $row) {
            
            if ($row['user_id'] == $user_id) {

                $data[] = $row['party_name'];
            }
        }

        echo json_encode($data);
    }
?>