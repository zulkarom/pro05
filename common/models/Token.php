<?php 

namespace common\models;

class Token {
	
	Public function projectKey($length = 6) {
    $characters = '01DF234SDGSDF56789ABCDEFG489HIJKLMN3OPQR433STUVWXKDFGYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	
	
}