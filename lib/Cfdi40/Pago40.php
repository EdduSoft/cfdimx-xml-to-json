<?php

namespace Lib\Cfdi40;

use Lib\Helper;

class Pago40
{
	public $FechaPago;
	public $FormaDePagoP;
	public $MonedaP;
	public $Monto;
	public $RfcEmisorCtaOrd;
	public $NomBancoOrdExt;
	public $CtaOrdenante;
	public ?array $DoctoRelacionados;
	public $TipoCambioP;
	public $ImpuestosP;

	public static function getPagos($pago)
	{
		try {

			$pag = new Pago40();
			$pag->FechaPago = Helper::getAttr('FechaPago', $pago);
			$pag->FormaDePagoP = Helper::getAttr('FormaDePagoP', $pago);
			$pag->MonedaP = Helper::getAttr('MonedaP', $pago);
			$pag->Monto = Helper::getAttr('Monto', $pago);
			$pag->RfcEmisorCtaOrd = Helper::getAttr('RfcEmisorCtaOrd', $pago);
			$pag->NomBancoOrdExt = Helper::getAttr('NomBancoOrdExt', $pago);
			$pag->CtaOrdenante = Helper::getAttr('CtaOrdenante', $pago);
			$pag->DoctoRelacionados = DoctoRelacionado40::getDoctos($pago);
			$pag->TipoCambioP = Helper::getAttr('TipoCambioP', $pago);
			$pag->ImpuestosP = ImpuestosP40::getImpuestos($pago);

			return $pag;
		} catch (\Exception $e) {
			return null;
		}
	}
}
