<?php

# Collectd Sensors plugin

require_once 'conf/common.inc.php';
require_once 'type/Default.class.php';

## LAYOUT
# disk-XXXX/
# disk-XXXX/fanspeed-XXXX.rrd
# disk-XXXX/temerature-XXXX.rrd
# disk-XXXX/voltage-XXXX.rrd

# grouped
require_once 'inc/collectd.inc.php';
$tinstance = collectd_plugindetail($host, $plugin, 'ti', array('t' => $type));

$obj = new Type_Default;
$obj->datadir = $CONFIG['datadir'];
$obj->args = array(
	'host' => $host,
	'plugin' => $plugin,
	'pinstance' => $pinstance,
	'type' => $type,
	'tinstance' => $tinstance,
);
$obj->data_sources = array('value');
$obj->ds_names = array(
	'value' => 'Value  ',
);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->seconds = $seconds;
switch($type) {
	case 'fanspeed':
		$obj->colors = '00ff00';
		$obj->rrd_title = sprintf('Fanspeed (%s)', $pinstance);
		$obj->rrd_vertical = 'RPM';
		$obj->rrd_format = '%5.1lf';
	break;
	case 'temperature':
		$obj->colors = '0000ff';
		$obj->rrd_title = sprintf('Temperature (%s)', $pinstance);
		$obj->rrd_vertical = 'Celius';
		$obj->rrd_format = '%5.1lf%s';
	break;
	case 'voltage':
		$obj->colors = 'ff0000';
		$obj->rrd_title = sprintf('Voltage (%s)', $pinstance);
		$obj->rrd_vertical = 'Volt';
		$obj->rrd_format = '%5.1lf';
	break;
}

collectd_flush(ident_from_args($obj->args));

$obj->rrd_graph();

?>
