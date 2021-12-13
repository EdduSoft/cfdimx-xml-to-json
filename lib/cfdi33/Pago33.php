<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class Pago33
{
	public $FechaPago;
	public $FormaDePagoP;
	public $MonedaP;
	public $Monto;
	public $RfcEmisorCtaOrd;
	public $NomBancoOrdExt;
	public $CtaOrdenante;
	public $DoctoRelacionados;

	public static function getPagos($pago)
	{
		try {

			$pag = new Pago33();
			$pag->FechaPago = Helper::getAttr('FechaPago', $pago);
			$pag->FormaDePagoP = Helper::getAttr('FormaDePagoP', $pago);
			$pag->MonedaP = Helper::getAttr('MonedaP', $pago);
			$pag->Monto = Helper::getAttr('Monto', $pago);
			$pag->RfcEmisorCtaOrd = Helper::getAttr('RfcEmisorCtaOrd', $pago);
			$pag->NomBancoOrdExt = Helper::getAttr('NomBancoOrdExt', $pago);
			$pag->CtaOrdenante = Helper::getAttr('CtaOrdenante', $pago);
			$pag->DoctoRelacionados = Helper::getAttr('DoctoRelacionados', $pago);

			return $pag;
		} catch (\Exception $e) {
			return null;
		}
	}
}
