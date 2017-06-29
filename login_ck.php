<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 

<?

include "conf.php";

	
	//main.html에서 넘어온 값
	$n_id=$_POST['input_1'];
	$n_pw=$_POST['input_2'];
	//$n_pw=password_hash($pw=$_POST['input_2'], PASSWORD_BCRYPT); //비밀번호를 암호화
	
	//입력된 아이디가 있는지 확인
	$sql = "
			select count(rec_key) from nurse2016_nurse where n_id='$n_id'
		   ";
	$result = @mysql_query($sql);
	$login_id = mysql_result($result, 0);

	//결과가 1이 아니면(아이디가 없으면)
	if($login_id!=1){
		
		//아이디 확인
		echo "	<script language=\"JavaScript\">
				alert('등록된 아이디가 없습니다');
				alert('kimyc3766@gmail.com으로 문의해주세요'); 		
				history.go(-1);
				</script>
			";
						
	} 

	else {
		//입력된 아이디에 대한 데이터 불러오기
		$result = mysql_query("select rec_key, n_id, n_pw, n_organ, n_level from nurse2016_nurse where n_id='$n_id'" , $db_info); 
		$row = mysql_fetch_array($result);
		$n_pwck =  $row['n_pw'];
	} 

	//로그인창에 입력된 비밀번호와 데이터베이스에 입력된 비밀번호가 일치하지 않으면	
	if($n_pwck!=$n_pw){
		echo "	<script language=\"JavaScript\">
				alert('비밀번호가 틀렸습니다');
				alert('kimyc3766@gmail.com으로 문의해주세요'); 		
				history.go(-1);
				</script>
			";			
	}

	else {
		//아이디와 비밀번호가 일치하면 세션 시작
		session_start();

		$_SESSION['sess_rec_key']=$row['rec_key'];
		$_SESSION['sess_id']=$row['n_id'];
		$_SESSION['sess_organ']=$row['n_organ'];
		$_SESSION['sess_level']=$row['n_level'];


		//sess_level이 0이면(관리자이면) 관리자 화면을 보여주고 1이면 메인화면을 보여준다.
		if($_SESSION['sess_level']==0)	
			 echo("<meta http-equiv=\"Refresh\" content=\"0;URL=main_admin.php\">");
		else echo("<meta http-equiv=\"Refresh\" content=\"0;URL=index.html\">");		
	}
 
 

/*
 if (password_verify($password, $hash)) {
   
} else {
   
}
 */
 
 
 
 ?>
