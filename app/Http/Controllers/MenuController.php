<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Session;
use DB;
use URL;

class MenuController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * description 
	 */
	public function index()
	{
		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
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

	/**
	 * menampilkan menu apliksi yang berada dashboard sebelah kiri
	 * terbagi atas 3 level, level 1 adalah menu utama, level 2 dan level 3 adalah submenu 
	 */
	public static function getMenu()
	{
		//base URL 
		$baseURL = URL::to('/').'/';
		$html = '';

		//query menu level 1
		$ones = Menu::where('active',1)
						->where('category', 1)
						->orderBY('sequence')
						->orderBy('id')
						->get();

		//menampilkan menu level 1
		foreach($ones as $one) {
			
			$icon_fa = $one->icon_fa;
			
			if($one->have_child == 0) {
				// tidak punya submenu
				$html .= '<li>
						      <a href="'.$baseURL.$one->link_url.'">
							      <i class="'.$icon_fa.'"></i> 
								  <span>'.$one->title.'</span> 
							  </a>
						  </li>';
			} else {
				// punya sub menu
				$html .= '<li class="treeview">
						      <a href="#">
								  <i class="'.$icon_fa.'"></i>
								  <span>'.$one->title.'</span>
								  <span class="pull-right-container">
									  <i class="fa fa-angle-down pull-right"></i>
								  </span>
						      </a>';
				$html .= '    <ul class="treeview-menu">';

				//query menu level 2
				$twos = Menu::where('active',1)
								->where('category',2)
								->where('parent_id',$one->id)
								->orderBY('sequence')
								->get();

				//menampilkan menu level 2
				foreach($twos as $two) {
					
					$icon_fa = $two->icon_fa;
					
					if($two->have_child == 0) {
						//tidak punya submenu
						$html .= '<li>
									  <a href="'.$baseURL.$two->link_url.'">
									      <i class="'.$icon_fa.'"></i>
									      <span>'.$two->title.'</span>
									  </a></li>';
					} else {
						//punya submenu
						$html .= '<li class="treeview">
						              <a href="#">
										  <i class="'.$icon_fa.'"></i>
										  <span>'.$two->title.'</span>
											  <span class="pull-right-container">
									      <i class="fa fa-angle-down pull-right"></i>
								  </span>
						              </a>';
						$html .= '    <ul class="treeview-menu">';

						//query menu level 3
						$threes = Menu::where('active',1)
										->where('category',3)
										->where('parent_id',$two->id)
										->orderBY('sequence')
										->get();

						//menampilkan menu level 2
						foreach($threes as $three) {
							
							$icon_fa = $three->icon_fa;
							
							$html .= '<li>
										  
										  <a href="'.$baseURL.$three->link_url.'">
											  <i class="'.$icon_fa.'"></i>
											  <span>'.$three->title.'</span>
										  </a>
									  </li>';
						}
						
						$html .= '    </ul>';
						$html .= '</li>';
					}
				}
				
				$html .= '</ul>';
				$html .= '</li>';
			}
		}

		return $html;
	}
}
