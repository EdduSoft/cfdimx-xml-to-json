<?php

namespace App\Test;

require_once __DIR__ . "../../vendor/autoload.php";
use PHPUnit\Framework\TestCase;

use Lib\Cfdi40\Xml40;
use Lib\Cfdi40\Cfdi40;

class XmlToJsonPagos40Test extends TestCase
{
    /**
     * Test cfdi 40 xml to json
     *
     * @return void
     */
    public function testXmlPagos40ToJson()
    {
        # Complemento Pago 001
        $pago01 = $this->getCfdi40("/../assets/40/complemento_pagos_v2_001.xml");
        echo json_encode($pago01, JSON_PRETTY_PRINT);
        $this->assertNotNull($pago01);
        $xml = new Xml40($pago01, false, '');
        echo $xml->xml;
        $this->assertNotNull($xml->xml);
        $this->assertNotNull($pago01->Complemento->Pagos->Totales);
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