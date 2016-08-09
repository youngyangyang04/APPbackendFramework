<?php
namespace model;
use model\mod_base;
class mod_QRcode extends mod_base{
	function mod_create_QRcode_by_phone($phone,$QRcode)
	{
		$conn = $this->db_conn();
		$sql = mysql_query("update user set QRcode='$QRcode' where phone='$phone'",$conn);
		return 1;
	}
}

?>