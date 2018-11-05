<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * 코드이그나이터 한국식 페이징 클래스
 *
 * @author      나상선
 * @describe	README 참조
 */
class Pagination_custom {

	var $total_row		= 	0;			// 총 로우
	var $per_page		= 	20;			// 페이지마다 출력 갯수
	var $view_page		= 	10;			// 한 화면에 보여줄 최대 페이지 갯수
	var $use_end		=	FALSE;

	var $_total_page	= 	0;			// 총 페이지수
	var $_current_url	= 	'';			// 현재 url (페이지 번호 전까지)
	var $_current_page	=	0;			// 페이지 번호
	var $_query_url		=	'';			// 쿼리스트링 필드
	var $_current_block=	'';			// 현재 페이지가 속해있는 블록
	var $_total_block 	=	'';			// 총 블록
	
	public function __construct($param = array()) {
		$CI =& get_instance();
		$CI->load->helper('url');
		
		# 양끝으로 가기 사용여부
		$this->use_end = $param['use_end'];

		# 쿼리스트링
		$this->_query_url = '?'.$CI->input->server('QUERY_STRING');
		

		# url 에서 페이지 번호와 url 분리
		$this->_current_url = base_url();
		$tmp = explode('/', $CI->uri->uri_string());
		for ($i=0; $i < ($param['page_position'] - 1); $i++) { 
			if(! empty($tmp[$i])) {
				$this->_current_url .= $tmp[$i].'/';
			}
		}

		# 설정 값
		$this->total_row 		= 	 $param['total_rows'];
		$this->view_page 		=	 $param['view_page'];
		
		# 총 페이지 및 현재 페이지
		$this->_total_page 		= 	 ceil($param['total_rows'] / $param['per_page']);
		if(! empty($tmp[$param['page_position']])) {
			$this->_current_page = $tmp[$param['page_position']];
		} else {
			$this->_current_page = 1;
		}
		
		
		# 총 블록 및 현재 블록 
		$this->_total_block		=	 ceil($this->_total_page / $this->view_page);
		$this->_current_block	=	 floor(($this->_current_page - 1) / $param['view_page']);
	}



	
	public function create_links() {
		$content = '';
		$content .= '<div class="paginate">';

		if($this->use_end) $content .= $this->first();
		$content .= $this->prev(); //이전 페이지
		$content .= $this->page(); //페이지
		$content .= $this->next(); //다음 페이지
		if($this->use_end) $content .= $this->end();

		$content .= '</div>';


		return $content;
	}
	
	## 이전 페이지 
	private function prev() {
		if($this->_current_block >= 1) {
			# 이전 페이지 계산
			$pre_num = (($this->_current_block) * $this->view_page);
			$make_link = $this->_current_url.'page/'.$pre_num.'/'.$this->_query_url;
			
			# 태그 뿌리기
			return '<a class="pre" href="'.$make_link.'">이전</a>';
		} else {
			return '';
		}
	}


	## 페이지 부분 만들기
	private function page() {
		$page_num = $this->_current_block * $this->view_page;
		$page_content = '';
		for($i=1; $i<=$this->view_page; $i++) {
			$real_page = $page_num + $i;
			if($page_num+$i <= $this->_total_page && $page_num+$i != $this->_current_page) {
				$make_link = $this->_current_url.'page/'.$real_page.'/'.$this->_query_url;
				
				# 태그 뿌리기
				$page_content .= '<a href="'.$make_link.'">'.$real_page.'</a>';
			} else if($page_num+$i <= $this->_total_page && $page_num+$i == $this->_current_page){
				$page_content .= '<strong>'.$real_page.'</strong>';
			}
		}
		return $page_content;
	}

	
	## 다음 페이지
	private function next() {
		if ($this->_current_block < $this->_total_block - 1) {
			# 다음 페이지 계산
			$next_page = ($this->_current_block + 1) * $this->view_page + 1;
			$make_link = $this->_current_url.'page/'.$next_page.'/'.$this->_query_url;
			
			# 태그 뿌리기
			return '<a class="next" href="'.$make_link.'">'.'다음'.'</a>';
		} else {
			return '';
		}
	}


	## 처음으로 가기
	private function first() {
		if($this->_current_block != 0) {
			
			# 태그 뿌리기
			$make_link = $this->_current_url.'page/1/'.$this->_query_url;
			return '<a class="pre" href="'.$make_link.'">'.'처음'.'</a>';
		}
	}


	## 끝 페이지로 가기
	private function end() {
		if($this->_current_block != $this->_total_block - 1) {
			
			# 태그 뿌리기
			$make_link = $this->_current_url.'page/'.$this->_total_page.'/'.$this->_query_url;
			return '<a class="next" href="'.$make_link.'">'.'마지막'.'</a>';
		}
	}
}
