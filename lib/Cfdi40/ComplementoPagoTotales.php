<?php

namespace Lib\Cfdi40;


use Lib\Helper;

class ComplementoPagoTotales
{
	public $TotalRetencionesIVA;
	public $TotalRetencionesISR;
	public $TotalRetencionesIEPS;
	public $TotalTrasladosBaseIVA16;
	public $TotalTrasladosImpuestoIVA16;
	public $TotalTrasladosBaseIVA8;
	public $TotalTrasladosImpuestoIVA8;
	public $TotalTrasladosBaseIVA0;
	public $TotalTrasladosImpuestoIVA0;
	public $TotalTrasladosBaseIVAExento;
    public $MontoTotalPagos;

	public static function getTotales($totales)
	{
		$doc = self::getNode($totales);
		
		if (! empty($doc)) {
			$dr = new ComplementoPagoTotales();
			$dr->TotalRetencionesIVA = Helper::getAttr('TotalRetencionesIVA', $doc);
			$dr->TotalRetencionesISR = Helper::getAttr('TotalRetencionesISR', $doc);
			$dr->TotalRetencionesIEPS = Helper::getAttr('TotalRetencionesIEPS', $doc);
			$dr->TotalTrasladosBaseIVA16 = Helper::getAttr('TotalTrasladosBaseIVA16', $doc);
			$dr->TotalTrasladosImpuestoIVA16 = Helper::getAttr('TotalTrasladosImpuestoIVA16', $doc);
			$dr->TotalTrasladosBaseIVA8 = Helper::getAttr('TotalTrasladosBaseIVA8', $doc);
			$dr->TotalTrasladosImpuestoIVA8 = Helper::getAttr('TotalTrasladosImpuestoIVA8', $doc);
			$dr->TotalTrasladosBaseIVA0 = Helper::getAttr('TotalTrasladosBaseIVA0', $doc);
			$dr->TotalTrasladosImpuestoIVA0 = Helper::getAttr('TotalTrasladosImpuestoIVA0', $doc);
			$dr->TotalTrasladosBaseIVAExento = Helper::getAttr('TotalTrasladosBaseIVAExento', $doc);
			$dr->MontoTotalPagos = Helper::getAttr('MontoTotalPagos', $doc);

			return $dr;
		}

		return null;
	}

	public static function getNode($totales)
	{
		try {
			return $totales->getElementsByTagName('Totales')[0];
		} catch (\Throwable $e) {
			return null;
		}
	}
}
