<?php
    function dateFormat($date){
        $splittedDate = explode('-', $date);
        $finalDate = $splittedDate[2];

        switch($splittedDate[1]){
            case 1: $finalDate .= '-01-'; break;
            case 2: $finalDate .= '-02-'; break;
            case 3: $finalDate .= '-03-'; break;
            case 4: $finalDate .= '-04-'; break;
            case 5: $finalDate .= '-05-'; break;
            case 6: $finalDate .= '-06-'; break;
            case 7: $finalDate .= '-07-'; break;
            case 8: $finalDate .= '-08-'; break;
            case 9: $finalDate .= '-09-'; break;
            case 10: $finalDate .= '-10-'; break;
            case 11: $finalDate .= '-11-'; break;
            case 12: $finalDate .= '-12-'; break;
        }

        $finalDate .= $splittedDate[0];
        return $finalDate;
    }
?>