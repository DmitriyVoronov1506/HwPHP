<?php

echo studingDate();

function studingDate(){
    global $currentYear;
    global $startYear;
    return "Hello from footer! Start at - $startYear. Now - $currentYear";           
}