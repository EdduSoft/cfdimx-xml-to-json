<?php

namespace App\Test;

require_once __DIR__ . "../../vendor/autoload.php";
use PHPUnit\Framework\TestCase;

use Lib\Cfdi40\Xml40;
use Lib\Cfdi40\Cfdi40;

class XmlToJson40Test extends TestCase
{
    /**
     * Test cfdi 40 xml to json
     *
     * @return void
     */
    public function testXml40ToJson()
    {
        # Normail cfdi
        $normal = $this->getCfdi40("/../assets/40/facturacion_normal.xml");
        echo json_encode($normal, JSON_PRETTY_PRINT);
        $this->assertNotNull($normal);
        $xml = new Xml40($normal, false, '');
        echo $xml->xml;
        $this->assertNotNull($xml->xml);

        # Global information cfdi
        $infoGlobal = $this->getCfdi40("/../assets/40/infoGlobal.xml");
        echo json_encode($infoGlobal, JSON_PRETTY_PRINT);
        $this->assertNotNull($infoGlobal);
        $xml = new Xml40($infoGlobal, false, '');
        echo $xml->xml;
        $this->assertNotNull($xml->xml);
    }


    /**
     * Test to get empty object from comprobante40
     *
     * @return void
     */
    public function testEmptyComprobate40()
    {
        $empty = Cfdi40::getComprobante();
        $this->assertNotNull($empty);
    }

    public function getCfdi40($path)
    {
        return Cfdi40::xmlToJson(
            file_get_contents(__DIR__ . $path)
        );
    }

}