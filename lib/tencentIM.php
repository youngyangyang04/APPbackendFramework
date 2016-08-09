<?php


function signature($account_type, $identifier, $appid_at_3rd,
		$sdk_appid, $expiry_after, $private_key_path)
{
	$command = '/data/www/nginx/html/hanwuji_1/tls/signature'
			. ' '. escapeshellarg($private_key_path)
			. ' ' . escapeshellarg($expiry_after)
			. ' ' . escapeshellarg($sdk_appid)
			. ' ' . escapeshellarg($account_type)
			. ' ' . escapeshellarg($appid_at_3rd)
			. ' ' .escapeshellarg($identifier);
	$ret = exec($command, $out, $status);
	if( $status == -1)
	{
		return null;
	}
	return $out;
}