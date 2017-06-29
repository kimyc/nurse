<!-- UTF-8 형식으로 저장 -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<!-- CSS -->
<link type="text/css" rel="stylesheet" href="./css/core.css">


<html>
<head>
	<title>고려대학교 간호학과</title>
</head>



<script language="javascript">
//입력여부 확인
function checkIt(form){

alert(form.input_1.value);
<?
/*
		

	//설문문항개수
	//$max_mun = 1;
	$max_mun = 2;

	for($i=1; $i<=$max_mun; $i++)
	{		

		$input="input_".$i;

		switch($i) 
		{
			//텍스트박스 문항
			case 1:
			case 2:

			echo "
					//입력된 값 보여주기
					//alert(form.".$input.".value);

					if(!form." . $input . ".value)
					{ 
						alert('" . $i . " 번 질문에 해당하는 답을 입력하지 않으셨습니다!'); 
						return; 
					} 
					
				";
		
		
			break;	

		}	


	}
*/
?>

		if(confirm("작성하신 정보를 제출하시겠습니까?") ) 
	{
		form.submit();
	} 
	
	else
	{
		return;
	}
 
}
</script>

	
	<body style="background-image: url('./img/bg01.jpg'); background-size: 100%;">
	
	<!-- 본 내용 //-->
	
	
    <div id="cont-login">
        <a href="/"><span id="login-h1">Nursing System</span></a>
        <div class="panel panel-default" id="panel-login">
        	
        	<form name="form" action="db.php" method ="POST">	
        	
        	<div class="panel-body">
			    
            
                <label for="id">이메일</label>					
				<input type="text" style="display: block; width: 380px; height: 45px; font-size: 16px; margin-bottom: 27px; padding-left: 10px;" name="input_1"><font size=2><b></b></font>
				
				<label for="pw">비밀번호</label>                    
                <input type="password" style="display: block; width: 380px; height: 45px; font-size: 16px; margin-bottom: 27px; padding-left: 10px;" name="input_2"><font size=2><b></b></font>                                    
 </div>  
          		<button type="button" OnClick="checkIt(this.form)" style="cursor:hand; border:0;text-align:left"><img  src="./img/btn_login.png"  border="0" width="146"; height="44"></button>
				</form>	
           			
			            
        </div>
        <br>

    </div>

	
	
<!--

	<div id="cont-login">
		<a href="/"><span id="login-h1">Roots</span></a>
		<div class="panel panel-default" id="panel-login">
	
	

			<form name="form" action="db.php" method ="POST">		

		
			<div class="panel-body">
					<label for="id">이메일</label>					
					<input type="text" style="display: block; width: 380px; height: 45px; font-size: 16px; margin-bottom: 27px; padding-left: 10px;" name="input_1"><font size=2><b></b></font>
					
					<label for="password">비밀번호</label>                    
                    <input type="password" style="display: block; width: 380px; height: 45px; font-size: 16px; margin-bottom: 27px; padding-left: 10px;" name="input_2"><font size=2><b></b></font>
                    
					
					<button type="button" OnClick="checkIt(this.form)" style="cursor:hand; border:0;"><img  src="./img/btn_login.png"  border="0" width="146"; height="44"></button>
						
		
		
				</div>		
		
			</form>

		
		
		</div>
	</div>

-->

	</body>

	
</html>



