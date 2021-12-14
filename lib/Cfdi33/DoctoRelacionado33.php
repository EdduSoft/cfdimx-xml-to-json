<?php

namespace Lib\Cfdi33;

use Lib\Helper;

class DoctoRelacionado33
{
	public $IdDocumento;
	public $MonedaDR;
	public $MetodoDePagoDR;
	public $NumParcialidad;
	public $ImpSaldoAnt;
	public $ImpPagado;
	public $ImpSaldoInsoluto;
	public $TipoCambioDR;

	public static function getDoctos($pago)
	{
		$docs = self::getNode($pago);
		$arr = [];
		foreach ($docs as $doc) {
			$dr = new DoctoRelacionado33();
			$dr->IdDocumento = Helper::getAttr('IdDocumento', $doc);
			$dr->MonedaDR = Helper::getAttr('MonedaDR', $doc);
			$dr->MetodoDePagoDR = Helper::getAttr('MetodoDePagoDR', $doc);
			$dr->NumParcialidad = Helper::getAttr('NumParcialidad', $doc);
			$dr->ImpSaldoAnt = Helper::getAttr('ImpSaldoAnt', $doc);
			$dr->ImpPagado = Helper::getAttr('ImpPagado', $doc);
			$dr->ImpSaldoInsoluto = Helper::getAttr('ImpSaldoInsoluto', $doc);
			$dr->TipoCambioDR = Helper::getAttr('TipoCambioDR', $doc);
			array_push($arr, $dr);
		}
		return $arr;
	}

	public static function getNode($pago)
	{
		try {
			return $pago->getElementsByTagName('DoctoRelacionado');
		} catch (\Throwable $e) {
			return [];
		}
	}
}
