<?php


class A{
    function name(){
        return "samandar";
    }
}
class B{
    function lname(){
        return "azamov";
    }
}

function getname(B $name){
    echo $name->lname();
}

getname(new B);