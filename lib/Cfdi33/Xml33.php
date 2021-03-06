<?php

namespace Lib\Cfdi33;

class Xml33
{
    public $xmlObject = null;
    public $xml = null;
    public $cadena_original;

    /**
     * String XML33
     *
     * @param Comprobante33 $comprobante
     * @return String
     */
    public function __construct(Comprobante33 $comprobante, $preview = false, $keyPemPath = '')
    {
        try {

            #== 10.1 Creación de la variable de tipo DOM, aquí se conforma el XML a timbrar posteriormente.

            $xml = new \DOMDocument('1.0', 'UTF-8');
            $root = $xml->createElement("cfdi:Comprobante");
            $root = $xml->appendChild($root);
            $this->cadena_original = '||';
            $noatt =  array();

            #== 10.2 Se crea e inserta el primer nodo donde se declaran los namespaces ======

            $nameSpaces = self::getNameSpaces($comprobante);
            $this->cargaAtt(
                $root,
                $nameSpaces
            );

            #== 10.3 Rutina de integración de nodos =========================================
            $this->cargaAtt(
                $root,
                array(
                    "Version" => $comprobante->Version,
                    "Serie" => !empty($comprobante->Serie) ? $comprobante->Serie : '',
                    "Folio" => $comprobante->Folio,
                    "Fecha" => $comprobante->Fecha,
                    "FormaPago" => $comprobante->FormaPago,
                    "NoCertificado" => $comprobante->NoCertificado,
                    "CondicionesDePago" => $comprobante->CondicionesDePago,
                    "SubTotal" => $comprobante->SubTotal,
                    "Descuento" => $comprobante->Descuento,
                    "Moneda" => $comprobante->Moneda,
                    "TipoCambio" => $comprobante->TipoCambio,
                    "Total" => $comprobante->Total,
                    "TipoDeComprobante" => $comprobante->TipoDeComprobante,
                    "MetodoPago" => $comprobante->MetodoPago,
                    "LugarExpedicion" => $comprobante->LugarExpedicion
                )
            );

            #== 10.3.1 Se integran los datos relacionados

            if (!empty($comprobante->Relacionados)) {
                $relac = $xml->createElement("cfdi:CfdiRelacionados");
                $relac = $root->appendChild($relac);
                $this->cargaAtt($relac, array("TipoRelacion" => $comprobante->Relacionados->TipoRelacion));
                foreach ($comprobante->Relacionados->Relacionado as $relacionado) {
                    $relacUUID = $xml->createElement("cfdi:CfdiRelacionado");
                    $relacUUID = $relac->appendChild($relacUUID);

                    $this->cargaAtt($relacUUID, array("UUID" => $relacionado->UUID));
                }
            }

            #== 10.3.1 Se integran los datos del emisor

            $emisor = $xml->createElement("cfdi:Emisor");
            $emisor = $root->appendChild($emisor);
            $this->cargaAtt(
                $emisor,
                array(
                    "Rfc" => $comprobante->Emisor->Rfc,
                    "Nombre" => $this->utf8toiso8859($comprobante->Emisor->Nombre),
                    "RegimenFiscal" => $comprobante->Emisor->RegimenFiscal
                )
            );

            #== 10.3.2 Se integran los dato del receptor

            $receptor = $xml->createElement("cfdi:Receptor");
            $receptor = $root->appendChild($receptor);
            $this->cargaAtt(
                $receptor,
                array(
                    "Rfc" => $comprobante->Receptor->Rfc,
                    "Nombre" => $this->utf8toiso8859($comprobante->Receptor->Nombre),
                    "UsoCFDI" => $comprobante->Receptor->UsoCFDI
                )
            );

            #== 10.4 Se integran el nodo conceptos

            $conceptos = $xml->createElement("cfdi:Conceptos");
            $conceptos = $root->appendChild($conceptos);
            foreach ($comprobante->Conceptos as $con) {
                #== 10.4.1.1 Nodo concepto
                $concepto = $xml->createElement("cfdi:Concepto");
                $concepto = $conceptos->appendChild($concepto);
                $arrConceptParams = array(
                    "ClaveProdServ" => $con->ClaveProdServ,
                    "NoIdentificacion" => $con->NoIdentificacion,
                    "Cantidad" => $con->Cantidad,
                    "ClaveUnidad" => $con->ClaveUnidad,
                    "Unidad" => $this->utf8toiso8859($con->Unidad),
                    "Descripcion" => $this->utf8toiso8859($con->Descripcion),
                    "ValorUnitario" => self::getValorUnitario($comprobante, $con),
                    "Importe" => self::getImporte($comprobante, $con),
                );
                #== Valida si puede cargar el descuento
                if (self::canLoadDiscount($comprobante)) {
                    $arrConceptParams['Descuento'] = !empty($con->Descuento)
                        ? number_format($con->Descuento, 2, '.', '')
                        : "0.00";
                }

                $this->cargaAtt(
                    $concepto,
                    $arrConceptParams
                );

                #== 10.4.1.2 Nodo Impuestos
                if (count($con->Impuestos->Traslados ?? []) > 0 || count($con->Impuestos->Retenciones ?? []) > 0) {
                    $impuestos = $xml->createElement("cfdi:Impuestos");
                    $impuestos = $concepto->appendChild($impuestos);
                    if (count($con->Impuestos->Traslados) > 0) {
                        #== 10.4.1.3 Nodo Traslados
                        $Traslados = $xml->createElement("cfdi:Traslados");
                        $Traslados = $impuestos->appendChild($Traslados);
                        foreach ($con->Impuestos->Traslados as $trase) {
                            #== 10.4.1.4 Nodo Traslado
                            $Traslado = $xml->createElement("cfdi:Traslado");
                            $Traslado = $Traslados->appendChild($Traslado);

                            $this->cargaAtt(
                                $Traslado,
                                array(
                                    "Base" => number_format($trase->Base, 2, '.', ''),
                                    "Impuesto" => $trase->Impuesto,
                                    "TipoFactor" => $trase->TipoFactor,
                                    "TasaOCuota" => $trase->TasaOCuota,
                                    "Importe" => number_format($trase->Importe, 2, '.', '')
                                )
                            );
                        }
                    }

                    if (count($con->Impuestos->Retenciones ?? []) > 0) {
                        #== 10.4.1.5 Nodo Retenciones
                        $Retenciones = $xml->createElement("cfdi:Retenciones");
                        $Retenciones = $impuestos->appendChild($Retenciones);


                        foreach ($con->Impuestos->Retenciones as $reti) {
                            #== 10.4.1.6 Nodo Retencion
                            $Retencion = $xml->createElement("cfdi:Retencion");
                            $Retencion = $Retenciones->appendChild($Retencion);
                            $this->cargaAtt(
                                $Retencion,
                                array(
                                    "Base" => number_format($reti->Base, 2, '.', ''),
                                    "Impuesto" => $reti->Impuesto,
                                    "TipoFactor" => $reti->TipoFactor,
                                    "TasaOCuota" => $reti->TasaOCuota,
                                    "Importe" => number_format($reti->Importe, 2, '.', '')
                                )
                            );
                        }
                    }


                    if ($con->CuentaPredial != null) {
                        $Cve_catastral = $xml->createElement("cfdi:CuentaPredial");
                        $Cve_catastral = $concepto->appendChild($Cve_catastral);

                        $this->cargaAtt(
                            $Cve_catastral,
                            array("Numero" => $con->CuentaPredial->Numero)
                        );
                    }
                }
            }


            if (self::canLoadTaxesResume($comprobante)) {
                #== 10.5 Impuestos
                $Impuestos = $xml->createElement("cfdi:Impuestos");
                $Impuestos = $root->appendChild($Impuestos);

                if (count($comprobante->Impuestos->Retenciones ?? []) > 0) {
                    $Retenciones = $xml->createElement("cfdi:Retenciones");
                    $Retenciones = $Impuestos->appendChild($Retenciones);

                    foreach ($comprobante->Impuestos->Retenciones as $ret) {
                        $Retencion = $xml->createElement("cfdi:Retencion");
                        $Retencion = $Retenciones->appendChild($Retencion);
                        $this->cargaAtt(
                            $Retencion,
                            array(
                                "Impuesto" => $ret->Impuesto,
                                "Importe" => number_format($ret->Importe, 2, '.', '')
                            )
                        );
                    }

                    $this->cargaAtt(
                        $Impuestos,
                        array(
                            "TotalImpuestosRetenidos" => number_format($comprobante->Impuestos->TotalImpuestosRetenidos, 2, '.', '')
                        )
                    );
                }

                if (count($comprobante->Impuestos->Traslados ?? []) > 0) {
                    $Traslados = $xml->createElement("cfdi:Traslados");
                    $Traslados = $Impuestos->appendChild($Traslados);

                    foreach ($comprobante->Impuestos->Traslados as $tras) {
                        $Traslado = $xml->createElement("cfdi:Traslado");
                        $Traslado = $Traslados->appendChild($Traslado);

                        $this->cargaAtt(
                            $Traslado,
                            array(
                                "Impuesto" => $tras->Impuesto,
                                "TipoFactor" => $tras->TipoFactor,
                                "TasaOCuota" => $tras->TasaOCuota,
                                "Importe" => number_format($tras->Importe, 2, '.', '')
                            )
                        );
                    }

                    $this->cargaAtt(
                        $Impuestos,
                        array(
                            "TotalImpuestosTrasladados" => number_format($comprobante->Impuestos->TotalImpuestosTrasladados, 2, '.', '')
                        )
                    );
                }
            }

            #== 10.6 Complemento
            $complemento = $xml->createElement("cfdi:Complemento");
            $complemento = $root->appendChild($complemento);

            if (!empty($preview)) {
                $tfd = $xml->createElement("tfd:TimbreFiscalDigital");
                $tfd->setAttribute("Version", '1.1');
                $tfd->setAttribute("UUID", 'test');
                $tfd->setAttribute("FechaTimbrado", 'N/A');
                $tfd->setAttribute("RfcProvCertif", 'N/A');
                $tfd->setAttribute("SelloCFD", 'N/A');
                $tfd->setAttribute("NoCertificadoSAT", 'N/A');
                $tfd->setAttribute("SelloSAT", 'N/A');
                $complemento->appendChild($tfd);
            }

            if (empty($preview) && isset($comprobante->Complemento->TimbreFiscalDigital)) {
                $tfdO = $comprobante->Complemento->TimbreFiscalDigital; 
                $tfd = $xml->createElement("tfd:TimbreFiscalDigital");
                $tfd->setAttribute("Version", $tfdO->Version?? 'N/A');
                $tfd->setAttribute("UUID", $tfdO->UUID?? 'N/A');
                $tfd->setAttribute("FechaTimbrado", $tfdO->FechaTimbrado?? 'N/A');
                $tfd->setAttribute("RfcProvCertif", $tfdO->RfcProvCertif?? 'N/A');
                $tfd->setAttribute("SelloCFD", $tfdO->SelloCFD?? 'N/A');
                $tfd->setAttribute("NoCertificadoSAT", $tfdO->NoCertificadoSAT?? 'N/A');
                $tfd->setAttribute("SelloSAT", $tfdO->SelloSAT?? 'N/A');
                $complemento->appendChild($tfd);
            }

            #== Complemento de pagos
            if (isset($comprobante->Complemento->Pagos->Pago)) {
                $pagosComplemento = $xml->createElement("pago10:Pagos");
                $pagosComplemento = $complemento->appendChild($pagosComplemento);
                $this->cargaAtt($pagosComplemento, array(
                    'Version' => $comprobante->Complemento->Pagos->Version
                ));
                foreach ($comprobante->Complemento->Pagos->Pago as $pago) {
                    #== 10.4.1.1 Nodo concepto
                    $pagox = $xml->createElement("pago10:Pago");
                    $pagox = $pagosComplemento->appendChild($pagox);
                    $this->cargaAtt($pagox, array(
                        'FechaPago' => $pago->FechaPago,
                        'FormaDePagoP' => $pago->FormaDePagoP,
                        'MonedaP' => $pago->MonedaP,
                        'Monto' => $pago->Monto,
                        'RfcEmisorCtaOrd' => $pago->RfcEmisorCtaOrd,
                        'NomBancoOrdExt' => $pago->NomBancoOrdExt,
                        'CtaOrdenante' => $pago->CtaOrdenante
                    ));

                    if (count($pago->DoctoRelacionados) > 0) {
                        foreach ($pago->DoctoRelacionados as $docto) {
                            $pagosDocto = $xml->createElement("pago10:DoctoRelacionado");
                            $pagosDocto = $pagox->appendChild($pagosDocto);
                            $this->cargaAtt($pagosDocto, array(
                                'IdDocumento' => $docto->IdDocumento,
                                'MonedaDR' => $docto->MonedaDR,
                                'MetodoDePagoDR' => $docto->MetodoDePagoDR,
                                'NumParcialidad' => $docto->NumParcialidad,
                                'ImpSaldoAnt' => $docto->ImpSaldoAnt,
                                'ImpPagado' => $docto->ImpPagado,
                                'ImpSaldoInsoluto' => $docto->ImpSaldoInsoluto
                            ));
                        }
                    }
                }
            }

            $this->cadena_original .= "|";

            $sello = !empty($keyPemPath)
                ? $this->sello($keyPemPath)
                : $comprobante->Sello;

            $root->setAttribute("Sello", $sello);
            #== 10.8 Certificado
            $root->setAttribute("Certificado", $comprobante->Certificado);


            #=== 10.12 Se guarda el archivo .XML antes de ser timbrado =======================
            $this->xmlObject = $xml;
            $this->xml = $xml->saveXML();
        } catch (\Exception $e) {
            $this->xml = null;
        }
    }

    /**
     * Validates whether or not you can load the discount
     * according to the type of cfdi
     *
     * @param Comprobante33 $comp
     * @return boolean
     */
    public static function canLoadDiscount(Comprobante33 $comp)
    {
        $arr = ['T', 'P'];
        $response = true;
        if (in_array($comp->TipoDeComprobante, $arr)) {
            $response = false;
        }
        return $response;
    }

    /**
     * Validates whether or not you can load taxes resume
     *
     * @param Comprobante33 $comp
     * @return boolean
     */
    public static function canLoadTaxesResume(Comprobante33 $comp)
    {
        $arr = ['T', 'P', 'N'];
        $response = true;
        if (in_array($comp->TipoDeComprobante, $arr)) {
            $response = false;
        }
        return $response;
    }

    /**
     * Get valor unitario
     *
     * @param Comprobante33 $comp
     * @param Concepto33 $con
     * @return String
     */
    public static function getValorUnitario(Comprobante33 $comp, Concepto33 $con) : string
    {
        $valorUnitario = number_format($con->ValorUnitario, 2, '.', '');
        $type = $comp->TipoDeComprobante;

        switch ($type) {
            case 'P':
                $valorUnitario = "0";
                break;
            default:
                # code...
                break;
        }

        return $valorUnitario;
    }

    /**
     * Get ValorUnitario
     *
     * @param Comprobante33 $comp
     * @param Concepto33 $con
     * @return String
     */
    public static function getImporte(Comprobante33 $comp, Concepto33 $con) : string
    {
        $importe = number_format($con->Importe, 2, '.', '');
        $type = $comp->TipoDeComprobante;

        switch ($type) {
            case 'P':
                $importe = "0";
                break;
            default:
                # code...
                break;
        }

        return $importe;
    }

    /**
     * Calculate sello
     *
     * @param [String] $filePath
     * @return String|null
     */
    public function sello($filePath)
    {
        try {
            $pkeyid = openssl_get_privatekey(file_get_contents($filePath));
            openssl_sign($this->cadena_original, $crypttext, $pkeyid, OPENSSL_ALGO_SHA256);
            openssl_free_key($pkeyid);
            return base64_encode($crypttext);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Assign the "Sello" and generate the XML String again
     *
     * @param [type] $sello
     * @return void
     */
    public function setSello($sello) : void
    {
        $comp = $this->xmlObject->getElementsByTagName('cfdi:Comprobante');
        if (!empty($comp)) {
            $comp[0]->setAttribute("Sello", $sello);
        }
        $this->xml = $this->xmlObject->saveXML();
    }

    /**
     * Get XML namespaces according to the type of cfdi
     *
     * @param Comprobante33 $comp
     * @return Array
     */
    public static function getNameSpaces(Comprobante33 $comp) : Array
    {
        $nameSpaces = [
            "xmlns:cfdi" => "http://www.sat.gob.mx/cfd/3",
            "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance"
        ];

        $type = $comp->TipoDeComprobante;

        switch ($type) {
            case 'I':
            case 'E':
                $nameSpaces["xsi:schemaLocation"] =
                    "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd";
                break;
            case 'P':
                $nameSpaces["xsi:schemaLocation"] =
                    "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/Pagos http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos10.xsd";
                $nameSpaces["xmlns:pago10"] = "http://www.sat.gob.mx/Pagos";
                break;
            default:
                # code...
                break;
        }

        return $nameSpaces;
    }

    /**
     * Load a list attributes in a node
     *
     * @param [type] $nodo
     * @param [type] $attr
     * @return void
     */
    public function cargaAtt(&$nodo, $attr): void
    {
        $quitar = array('sello' => 1, 'noCertificado' => 1, 'certificado' => 1);
        foreach ($attr as $key => $val) {
            $val = preg_replace('/\s\s+/', ' ', $val);
            $val = trim($val);
            if (strlen($val) > 0) {
                $val = utf8_encode(str_replace("|", "/", $val));
                $nodo->setAttribute($key, $val);
                if (!isset($quitar[$key])) {
                    if (
                        substr($key, 0, 3) != "xml" &&
                        substr($key, 0, 4) != "xsi:"
                    ) {
                        $this->cadena_original .= $val . "|";
                    }
                }
            }
        }
    }

    /**
     * Change text encoding
     *
     * @param [String] $string
     * @return String
     */
    public function utf8toiso8859($string)
    {
        $returns = "";
        if (empty($string)) {
            return $returns;
        }
        $UTF8len = array(
            1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,
            1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
            0, 0, 0, 0, 0, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 5, 6
        );
        $pos = 0;
        $antal = strlen($string);

        do {
            $c = ord($string[$pos]);
            $len = $UTF8len[($c >> 2) & 0x3F];
            switch ($len) {
                case 6:
                    $u = $c & 0x01;
                    break;
                case 5:
                    $u = $c & 0x03;
                    break;
                case 4:
                    $u = $c & 0x07;
                    break;
                case 3:
                    $u = $c & 0x0F;
                    break;
                case 2:
                    $u = $c & 0x1F;
                    break;
                case 1:
                    $u = $c & 0x7F;
                    break;
                case 0: /* unexpected start of a new character */
                    $u = $c & 0x3F;
                    $len = 5;
                    break;
            }
            while (--$len && (++$pos < $antal && $c =
                ord($string[$pos]))) {
                if (($c & 0xC0) == 0x80) {
                    $u = ($u << 6) | ($c & 0x3F);
                } else { /* unexpected start of a new character */
                    $pos--;
                    break;
                }
            }
            if ($u <= 0xFF) {
                $returns .= chr($u);
            } else {
                $returns .= '?';
            }
        } while (++$pos < $antal);
        return $returns;
    }
}
