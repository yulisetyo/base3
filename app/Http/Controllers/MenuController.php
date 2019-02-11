<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Session;
use DB;

class MenuController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * description 
	 */
	public static function getMenu()
	{
		try {
			
			$rows = Menu::where('active',1)
							->where('is_parent', 1)
							->orderBY('id')
							->orderBY('sequence')
							->get();
			
			$html_out = '';
			
			foreach($rows as $row) {
				if($row->icon_fa != '') {
					if(substr($row->icon_fa, 0, 2) != 'fa' || substr($row->icon_fa, 0, 2) != 'gl') {
						$icon_fa = 'glyphicon glyphicon-chevron-right';
					} else {
						$icon_fa = $row->icon_fa;
					}
				} else {
					$icon_fa = 'glyphicon glyphicon-chevron-right';
				}
				
				if($row->have_child == 0) {
					
					$html_out.= '
						<li class="treeview">
							<a href="/'.$row->link_url.'">
								<i class="'.$icon_fa.'"></i>
								<span>'.$row->title.'</span>
							</a>
						</li>
					';

				} else {
					
					$html_out.= '
						<li class="treeview">
							<a href="">
								<i class="'.$icon_fa.'"></i>
								<span>'.$row->title.'</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-down pull-right"></i>
								</span>
							</a>
							';
					$html_out.= self::childMenu($row->id);
					$html_out.= '
						</li>
					';
				}
			}
			
			return $html_out;
			
		} catch(\Exception $e){
			return $e;
		}
	}
	
	/**
	 * description 
	 */
	public static function childMenu($param)
	{
		try {
			$sesusername = Session::get('username');
			
			if(!isset($param)) {
				$param = 0;
			} 
			
			if($sesusername == 'superadmin') {
				
				$rows = Menu::where('active', 1)
								->where('parent_id', $param)
								->where('is_parent', 0)
								->orderBY('sequence')
								->get();
			} else {
				
				$rows = Menu::where('active', 1)
								->where('parent_id', $param)
								->where('is_parent', 0)
								->where('link_url', '!=', 'user')
								->orderBY('sequence')
								->get();
			}
			
			$html_out = '<ul class="treeview-menu">';
			
			foreach($rows as $row) {
				$html_out.= '<li><a href="/'.$row->link_url.'"><i class="fa fa-angle-left"></i> '.$row->title.'</a></li>';
			}
			
			$html_out.= '</ul>';
			
			return $html_out;
			
		} catch(\Exception $e){
			return $e;
		}
	}
	
	/**
	 * description 
	 */
	public function index()
	{
		$data = [
			'side_menu' => MenuController::getMenu(),
		];
		return view('menu', $data);
	}
	
	/**
	 * description 
	 */
	public function tabel()
	{
		$rows = Menu::where('active', 1)
						->where('is_parent', 1)
						->orderBy('id')
						->get();
		
		if(count($rows) > 0) {
			foreach($rows as $row) {
				$data['data'][] = array(
					'id' => $row->id,
					'title' => $row->title,
					'link_url' => $row->link_url,
					'parent_id' => $row->parent_id,
					'sequence' => $row->sequence,
					'active' => $row->active,
				);
			}
			
			return json_encode($data);
		} else {
			throw new \Exception("");
		}
	}
	
	/**
	 * description 
	 */
	public function simpan(Request $request)
	{
		try {
			
			$data = array(
				'title'	=> $request->input('title'),
				'link_url'	=> $request->input('link_url'),
				'is_parent'	=> $request->input('is_parent'),
				'have_child' => $request->input('have_child'),
				'parent_id'	=> $request->input('parent_id'),
				'sequence'	=> $request->input('sequence'),
				'active'	=> $request->input('active'),
				'icon_fa'	=> $request->input('icon_fa'),
			);
			
			$insert = Menu::create($data);
			
			if($insert) {
				return "success";
			} else {
				throw new \Exception("Failed");
			}
			
		} catch(\Exception $e){
			return $e;
		}
		
	}
	
	/**
	 * description 
	 */
	public function pilih($param)
	{
		try {
			$rows = Menu::where('id', $param)->first();
							
			return json_encode($rows);
							
		} catch(\Exception $e){
			return $e;
		}
	}
	
	/**
	 * description 
	 */
	public function ubah(Request $post)
	{
		try {
			
		} catch(\Exception $e){
			
		}
	}
	
	/**
	 * description 
	 */
	public function refMenu($param)
	{
		$row = Menu::where('id', $param)->first();
		//~ dd($row);
		return $row->title;
	}
	
	/**
	 * description 
	 */
	public function pilihDetil($id)
	{
		try {
			$rows = Menu::where('parent_id', $id)
							->where('is_parent', 0)
							->orderBy('sequence')
							->get();
			
			$tabel = '<table cellpadding="1" cellspacing="1" border="0" width="100%">
					<thead>';
			$tabel .= '<tr>
							<th>id</th>
							<th>title</th>
							<th>link url</th>
							<th>urut</th>
						</tr>';
			$tabel .= '</thead>
					<tbody>';
				
			foreach($rows as $row) {
				$tabel .= '<tr>';
				$tabel .= '<td>'.$row->id.'</td>';
				$tabel .= '<td>'.$row->title.'</td>';
				$tabel .= '<td>'.$row->link_url.'</td>';
				$tabel .= '<td>'.$row->urut.'</td>';
				$tabel .= '</tr>';
			}
			
			$tabel .= '</tbody>
				</table>';
			
			return $tabel;
		} catch(\Exception $e){
			return $e;
		}
	}
}
