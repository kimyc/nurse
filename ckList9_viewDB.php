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

	$index = 1;

	//설문문항 개수
	$max=3;

	for($i=1; $i<=$max ; $i++){
		$sur= "sur_".$i;	
		
		switch($i) {	
			case 1:
			case 2:
			case 3:

			$field = $sur;
			$sur_frm[$index++] = trim($_POST[$field]);		
		break;	
		}

	}


 
	//만약 신규입력이면 insert 아니면 modify
	if($which_i_m == 'i')
	{	
		//DB에 설문 값을 입력
		$sql = "INSERT INTO nurse2016_ck9_view
				(n_key, n_name, p_key, p_name, 
				sur_ck9_1, 		sur_ck9_2, 		sur_ck9_3, 			
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',								
				'$sur_frm[1]',		'$sur_frm[2]',		'$sur_frm[3]',
				'$input_time'
				);
		";
		//echo $sql;
		
	}

	else
	{	
		//DB에 설문 값을 수정
		$sql = "UPDATE nurse2016_ck9_view SET	 
				n_key = '$n_key',		n_name = '$n_id',	
				
				sur_ck9_1 = '$sur_frm[1]', 		sur_ck9_2 = '$sur_frm[2]', 		sur_ck9_3 = '$sur_frm[3]',
				input_time = '$input_time'
				
				WHERE p_key = '$p_key';				
		";
	}
	

	//입력이든, 수정이든 모든 입력값을 백업		
	$sql_bk = "INSERT INTO nurse2016_ck9_view_bk 
				(n_key, n_name, p_key, p_name, 
				sur_ck9_1, 		sur_ck9_2, 		sur_ck9_3, 			
				input_time
				)
				
				VALUES
		
				('$n_key', '$n_id', '$p_key', '$p_name',								
				'$sur_frm[1]',		'$sur_frm[2]',		'$sur_frm[3]',
				'$input_time'
				);
	"; 
	
	
	
	
//print ($_SESSION["uID"]);
//print_r ($sql); 



$result = mysql_query($sql);
$result_bk = mysql_query($sql_bk);

	if($result){
		echo "<script language='javaScript'>     
				
                document.location.href='ckList9_view_modify.php?p_key=$p_key';
			</script>";
	}else{
		 echo "<script language='javaScript'>
                alert('DB오류입니다.\\n잠시후에 다시 시도해 주세요');
                document.location.href='main.php';
				</script>";
	}
 


?>

