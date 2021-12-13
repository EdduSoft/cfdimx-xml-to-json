<?php

namespace App\Test;

require_once __DIR__ . "../../vendor/autoload.php";
use PHPUnit\Framework\TestCase;

use Lib\Cfdi33\Cfdi33;
use Lib\Cfdi40\Cfdi40;

class xmlToJsonTest extends TestCase
{
    /**
     * Test cfdi 33 xml to json
     *
     * @return void
     */
    public function testXml33ToJson()
    {
        # Normail cfdi
        $normal = $this->getCfdi33("../../assets/33/facturacion_normal.xml");
        echo json_encode($normal, JSON_PRETTY_PRINT);
        $this->assertNotNull($normal);

        # Payment complement
        $comp = $this->getCfdi33("../../assets/33/complemento_pago.xml");
        echo json_encode($comp, JSON_PRETTY_PRINT);
        $this->assertNotNull($comp);

        # Credit note
        $note = $this->getCfdi33("../../assets/33/nota_credito.xml");
        echo json_encode($note, JSON_PRETTY_PRINT);
        $this->assertNotNull($note);

        # Substitution
        $sus = $this->getCfdi33("../../assets/33/sustitucion.xml");
        echo json_encode($sus, JSON_PRETTY_PRINT);
        $this->assertNotNull($sus);

        # TODO:
        # Nomina
    }

    /**
     * Test cfdi 40 xml to json
     *
     * @return void
     */
    public function testXml40ToJson()
    {
        # Normail cfdi
        $normal = $this->getCfdi40("../../assets/33/facturacion_normal.xml");
        echo json_encode($normal, JSON_PRETTY_PRINT);
        $this->assertNotNull($normal);

        # Payment complement
        $comp = $this->getCfdi40("../../assets/33/complemento_pago.xml");
        echo json_encode($comp, JSON_PRETTY_PRINT);
        $this->assertNotNull($comp);

        # Credit note
        $note = $this->getCfdi40("../../assets/33/nota_credito.xml");
        echo json_encode($note, JSON_PRETTY_PRINT);
        $this->assertNotNull($note);

        # Substitution
        $sus = $this->getCfdi40("../../assets/33/sustitucion.xml");
        echo json_encode($sus, JSON_PRETTY_PRINT);
        $this->assertNotNull($sus);
    }

    /**
     * Test to get empty object from comprobante33
     *
     * @return void
     */
    public function testEmptyComprobate33()
    {
        $empty = Cfdi33::getComprobante();
        $this->assertNotNull($empty);
    }

    public function getCfdi33($path)
    {
        return Cfdi33::xmlToJson(
            file_get_contents(__DIR__ . $path)
        );
    }

    public function getCfdi40($path)
    {
        return Cfdi40::xmlToJson(
            file_get_contents(__DIR__ . $path)
        );
    }

}