<?php

namespace App\Test;

require_once __DIR__ . "../../vendor/autoload.php";

use Lib\Cfdi;
use PHPUnit\Framework\TestCase;

class XmlStringToCfdiObjectTest extends TestCase
{
    /**
     * Test cfdi 40 xml to json
     *
     * @return void
     */
    public function testXmlToObject()
    {
        # Cfdi 33
        $normal = file_get_contents(__DIR__ . "/../assets/33/facturacion_normal.xml");
        echo $normal;
        $obj33 = Cfdi::getObjectFromXmlString($normal);
        echo json_encode($obj33);
        $this->assertNotNull($obj33);
        echo $obj33->Version ?? "";

        # Cfdi 40
        $normal = file_get_contents(__DIR__ . "/../assets/40/facturacion_normal.xml");
        echo $normal;
        $obj40 = Cfdi::getObjectFromXmlString($normal);
        echo json_encode($obj40);
        $this->assertNotNull($obj40);
        echo $obj40->Version ?? "";
    }

}