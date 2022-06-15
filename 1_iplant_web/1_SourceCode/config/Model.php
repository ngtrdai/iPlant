<?php 
    class Model{
        public function fetch($sql){
			global $con;
			$result = mysqli_query($con,$sql);
			$arr = array();
			while($rows = mysqli_fetch_array($result))
				$arr[] = $rows;
			return $arr;
		}
		
		public function fetchOne($sql){
			global $con;
			$result = mysqli_query($con,$sql);
			$rows = mysqli_fetch_array($result);
			return $rows;
		}

		public function execute($sql){
			global $con;
			mysqli_query($con,$sql);
		}

		public function count($sql){
			global $con;
			$result = mysqli_query($con,$sql);
			return mysqli_num_rows($result);
		}

		public function getId($idName, $tblName){
			global $con;
			$result = mysqli_query($con,"select $idName from $tblName order by $idName desc limit 0,1");
			$rows = mysqli_fetch_array($result);
			return $rows;
		}

		public function getEnum($tableName, $fieldName){
			global $con;
			$type = mysqli_query($con, "select COLUMN_TYPE from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='$tableName' and COLUMN_NAME='$fieldName'" );
			$row = mysqli_fetch_array($type);
			$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
            return $enumList;
		}
    }
?>