<?
include_once './allphpfile/xmlrpc.inc';   //브로그 등록을 위해 네이버에서 제공하는 xml 파일 입니다. asp 버젼에서 가능한지 테스트 바랍니다.



//참고 : http://simulz.kr/zbxe/1868799
function newPost($title, $description, $category, $blid, $blpass){ 
	//네이버는 카테고리, 태그값을 아예 받질 않는다..그리고 공란이면 에러나는듯함.
	//네이버는 제목, 내용을 string타입으로 보내야 한다. 남들은 base64인데 이유 모름..
	$g_blog_url = "https://api.blog.naver.com/xmlrpc"; 
	$user_id = $blid; 
	$password = $blpass;
	$blogid = $blid;

	$publish = true;//:공개할거냐 안할거냐인데, 네이버의 블로그 설정에 따라 이므로 이건 상관없음(아무렇게나 해도 됨)

	$client = new xmlrpc_client($g_blog_url); // $client변수에 블로그주소를 저장 

	$struct = array( // body (struct변수에 제목, 내용 카테고리, 테그를 배열화해서 넣음) 
					'title'			=> new xmlrpcval($title, "string"), 
					'description'   => new xmlrpcval($description, "string"),
					'categories' => new xmlrpcval($category, "string") 
					);
					

	$f = new xmlrpcmsg("metaWeblog.newPost", 
					   array( 
							  new xmlrpcval($blogid, "string"), // blogid.(블로그아이디) 
							  new xmlrpcval($user_id, "string"), // user ID. (아이디) 
							  new xmlrpcval($password, "string"), // password (비밀번호) 
							  new xmlrpcval($struct , "struct"), 
							  new xmlrpcval($publish, "boolean") //publish... true는 공개, false는 비공개가 된다.
							) 
						); 

	$f->request_charset_encoding = 'UTF-8'; 

	return $response = $client->send($f); // $response에 실행명령삽입($client변수로 블로그 로그인 후 send($f) 글 전달함 
} 







		$tit =  //제목을 저장 //rawurldecode($_POST['tit']); //rawurldecode($tit);
			
		$memo = //내용을 저장 //rawurldecode($_POST['cont']); //rawurldecode($memo);
		$memo = //내용에 줄바꿈을 태그로 처리 //str_replace("\n", "<br />",$memo);
		
		//담당자와 지점의 전화번호를 내용에 추가
		$memo .= "<br><br><div style='width:96%; padding:10px 0; text-align:center; border:#ccc 1px solid;'><span>담당자 : ".trim($_POST['tel'])."</span>"; 
		$memo .= "&nbsp;&nbsp;&nbsp;&nbsp;<span>지점 : ".trim($_POST['cotel'])."</span></div>";
		
		//내용에 이미지의 제목을 추가
		$memo .= "<br><br><div>메인이미지</div>"; //$_POST['img'];

	
		$cate = //카테고리 이름을 변수에 저장 //rawurldecode($_POST['cate']);
	
	
		$ad_date = //오늘 날짜를 저장 //date("Y-m-d");

				
		$imgg = explode("^^", $_POST['img']);  //"^^" 문자로 연결하여  들어온 여러개의 이미지 (예:img1.jpg^^img2.jpg^^img3.jpg^^)를 "^^ 문자를 기준으로 분리하여 $imgg 배열에 저장 //  
		$su = count($imgg) - 1;   //이미지의 갯수를 카운터 한다.
		
		$mm = "";
		//이미지의 갯수 만큼 반복하면서 문자열을 만든다.
		for($c = 0; $c < $su; $c++){
			if($c > 0) $mm .= "<br>이미지".$c."<br>";
			$mm .= "<a href='#'><img src='".$imgg[$c]."' style='width:100%; margin:0 0 10px;'></a><br>";
		}
				
		//위에 정의한 함수에 제목, 내용, 이미지링크 문자열, 네이버 아이디, 네이버 블로그 key(고정된 값) 를 전달하여 블로그에 등록한다.
		newPost($tit, $memo.$mm, $cate, "handeultalk", "9fc275e6f793dbd1090318ae60a19935");	
		
		
		$jsongab = '{"rs":"ok"}';
	



?>