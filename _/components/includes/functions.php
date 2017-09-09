<?php

//REDIRECTS THE CURRENT PAGE TO SPECIFIED PAGE
function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("Location:{$location}");
        exit;
    }
}

//Validate Phone
function valid_phone($phone) {
    //preg_match("/^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}$/", $phone_fax) () xxx-xxxx
    //preg_match("/^[0-9]{3}-[0-9]{4}$/", $phone_fax) xxx-xxxx
    //preg_match("/^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}[, ]+$/", $phone_fax) () xxx-xxxx
    //preg_match("/^[0-9]{3}-[0-9]{4}[, ]+$/", $phone_fax) xxx-xxxx
    //preg_match("/^((\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+?|([0-9]{3}-[0-9]{4}\,?\s?)+?|([0-9]{11}\,?\s?)+?|([0-9]{4}-[0-9]{7}\,?\s?)+?)+?$/")

    if (preg_match("/^((\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+?|([0-9]{3}-[0-9]{4}\,?\s?)+?|([0-9]{11}\,?\s?)+?|([0-9]{4}-[0-9]{7}\,?\s?)+?)+?$/", $phone)) {
        // $phone is valid
        return TRUE;
    } else {
        return FALSE;
    }

    // if(preg_match("/^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}+[, ]?/", $phone) || preg_match("/^[0-9]{3}-[0-9]{4}+[, ]?/", $phone) || preg_match("/^[0-9]{7}+[, ]?/", $phone)|| preg_match("/^[0-9]{11}+[, ]?/", $phone)|| preg_match("/^[0-9]{4}-[0-9]{7}+[, ]?/", $phone)) {
    // // $phone is valid
    // return TRUE;
    // }else{ return FALSE; }
}

//validate Fax
function valid_fax($fax) {
    if (preg_match("/^((\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}\,?\s?)+?|([0-9]{3}-[0-9]{4}\,?\s?)+?|([0-9]{11}\,?\s?)+?|([0-9]{4}-[0-9]{7}\,?\s?)+?)+?$/", $fax)) {
        //if(preg_match("/^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}$/", $fax) || preg_match("/^[0-9]{3}-[0-9]{4}$/", $fax)) {
        // $phone is valid
        return TRUE;
    } else {
        return FALSE;
    }

    // if(preg_match("/^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}+[, ]?/", $fax) || preg_match("/^[0-9]{3}-[0-9]{4}+[, ]?/", $fax) || preg_match("/^[0-9]{7}+[, ]?/", $fax)) {
    // //if(preg_match("/^\(?\d{3}\)?[-\.\s]?\d{3}[-\.\s]?\d{4}$/", $fax) || preg_match("/^[0-9]{3}-[0-9]{4}$/", $fax)) {
    // // $phone is valid
    // return TRUE;
    // }else{return FALSE;}
}

//Validate Email
function valid_email($str) {
    $match = "/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD";
    if (preg_match($match, $str)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//Validate Item Price
// function valid_price($price){
// if(preg_match("/^(\d|-)?(\d|,\d{3})*\.?\d*$/", $price)) {
// // $price is valid
// return TRUE;
// }else{
// return FALSE;
// }
// }

function valid_price($price) {
    //("/^(\d{1,3}\,)*(\d{1,3})?(\.\d{2})?$/", $price)) 
    if (preg_match("/^(\d{1,3}\,)*(\d{1,3})?(\.\d{2})?$/", $price)) {
        // $price is valid
        return TRUE;
    } else {
        return FALSE;
    }
}

function image_resize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
        $w = $h * $scale_ratio;
    } else {
        $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif") {
        $img = imagecreatefromgif($target);
    } else if ($ext == "png") {
        $img = imagecreatefrompng($target);
    } else {
        $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
}

//END image_resize 
//COUNTING ENTRIES BY BUSINESS TYPE
function count_business_item($obj = "") {
    $business = new Business();
    $business->businessType = "$obj";
    $businessObject = Business::find_by_businessType($business->businessType);
    if (!empty($businessObject)) {
        $item_count = (int) count($businessObject);
        echo "<span  style=\"font-size: .85em; color: #999999;\">" . "(" . $item_count . ")" . "</span>";
    } else {
        $item_count = '0';
        echo "<span  style=\"font-size: .85em; color: #999999;\">" . "(" . $item_count . ")" . "</span>";
    }
}

//END COUNTING ENTRIES BY BUSINESS TYPE	
//COUNTING ENTRIES BY BUSINESS TYPE
function count_business_item_modified($obj = "") {
    $business = new Business();
    $business->businessType = $obj;
    $businessCount = Business::count_by_businessType($business->businessType);
    echo "$businessCount";
    // if (!empty($businessCount)){
    // 	$item_count = (int)count($businessCount);
    // 	echo "<span  style=\"font-size: .85em; color: #999999;\">"."(".$item_count.")"."</span>";
    // }else {	
    // 	$item_count = '0';
    // 	echo "<span  style=\"font-size: .85em; color: #999999;\">"."(".$item_count.")"."</span>";
    // }
}

//END COUNTING ENTRIES BY BUSINESS TYPE
//COUNTING ENTRIES BY ITEM TYPE
function count_item($obj = "") {
    $item = new Item();
    $item->itemCategory = "$obj";
    $itemObject = Item::find_by_itemCategory($item->itemCategory);
    if (!empty($itemObject)) {
        $item_count = (int) count($itemObject);
        echo "<span  style=\"font-size: .85em; color: #999999;\">" . "(" . $item_count . ")" . "</span>";
    } else {
        $item_count = '0';
        echo "<span  style=\"font-size: .85em; color: #999999;\">" . "(" . $item_count . ")" . "</span>";
    }
}

//END COUNTING ENTRIES BY ITEM TYPE

function removeslashes($string) {
    $order = array('\r\n', '\n', '\r');
    $replace = array('<br />', '<br />', '<br />');
    $clean_description = str_replace($order, $replace, "$string");
    //$sanitized=implode("",explode("\\",$clean_description));
    $sanitized = str_replace('\\', '', $clean_description);
    return stripslashes(trim($sanitized));
}

//BEGIN TIME FUNCTION makeAgo()
function makeAgo($timestamp = 0) {
    $computedTime = time() - $timestamp;
    $Aminute = 60;
    $Ahour = $Aminute * 60;
    $Aday = $Ahour * 24;
    $Aweek = $Aday * 7;
    $Amonth = $Aweek * 4;
    $Ayear = $Amonth * 12;
    $Adecade = $Amonth * 10;
    $messageTimeSeconds = $computedTime + 1;
    $messageTimeMinutes = round($computedTime / $Aminute, 0);
    $messageTimeHours = round($computedTime / $Ahour, 0);
    $messageTimeDays = round($computedTime / $Aday, 0);
    $messageTimeWeeks = round($computedTime / $Aweek, 0);
    $messageTimeMonths = round($computedTime / $Amonth, 0);
    $messageTimeYears = round($computedTime / $Ayear, 0);
    $messageTimeDecade = round($computedTime / $Adecade, 0);


    //if $computedTime < 1 minute (/60)
    if ($computedTime < $Aminute) {
        return "$messageTimeSeconds" . " " . "seconds ago";
    }
    //else if $computedTime < 1 hour(/(60*60))
    else if ($computedTime < $Ahour) {
        return "$messageTimeMinutes" . " " . "miniutes ago";
    }
    //else if $computedtime < 1 day (/(60*60*24))
    else if ($computedTime < $Aday) {
        return "$messageTimeHours" . " " . "hours ago";
    }
    //else if $computedTime < 1 week (/(60*60*24*7))
    else if ($computedTime < $Aweek) {
        return "$messageTimeDays" . " " . "days ago";
    }
    //else if $computedTime < 1 month (/(60*60*24*7*4))
    else if ($computedTime < $Amonth) {
        return "$messageTimeWeeks" . " " . "weeks ago";
    }
    //else if $computedTime < 1 year (/(60*60*24*7*30*12))
    else if ($computedTime < $Ayear) {
        return "$messageTimeMonths" . " " . "months ago";
    }
    //else if $computedTime < 10 years (/(60*60*24*7*30*12*10))
    else if ($computedTime < $Adecade) {
        return "$messageTimeYears" . " " . "years ago";
    }
}

//END TIME FUNCTION makeAgo()
?>