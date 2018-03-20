<?php

function banner_api()
{
    $banners = sqlGetAll('ad','ad_code,ad_link');
    $returnBanner['name'] = "banner";
    for($i=0;$i<count($banners);$i++)
    {
        $returnBanner["item"][$i]["img_url"] = IMG_URL.$banners[$i]['ad_code'];
        $returnBanner["item"][$i]["img_link"] = IMG_URL.$banners[$i]['ad_link'];
    }
    jsonData(200,$returnBanner);
}