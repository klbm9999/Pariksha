<?php 

include "qlib.php";

switch ($_POST['action']) {
    case 'verifySubmission':
        $result = verifySubmission($_POST['submission'],$_POST['integrity']);
        echo $result;
        break;
    default:
        output_error('invalid request');
        break;
}

?>