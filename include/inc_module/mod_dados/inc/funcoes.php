<?php

// Remove o acento do endereço
function remover_acentos($string) {

	// Assume ISO-8859-1 if not UTF-8
	$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
	                .chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
	                .chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
	                .chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
	                .chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
	                .chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
	                .chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
	                .chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
	                .chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
	                .chr(252).chr(253).chr(255);
	
	$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
	
	$string = strtr($string, $chars['in'], $chars['out']);
	$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
	$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
	$string = str_replace($double_chars['in'], $double_chars['out'], $string);
	$string = str_replace(' ', '-', $string);

	return strtolower(trim($string));
}

?>