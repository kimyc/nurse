<!-- UTF-8 형식으로 저장 -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">


<?

	include "conf.php";

	//세션 시작
	session_start();

	//로그인한 간호사의 정보를 변수에 저장
	$n_key = $_SESSION['sess_rec_key']; 
	$n_id = $_SESSION['sess_id']; 
	
	//전달받은 값
	$p_key=$_POST['p_key'];
	$p_name=$_POST['p_name'];
	$which_i_m=$_POST['which_i_m'];	
	$input_time=$_POST['input_time'];


 	$sur_1 = implode('&!#', $_POST['sur_1']);
	$sur_2 = implode('&!#', $_POST['sur_2']);	
	$sur_3 = implode('&!#', $_POST['sur_3']);	
	$sur_4 = implode('&!#', $_POST['sur_4']);	
	$sur_5 = implode('&!#', $_POST['sur_5']);	
 
	
	//만약 신규입력이면 insert 아니면 modify
	if($which_i_m == 'i')
	{	
		//DB에 설문 값을 입력
		$sql = "INSERT INTO nurse2016_ck10_view
				(n_key, n_name, p_key, p_name, 

				sur_ck10_1, 		sur_ck10_2, 		sur_ck10_3, 		sur_ck10_4, 		sur_ck10_5, 			
				
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',	
				
				'$sur_1',	'$sur_2',	'$sur_3',	'$sur_4',	'$sur_5',
				
				'$input_time'
				);
		";
		echo $sql;
		
	}

	else
	{	
		//DB에 설문 값을 수정
		$sql = "UPDATE nurse2016_ck10_view SET	 
				n_key = '$n_key',		n_name = '$n_id',	

				sur_ck10_1 = '$sur_1', 		sur_ck10_2 = '$sur_2', 		sur_ck10_3 = '$sur_3', 		sur_ck10_4 = '$sur_4', 		sur_ck10_5 = '$sur_5',

				input_time = '$input_time'				
				WHERE p_key = '$p_key';				
		";
	}
	

	//입력이든, 수정이든 모든 입력값을 백업		
	$sql_bk = "INSERT INTO nurse2016_ck10_view_bk 
				(n_key, n_name, p_key, p_name, 
				
				sur_ck10_1, 		sur_ck10_2, 		sur_ck10_3, 		sur_ck10_4, 		sur_ck10_5, 				
				
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',			
				
				'$sur_1',	'$sur_2',	'$sur_3',	'$sur_4',	'$sur_5',		

				'$input_time'
				);
	"; 
	
	
	
	
//print ($_SESSION["uID"]);
//print_r ($sql); 



$result = mysql_query($sql);
$result_bk = mysql_query($sql_bk);

	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList10_view_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}
 


?>

