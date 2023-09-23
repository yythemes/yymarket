<?php
namespace vessel\ext;

function products_excerpt_lenght($excerpt){
    if(mb_strlen($excerpt)>48){
        return mb_substr($excerpt, 0, 48).'...';
    }
    else{
        return $excerpt;
    }
}

function product_excerpt_lenght($excerpt){
    if(mb_strlen($excerpt)>500){
        return mb_substr($excerpt, 0, 500).'...';
    }
    else{
        return $excerpt;
    }
}