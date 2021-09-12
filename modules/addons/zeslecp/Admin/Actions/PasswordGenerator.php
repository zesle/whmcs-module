<?php

function generatePassword($u, $l, $n, $s, $passwordLength) {
    // Required at least 2 upper case
    $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ";
    $uppercase = substr(str_shuffle($chars), 0, $u);

    // Required at least 2 lower case
    $chars = "abcdefghjkmnpqrstuvwxyz";
    $lowercase = substr(str_shuffle($chars), 0, $l);

    // Required at least 2 numeric
    $chars = "0123456789";
    $number = substr(str_shuffle($chars), 0, $n);

    // Required at least 2 specialist characters
    $chars = ",@)%_]>!}$<(*={#[";
    $specialsharaters = substr(str_shuffle($chars), 0, $s);
    $required = $uppercase . $lowercase . $number . $specialsharaters;
    
    // Other optional password characters
    $length = $passwordLength - ($u + $l + $n + $s)-2;
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,@)%_]>!}$<(*={#[";
    $optional = substr(str_shuffle($chars), 0, $length);
    return str_shuffle($required . $optional."^.");
}

echo $password = generatePassword(2, 2, 2, 2, 14);


