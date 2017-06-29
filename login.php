<!-- UTF-8 형식으로 저장 -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<!-- CSS -->
<link type="text/css" rel="stylesheet" href="./css/core.css">

<!--DB접속정보-->
<? include "conf.php";?>

<html>
<head>
	<title>고려대학교 간호학과</title>
</head>


<script language="javascript">

//입력여부 확인
function checkIt(form){
	
//로그인 창에서 입력한 자바스크립트 변수를 php변수에 저장하기 위한 변수 
var m_id = form.input_1.value;
	
<?


	//체크할 항목수 
	//$max_mun = 1;
	$max_mun = 2;

	for($i=1; $i<=$max_mun; $i++)
	{		

		$input="input_".$i;

		switch($i) 
		{
			//텍스트박스 문항
			case 1:

			echo "
					//입력된 값 보여주기
					//alert(form.".$input.".value);

					if(!form." . $input . ".value)
					{ 
						alert('아이디를 입력해주세요'); 
						return; 
					} 
					
				";
		
		
			break;	
			
			//텍스트박스 문항
			case 2:

			echo "
					//입력된 값 보여주기
					//alert(form.".$input.".value);

					if(!form." . $input . ".value)
					{ 
						alert('비밀번호를 입력해주세요'); 
						return; 
					} 
					
				";
		
		
			break;				

		}	


	}

 ?>
	
	form.submit();
	/*
	if(confirm("작성하신 정보를 제출하시겠습니까?") ) 
	{
		form.submit();
	} 
	
	else
	{
		return;
	}
	*/

}
</script>

	
	<body bgcolor="F3F3F3">
	
	<!-- 본 내용 //-->

	<!--
	<center><font size = 7>시스템 수정중입니다. 입력을 중단해주세요</font></center>
	-->

    <div id="cont-login"">
        <a href="/"><span><font size = "6"><b>노인요양시설 다학제 통합기능케어 시스템</b></font></span></a><br><br>
        <div class="panel panel-default" id="panel-login">
        	<div class="panel-body">
			    <form name="form" action="login_ck.php" method ="POST">	
            
                <p align = "left"><font size=3 align="left"><b>아이디</b></font></p><br>					
				<input type="text" style="display: block; width: 380px; height: 45px; font-size: 16px; margin-bottom: 27px; padding-left: 10px;" name="input_1"><font size=2><b></b></font>
				
				<p align = "left"><font size=3 align="left"><b>비밀번호</b></font></p><br>                   
                <input type="password" style="display: block; width: 380px; height: 45px; font-size: 16px; margin-bottom: 27px; padding-left: 10px;" name="input_2"><font size=2><b></b></font>                                    

          		<button type="button" OnClick="checkIt(this.form)" style="cursor:hand; border:0;text-align:left"><img  src="./img/btn_login.png"  border="0" width="146"; height="44"></button>
				</form>	
            </div>  			
        </div>
        <br>

		<div>
			<p align = "center">
				<a href="https://www.google.co.kr/chrome/browser/desktop/"><img src="./img/btn_chrome.png" align="center" width="244" height="40"></a>
			</p>
		</div>

	</div>
	

	</body>
	
</html>



