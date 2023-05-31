<?php
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

function getGeneralName($name){
    $year = Carbon::now()->year;
    $month = Carbon::now()->month;
    $day = Carbon::now()->day;
    $hour = Carbon::now()->hour;
    $minute = Carbon::now()->minute;
    $second = Carbon::now()->second;
    $microsecond = Carbon::now()->microsecond;
    return $year ."_". $month ."_". $day ."_". $hour ."_". $minute ."_". $second ."_". $microsecond ."_". $name; 
}

function convertJalaliToGregorianDate($date){
    if($date == null){
        return null;
    }
    $standardDate = str_replace("/" , "-" , $date);
    $pattern = "/[-\s]/";
    $gregorianDate = Verta::jalaliToGregorian(preg_split( $pattern , $standardDate )[0] ,preg_split( $pattern , $standardDate )[1],preg_split( $pattern , $standardDate )[2]);
    $jalaliToGregorian = implode( "-" , $gregorianDate ) . " " . preg_split( $pattern , $standardDate )[3];
    return $jalaliToGregorian;
}


function discountAmountTotalInCart(){
    $discountAmount = 0;
    foreach (\Cart::getContent() as $item){
        if ($item->attributes->is_sale){
                $discountAmount += ($item->attributes->price - $item->attributes->sale_price) * $item->quantity;
        }
    }
    return $discountAmount;
}

function sendAmountTotalInCart(){
    $sendAmount = 0;
    foreach (\Cart::getContent() as $item){
        $sendAmount += $item->associatedModel->delivery_amount;
        $sendAmount += $item->associatedModel->delivery_amount_per_product * $item->quantity;
    }
    return $sendAmount;
}

?>