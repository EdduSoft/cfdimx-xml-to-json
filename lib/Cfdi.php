<?php

namespace Lib;

use Lib\Cfdi33\Cfdi33;
use Lib\Cfdi40\Cfdi40;
use Lib\Helper;

class Cfdi
{

    /**
     * Undocumented function
     *
     * @param string $xmlString
     * @return Object|null
     */
    public static function getObjectFromXmlString(string $xmlString)
    {
        $response = null;
        $dom = Helper::getDomDocument($xmlString);
        $version = Helper::identifyVersion($dom);

        if (Helper::isVersion33($version)) {
            $response = Cfdi33::xmlToJson($xmlString);
        }

        if (Helper::isVersion40($version)){
            $response = Cfdi40::xmlToJson($xmlString);
        }

        return $response;
    }

}
